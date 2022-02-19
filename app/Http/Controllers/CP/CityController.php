<?php

namespace App\Http\Controllers\CP;

use App\Models\City;
use App\Models\Country;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cities = City::with('country') /* ->orderBy('name') */->get()->sortBy('country.name');
        $countries = Country::orderBy('name')->get();

        return view('CP.cities', [
            'cities' => $cities,
            'countries' => $countries,
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
            'name' => 'required|string|min:3|max:32|unique:cities,name,null,null,country_id,' . $request->country,
            'country' => 'required|integer|exists:countries,id',
            'extra' => 'nullable|string|max:150',
            'active' => 'required|boolean',
        ]);
        $city = new City();
        $city->name = $request->name;
        $city->country_id = $request->country;
        $city->extra = $request->extra;
        $city->active = $request->active;
        $city->save();
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
            'name' => 'required|string|min:3|max:32|unique:cities,name,' . $request->id . ',id,country_id,' . $request->country,
            'country' => 'required|integer|exists:countries,id',
            'extra' => 'nullable|string|max:150',
            'active' => 'required|boolean',
        ]);
        $city = City::findOrFail($request->id);
        $city->name = $request->name;
        $city->country_id = $request->country;
        $city->extra = $request->extra;
        $city->active = $request->active;
        $city->save();
    }

}
