<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\ReceivingPlace;
use DB;
use File;
use Illuminate\Http\Request;
use Image;

class CustomerController extends Controller
{
    private $imgPath;
    private $imgAvatarPath;

    public function __construct()
    {
        $this->imgPath = public_path('/storage/images/customers/');
        $this->imgAvatarPath = $this->imgPath . 'avatar/';
    }

    /**
     * Display the specified resource.
     */
    public function index()
    {
        $customer = authClient()->user();

        $receivingPlaces = ReceivingPlace::select('id', 'name')->activeOrId($customer->receive_in)->orderBy('name')->get();

        $shipping = DB::select("SELECT
                (SELECT count(*) FROM `shipping_invoices` WHERE `customer_id` = $customer->id AND `trip_id` IS NULL AND `received_at` IS NULL) AS `warehouse`,
                (SELECT count(*) FROM `shipping_invoices` INNER JOIN `trips` on `trips`.`id`=`shipping_invoices`.`trip_id` WHERE `customer_id` = $customer->id AND `state` = 1) AS `waitting_shipping`,
                (SELECT count(*) FROM `shipping_invoices` INNER JOIN `trips` on `trips`.`id`=`shipping_invoices`.`trip_id` WHERE `customer_id` = $customer->id AND `state` = 2) AS `on_the_way`,
                (SELECT count(*) FROM `shipping_invoices` INNER JOIN `trips` on `trips`.`id`=`shipping_invoices`.`trip_id` WHERE `customer_id` = $customer->id AND `state` = 3 AND `received_at` IS NULL ) AS `arrived`,
                (SELECT count(*) FROM `shipping_invoices` WHERE `customer_id` = $customer->id AND `received_at` IS NOT NULL) AS `received`
            ");
        $shipping = $shipping[0];
        $shipping->total = $shipping->warehouse + $shipping->waitting_shipping + $shipping->on_the_way + $shipping->arrived + $shipping->received;

        $shipping->percentage_warehouse = $this->getPercentage($shipping->total, $shipping->warehouse);
        $shipping->percentage_waitting_shipping = $this->getPercentage($shipping->total, $shipping->waitting_shipping);
        $shipping->percentage_on_the_way = $this->getPercentage($shipping->total, $shipping->on_the_way);
        $shipping->percentage_arrived = $this->getPercentage($shipping->total, $shipping->arrived);
        $shipping->percentage_received = $this->getPercentage($shipping->total, $shipping->received);

        /* Start orders */
        $orders = DB::select("SELECT
                (SELECT count(*) FROM `purchase_orders` WHERE `customer_id` = $customer->id AND `state` = 1) AS `new`,
                (SELECT count(*) FROM `purchase_orders` WHERE `customer_id` = $customer->id AND `state` = 2) AS `review`,
                (SELECT count(*) FROM `purchase_orders` WHERE `customer_id` = $customer->id AND `state` = 3) AS `rejected`,
                (SELECT count(*) FROM `purchase_orders` WHERE `customer_id` = $customer->id AND `state` = 4) AS `waitting_pay`,
                (SELECT count(*) FROM `purchase_orders` WHERE `customer_id` = $customer->id AND `state` = 5) AS `paid`,
                (SELECT count(*) FROM `purchase_orders` WHERE `customer_id` = $customer->id AND `state` = 6) AS `done`
            ");
        $orders = $orders[0];
        $orders->total = $orders->new + $orders->review + $orders->rejected + $orders->waitting_pay + $orders->paid + $orders->done;

        $orders->percentage_new = $this->getPercentage($orders->total, $orders->new);
        $orders->percentage_review = $this->getPercentage($orders->total, $orders->review);
        $orders->percentage_rejected = $this->getPercentage($orders->total, $orders->rejected);
        $orders->percentage_waitting_pay = $this->getPercentage($orders->total, $orders->waitting_pay);
        $orders->percentage_paid = $this->getPercentage($orders->total, $orders->paid);
        $orders->percentage_done = $this->getPercentage($orders->total, $orders->done);

        /* Start transfers */
        $transfers = DB::select("SELECT
                (SELECT count(*) FROM `money_transfers` WHERE `customer_id` = $customer->id AND `state` = 1) AS `new`,
                (SELECT count(*) FROM `money_transfers` WHERE `customer_id` = $customer->id AND `state` = 2) AS `review`,
                (SELECT count(*) FROM `money_transfers` WHERE `customer_id` = $customer->id AND `state` = 3) AS `rejected`,
                (SELECT count(*) FROM `money_transfers` WHERE `customer_id` = $customer->id AND `state` = 4) AS `waitting_pay`,
                (SELECT count(*) FROM `money_transfers` WHERE `customer_id` = $customer->id AND `state` = 5) AS `waitting_receive`,
                (SELECT count(*) FROM `money_transfers` WHERE `customer_id` = $customer->id AND `state` = 6) AS `done`
            ");
        $transfers = $transfers[0];
        $transfers->total = $transfers->new + $transfers->review + $transfers->rejected + $transfers->waitting_pay + $transfers->waitting_receive + $transfers->done;

        $transfers->percentage_new = $this->getPercentage($transfers->total, $transfers->new);
        $transfers->percentage_review = $this->getPercentage($transfers->total, $transfers->review);
        $transfers->percentage_rejected = $this->getPercentage($transfers->total, $transfers->rejected);
        $transfers->percentage_waitting_pay = $this->getPercentage($transfers->total, $transfers->waitting_pay);
        $transfers->percentage_waitting_receive = $this->getPercentage($transfers->total, $transfers->waitting_receive);
        $transfers->percentage_done = $this->getPercentage($transfers->total, $transfers->done);

        Notification::currentClient()->customers()->updateAsRead();

        return view("Client.profile", [
            'receivingPlaces' => $receivingPlaces,
            'shipping' => $shipping,
            'orders' => $orders,
            'transfers' => $transfers,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $customer = authClient()->user();

        $this->validate($request, [
            'phone' => ['required', 'string', 'regex:/^([0-9\-\+]\s*){3,14}$/', 'unique:customers,phone,' . $customer->id],
            'address' => 'required|string|min:12|max:64',
            'password' => 'nullable|string|min:6|max:32',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'receive_in' => 'required|integer|exists:receiving_places,id',
        ]);

        $customer->phone = $request->phone;
        $customer->address = $request->address;
        $customer->receive_in = $request->receive_in;
        if ($request->password) {
            $customer->password = bcrypt($request->password);
        }

        if ($request->hasFile('img')) {

            $image = $request->file('img');
            $img_name = generateFileName() . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(150, 150)->save($this->imgAvatarPath . $img_name);
            $image->move($this->imgPath, $img_name);

            File::delete($this->imgPath . $customer->img);
            File::delete($this->imgAvatarPath . $customer->img);

            $customer->img = $img_name;
        }
        $customer->save();
    }

    private function getPercentage($total, $value)
    {
        return $total == 0 ? 0 : (int) ($value / $total * 100);
    }
}
