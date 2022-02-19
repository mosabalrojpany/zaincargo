<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Tags;
use Illuminate\Http\Request;

class TagsController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tags = Tags::orderBy('name')->get();
        return view('CP.tags', ['tags' => $tags]);
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
            'name' => 'required|min:3|max:64|unique:tags',
            'desc' => 'nullable|max:150',
            'active' => 'required|boolean',
        ]);
        $tag = new Tags();
        $tag->name = $request->name;
        $tag->desc = $request->desc;
        $tag->active = $request->active;
        $tag->save();
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
            'id' => 'required|numeric|exists:tags',
            'name' => 'required|min:3|max:64|unique:tags,name,' . $request->id,
            'desc' => 'nullable|max:150',
            'active' => 'required|boolean',
        ]);
        $tag = Tags::findOrFail($request->id);
        $tag->name = $request->name;
        $tag->desc = $request->desc;
        $tag->active = $request->active;
        $tag->save();
    }

    /**
     * Return a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function getForApi()
    {
        $tags = Tags::select('id', 'name', 'desc')->active();
        return $tags;
    }
}
