<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\ItemType;
use Illuminate\Http\Request;

class ItemTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = ItemType::orderBy('name')->get();
        return view('CP.item_types', ['types' => $types]);
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
            'name' => 'required|string|min:3|max:32|unique:item_types',
            'extra' => 'nullable|string|max:150',
            'active' => 'required|boolean',
        ]);
        $type = new ItemType();
        $type->name = $request->name;
        $type->extra = $request->extra;
        $type->active = $request->active;
        $type->save();
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
            'name' => 'required|string|min:3|max:32|unique:item_types,name,' . $request->id,
            'extra' => 'nullable|string|max:150',
            'active' => 'required|boolean',
        ]);
        $type = ItemType::findOrFail($request->id);
        $type->name = $request->name;
        $type->extra = $request->extra;
        $type->active = $request->active;
        $type->save();
    }

    /**
     * Return a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getForApi()
    {
        $types = ItemType::select('id', 'name', 'extra')->active()->get();
        return $types;
    }
}
