<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Http\Helper\IpAddressInfo;
use App\Models\Branch;
use App\Models\Message;
use Illuminate\Http\Request;
use Mapper;

class ContactController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::active()->get();

        $map_all = Mapper::map(27.4, 17.5, ['marker' => false, 'zoom' => 5]);

        foreach ($branches as $b) {
            $map_all->informationWindow($b->latitude, $b->longitude, "<h5 class='text-right mb-1 f-18px'>$b->city</h5>");
        }

        return view('main.contact', [
            'branches' => $branches,
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
            'email' => 'required|email',
            'phone' => ['required', 'string', 'regex:/^([0-9\-\+]\s*){3,14}$/'],
            'title' => 'required|string|min:9|max:100',
            'content' => 'required|string|min:10|max:500',
        ]);
        $message = new Message();
        $message->name = $request->name;
        $message->title = $request->title;
        $message->email = $request->email;
        $message->phone = $request->phone;
        $message->content = $request->content;
        $ip_info = IpAddressInfo::get();
        $message->country = $ip_info['country'];
        $message->city = $ip_info['city'];
        $message->ip = $ip_info['ip'];
        $message->save();
    }

}
