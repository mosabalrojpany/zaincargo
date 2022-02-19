<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Address;
use App\Models\Country;
use App\Models\CurrencyType;
use App\Models\Post;
use Illuminate\Http\Request;

class IndexController extends Controller
{

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $posts = Post::with('tags:id,name')->active()->latest('id')->limit(3)->get();

        $countries = Country::select('id', 'name')->active()->get();
        $currencies = CurrencyType::select('id', 'name', 'sign')->active()->get();
        $addresses = Address::select('addresses.id', 'addresses.name', 'addresses.type', 'addresses.country_id')
            ->join('countries', 'countries.id', 'addresses.country_id')->where('addresses.active', true)->where('countries.active', true)->get();

        return view('main.index', [
            'posts' => $posts,
            'countries' => $countries,
            'currencies' => $currencies,
            'addresses' => $addresses,
        ]);
    }

}
