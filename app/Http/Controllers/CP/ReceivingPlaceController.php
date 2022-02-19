<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\ReceivingPlace;
use Illuminate\Http\Request;

class ReceivingPlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $places = ReceivingPlace::orderBy('name')->get();
        return view('CP.receiving_places', ['places' => $places]);
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
            'name' => 'required|string|min:3|max:32|unique:receiving_places',
            'extra' => 'nullable|string|max:150',
            'active' => 'required|boolean',
        ]);
        $place = new ReceivingPlace();
        $place->name = $request->name;
        $place->extra = $request->extra;
        $place->active = $request->active;
        $place->save();
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
            'name' => 'required|string|min:3|max:32|unique:receiving_places,name,' . $request->id,
            'extra' => 'nullable|string|max:150',
            'active' => 'required|boolean',
        ]);
        $place = ReceivingPlace::findOrFail($request->id);
        $place->name = $request->name;
        $place->extra = $request->extra;
        $place->active = $request->active;
        $place->save();
    }

    /**
     * Return a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getForApi()
    {
        $places = ReceivingPlace::select('id', 'name', 'extra')->active()->get();
        return $places;
    }

}
