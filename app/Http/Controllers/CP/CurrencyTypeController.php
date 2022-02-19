<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\CurrencyType;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;

class CurrencyTypeController extends Controller
{
    //
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $types = CurrencyType::orderBy('name')->get();
        return view('CP.currecny_types', ['types' => $types]);
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
        $type = new CurrencyType();
        $this->setData($type);
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
        ]);
        $this->validateData(true);

        if ($request->id == app_settings()->currency_type_id && !$request->active) {
            /* Do not allow to user to diable main currency */
            throw ValidationException::withMessages([__('cp.currencies.you_can_not_disable_main_currency')]);
        }

        $type = CurrencyType::findOrFail($request->id);
        $this->setData($type);
    }

    private function validateData($update = false)
    {
        $this->validate(request(), [
            'name' => 'required|string|min:3|max:32|unique:currency_types' . ($update ? ',name,' . request('id') : ''),
            'sign' => 'nullable|string|min:1|max:3',
            'value' => 'required|numeric|min:0.000001|max:999999',
            'extra' => 'nullable|string|max:150',
            'active' => 'required|boolean',
        ]);
    }

    private function setData($type)
    {
        $request = request();
        $type->name = $request->name;
        $type->sign = $request->sign;
        $type->extra = $request->extra;
        $type->value = $request->value;
        $type->active = $request->active;
        $type->save();
    }
}
