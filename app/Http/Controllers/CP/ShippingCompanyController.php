<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\ShippingCompany;
use Illuminate\Http\Request;

class ShippingCompanyController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $companies = ShippingCompany::orderBy('name')->get();
        return view('CP.shipping_companies', ['companies' => $companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validateData();
        $company = new ShippingCompany();
        $this->setData($company);
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
            'id' => 'required|integer|min:1',
        ]);
        $this->validateData(true);
        $company = ShippingCompany::findOrFail($request->id);
        $this->setData($company);
    }

    private function setData($company)
    {
        $request = request();
        $company->name = $request->name;
        $company->extra = $request->extra;
        $company->active = $request->active;
        $company->save();
    }

    private function validateData($update = false)
    {
        $this->validate(request(), [
            'name' => 'required|string|min:3|max:32|unique:shipping_companies' . ($update ? ',name,' . request('id') : ''),
            'extra' => 'nullable|string|max:150',
            'active' => 'required|boolean',
        ]);
    }
}
