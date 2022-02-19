<?php

namespace App\Http\Controllers\CP;

use App\Models\Country;
use App\Http\Controllers\Controller;
use File;
use Illuminate\Http\Request;
use Image;

class CountryController extends Controller
{
    private $imgPath;
    private $imgAvatarPath;

    public function __construct()
    {
        $this->imgPath = public_path('/storage/images/countries/');
        $this->imgAvatarPath = $this->imgPath . 'avatar/';
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $countries = Country::orderBy('name')->get();
        return view('CP.countries', ['countries' => $countries]);
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
            'name' => 'required|string|min:3|max:32|unique:countries',
            'logo' => 'required|image|mimes:jpeg,png,jpg,gif|max:5120',
            'extra' => 'nullable|string|max:150',
            'active' => 'required|boolean',
        ]);

        $image = $request->file('logo');
        $img_name = microtime(true) . '.' . $image->getClientOriginalExtension();

        Image::make($image)->resize(240, 160)->save($this->imgPath . $img_name);
        Image::make($image)->resize(60, 40)->save($this->imgAvatarPath . $img_name);

        $country = new Country();
        $country->name = $request->name;
        $country->logo = $img_name;
        $country->extra = $request->extra;
        $country->active = $request->active;
        $country->save();
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
            'id' => 'required|numeric',
            'name' => 'required|string|min:3|max:32|unique:countries,name,' . $request->id,
            'logo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:5120',
            'extra' => 'nullable|string|max:150',
            'active' => 'required|boolean',
        ]);

        $country = Country::findOrFail($request->id);
        $country->name = $request->name;
        if ($request->hasFile('logo')) {

            $image = $request->file('logo');
            $img_name = microtime(true) . '.' . $image->getClientOriginalExtension();

            Image::make($image)->resize(240, 160)->save($this->imgPath . $img_name);
            Image::make($image)->resize(60, 40)->save($this->imgAvatarPath . $img_name);

            File::delete($this->imgPath . $country->logo);
            File::delete($this->imgAvatarPath . $country->logo);

            $country->logo = $img_name;
        }
        $country->extra = $request->extra;
        $country->active = $request->active;
        $country->save();
    }
}
