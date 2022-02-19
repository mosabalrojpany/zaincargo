<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Mail\Customers\Activation;
use App\Models\CustomerWallet;
use App\Models\Customer;
use App\Models\PurchaseOrder;
use App\Models\ReceivingPlace;
use App\Models\ShippingInvoice;
use App\Notifications\Customers\UpdateData;
use App\Notifications\Customers\UpdatePassword;
use DB;
use File;
use Illuminate\Http\Request;
use Image;
use Mail;
use \Carbon\Carbon;

class CustomerController extends Controller
{

    /* The beginning of the customer code */
    private $imgPath;
    private $imgAvatarPath;
    private $filePath;

    public function __construct()
    {
        $this->imgPath = public_path('/storage/images/customers/');
        $this->imgAvatarPath = $this->imgPath . 'avatar/';
        $this->filePath = storage_path('app/customers/verifications/');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Customer::select('id', 'code', 'name', 'phone', 'email', 'address', 'img', 'state', 'created_at', 'last_access')->orderBy('state')->latest('created_at');
        /*  Start search    */
        if ($request->search) {

            $this->validate($request, [
                'code' => 'nullable|integer|min:0',
                'receive_in' => 'nullable|integer|min:0',
                'state' => 'nullable|integer|min:0|max:3',
                'name' => 'nullable|string|max:32',
                'phone' => 'nullable|string|max:32',
                'email' => 'nullable|string|max:32',
                'address' => 'nullable|string|max:32',
                'extra' => 'nullable|string|max:32',
                'from' => 'nullable|date',
                'to' => 'nullable|date',
                'activated_from' => 'nullable|date',
                'activated_to' => 'nullable|date',
            ]);
            if ($request->code) {
                $query->where('code', get_customer_code_starts_with() . $request->code);
            }
            if ($request->receive_in) {
                $query->where('receive_in', $request->receive_in);
            }
            if ($request->state) {
                $query->where('state', $request->state);
            }
            if ($request->name) {
                $query->where('name', 'Like', "%$request->name%");
            }
            if ($request->phone) {
                $query->where('phone', 'Like', "%$request->phone%");
            }
            if ($request->email) {
                $query->where('email', 'Like', "%$request->email%");
            }
            if ($request->address) {
                $query->where('address', 'Like', "%$request->address%");
            }
            if ($request->extra) {
                $query->where('extra', 'Like', "%$request->extra%");
            }
            if ($request->from) {
                $query->whereDate('created_at', '>=', $request->from);
            }
            if ($request->to) {
                $query->whereDate('created_at', '<=', $request->to);
            }
            if ($request->activated_from) {
                $query->whereDate('activated_at', '>=', $request->activated_from);
            }
            if ($request->activated_to) {
                $query->whereDate('activated_at', '<=', $request->activated_to);
            }
        }
        /*  End search    */

        $customers = $query->paginate(12);
        $receivingPlaces = ReceivingPlace::select('id', 'name')->orderBy('name')->get();

        $customers->appends($request->query());

        return view('CP.customers.index', [
            'customers' => $customers,
            'receivingPlaces' => $receivingPlaces,
            'STATE' => $this->getStatus(),
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|min:3|max:32',
            'phone' => ['required', 'string', 'regex:/^([0-9\-\+]\s*){3,14}$/', 'unique:customers,phone'],
            'email' => 'required|email|unique:customers,email',
            'address' => 'required|string|min:3|max:64',
            'password' => 'required|string|min:6|max:32|confirmed',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'verification_file' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:5120',
            'receive_in' => 'required|integer|exists:receiving_places,id',
            'state' => 'required|integer|between:1,3',
            'extra' => 'nullable|string|max:500',
        ]);

        $customer = new Customer();
        $customer->code = $this->getCode();
        $customer->activated_at = Carbon::now();
        $customer->state = $request->state;
        $this->setPassword($customer);
        $this->setData($customer);

        return response()->json([
            'redirectTo' => url('cp/customers', $customer->id),
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        checkIfIdCorrect($id);
        $customer = Customer::findOrfail($id);
        $receivingPlaces = ReceivingPlace::select('id', 'name')->orderBy('name')->get();

        $shippingInvoices = null;
        $shipping_statistics = new \StdClass;

        if ($customer->code) { /* if customer doesn't have code that means he/she is new and doesn't have Invoices or orders */

            $shippingInvoices = ShippingInvoice::with('trip:id,trip_number','currency:id,name,sign')->select('id', 'shipment_code', 'trip_id','currency_type_id', 'total_cost', 'created_at')
                ->where('customer_id', $customer->id)->latest('id')->limit(10)->get();


            $shipping_statistics = DB::select("SELECT
                (SELECT count(*) FROM `shipping_invoices` WHERE `customer_id` = $customer->id AND `trip_id` IS NULL AND `received_at` IS NULL) AS `warehouse`,
                (SELECT count(*) FROM `shipping_invoices` INNER JOIN `trips` on `trips`.`id`=`shipping_invoices`.`trip_id` WHERE `customer_id` = $customer->id AND `state` = 1) AS `waitting_shipping`,
                (SELECT count(*) FROM `shipping_invoices` INNER JOIN `trips` on `trips`.`id`=`shipping_invoices`.`trip_id` WHERE `customer_id` = $customer->id AND `state` = 2) AS `on_the_way`,
                (SELECT count(*) FROM `shipping_invoices` INNER JOIN `trips` on `trips`.`id`=`shipping_invoices`.`trip_id` WHERE `customer_id` = $customer->id AND `state` = 3 AND `received_at` IS NULL ) AS `arrived`,
                (SELECT count(*) FROM `shipping_invoices` WHERE `customer_id` = $customer->id AND `received_at` IS NOT NULL) AS `received`,
                (SELECT SUM(`total_cost` * `exchange_rate`) FROM `shipping_invoices` WHERE `customer_id` = $customer->id) AS `transactions`
            ");
            $shipping_statistics = $shipping_statistics[0];


        } else {
            $shipping_statistics->warehouse = 0;
            $shipping_statistics->waitting_shipping = 0;
            $shipping_statistics->on_the_way = 0;
            $shipping_statistics->arrived = 0;
            $shipping_statistics->received = 0;
            $shipping_statistics->transactions = 0;
        }

        return view('CP.customers.show', [
            'customer' => $customer,
            'receivingPlaces' => $receivingPlaces,
            'shippingInvoices' => $shippingInvoices,
            'shipping_statistics' => $shipping_statistics,
            'logins' => null,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Customer  $customer
     * @return \Illuminate\Http\Response
     */
    public function edit(Customer $customer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            /* 'code' => ['required', 'string', "regex:/^(get_customer_code_starts_with())[0-9]{1,8}$/", 'unique:customers,code,' . $request->id], */
            'name' => 'required|string|min:3|max:32',
            'phone' => ['required', 'string', 'regex:/^([0-9\-\+]\s*){3,14}$/', 'unique:customers,phone,' . $request->id],
            'email' => 'required|email|unique:customers,email,' . $request->id,
            'address' => 'required|string|min:3|max:64',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'verification_file' => 'nullable|file|mimes:jpeg,png,jpg,gif,pdf|max:5120',
            'receive_in' => 'required|integer|exists:receiving_places,id',
            'state' => 'required|integer|between:1,3',
            'extra' => 'nullable|string|max:500',
        ]);

        $customer = Customer::findOrfail($request->id);
        $isNewAccountActivated = $customer->state == 1 && $request->state == 3;
        if ($isNewAccountActivated) {
            // accept customer and activate account
            $customer->code = $this->getCode();
            $customer->activated_at = Carbon::now();
            $customer->state = $request->state;
        } else if (!($customer->state == 1 && $request->state == 2)) {
            // if state is new and new state is disable , then skipp change state because user doesn't activated account yet
            $customer->state = $request->state;
        }
        $this->setData($customer);

        if ($isNewAccountActivated) {
            /* if everything is okay and account was new and activated , then send mail to custer */
            Mail::to($customer)->send(new Activation($customer));
        } else if ($customer->wasChanged()) {
            $customer->notify(new UpdateData($customer));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function updatePassword(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
            'password' => 'required|string|min:6|max:32|confirmed',
        ]);
        $customer = Customer::findOrfail($request->id);
        $this->setPassword($customer);
        $customer->save();
        $customer->notify(new UpdatePassword($customer));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request)
    {
        $this->validate($request, [
            'id' => 'required|integer',
        ]);
        $customer = Customer::findOrfail($request->id);
        $customer->delete();
        File::delete($this->imgPath . $customer->img);
        File::delete($this->imgAvatarPath . $customer->img);
        File::delete($this->filePath . $customer->verification_file);
    }

    /* Get a new customer code */
    private function getCode()
    {
        return get_customer_code_starts_with() . (1 + Customer::max(DB::Raw("CONVERT(REPLACE(code,'" . get_customer_code_starts_with() . "','') , UNSIGNED)")));
    }

    private function setData($customer)
    {
        $request = request();

        if ($request->hasFile('img')) {

            $image = $request->file('img');
            $img_name = generateFileName() . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(150, 150)->save($this->imgAvatarPath . $img_name);
            $image->move($this->imgPath, $img_name);

            File::delete($this->imgPath . $customer->img);
            File::delete($this->imgAvatarPath . $customer->img);

            $customer->img = $img_name;
        }

        if ($request->hasFile('verification_file')) {

            $file = $request->file('verification_file');
            $file_name = generateFileName() . '.' . $file->getClientOriginalExtension();

            $file->move($this->filePath, $file_name);

            File::delete($this->filePath . $customer->verification_file);

            $customer->verification_file = $file_name;
        }

        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->receive_in = $request->receive_in;
        $customer->branche_id = $request->receive_in;
        $customer->extra = $request->extra;
        $customer->save();
    }

    /* Set a password for the customer account */
    private function setPassword($customer)
    {
        $customer->password = bcrypt(request('password'));
    }

    /* get all status of Customers accounts (key and value) */
    private function getStatus()
    {
        return trans('customerStatus.customer_status');
    }

}
