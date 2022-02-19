<?php

namespace App\Http\Controllers\Client;

use App\Http\Controllers\Controller;
use App\Mail\Customers\Register;
use App\Models\Customer;
use App\Models\ReceivingPlace;
use File;
use Illuminate\Http\Request;
use Image;
use Mail;

class RegisterController extends Controller
{

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $receivingPlaces = ReceivingPlace::select('id', 'name')->active()->orderBy('name')->get();

        return view('main.register', [
            'receivingPlaces' => $receivingPlaces,
        ]);
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
            'name' => 'required|string|min:9|max:32',
            'phone' => ['required', 'string', 'regex:/^([0-9\-\+]\s*){3,14}$/', 'unique:customers,phone'],
            'email' => 'required|email|unique:customers,email',
            'address' => 'required|string|min:12|max:64',
            'password' => 'required|string|min:6|max:32|confirmed',
            'img' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'verification_file' => 'required|file|mimes:jpeg,png,jpg,gif,pdf|max:5120',
            'receive_in' => 'required|integer|exists:receiving_places,id',
        ]);

        $customer = new Customer();

        if ($request->hasFile('img')) {

            $image = $request->file('img');
            $img_name = generateFileName() . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(150, 150)->save(public_path('/storage/images/customers/avatar/') . $img_name);
            $image->move(public_path('/storage/images/customers/'), $img_name);

            $customer->img = $img_name;
        }

        $file = $request->file('verification_file');
        $file_name = generateFileName() . '.' . $file->getClientOriginalExtension();
        $file->move(storage_path('app/customers/verifications/'), $file_name);

        $customer->verification_file = $file_name;

        $customer->name = $request->name;
        $customer->phone = $request->phone;
        $customer->email = $request->email;
        $customer->address = $request->address;
        $customer->receive_in = $request->receive_in;
        $customer->branche_id = $request->receive_in;
        $customer->password = bcrypt($request->password);
        $customer->save();

        Mail::to($customer->email)->send(new Register($customer));
    }

}
