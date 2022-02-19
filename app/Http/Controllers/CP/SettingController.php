<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\CurrencyType;
use Hash;
use Illuminate\Http\Request;
use Illuminate\Validation\ValidationException;
use Mapper;

class SettingController extends Controller
{
    //
    public function show()
    {
        Mapper::map(app_settings()->latitude, app_settings()->longitude, [
            'zoom' => 15,
            'draggable' => true,
            'eventDragEnd' => '
                $("#location_lat").val(event.latLng.lat());
                $("#location_lng").val(event.latLng.lng());',
        ]);

        return view('CP.settings');
    }

    public function update(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'phone' => ['required', 'string', 'regex:/^([0-9\(\)\-\+]){3,24}$/'],
            'phone2' => ['nullable', 'string', 'regex:/^([0-9\(\)\-\+]){3,24}$/'],
            'address' => 'required|string|min:10|max:100',
            'city' => 'required|string|min:3|max:32',
            'longitude' => 'required|numeric|min:-180|max:180',
            'latitude' => 'required|numeric|min:-90|max:90',
            'facebook' => 'nullable|url',
            'instagram' => 'nullable|url',
            'twitter' => 'nullable|url',
            'youtube' => 'nullable|url',
            'desc' => 'required|string|min:32|max:250',
            'keywords' => 'required|string|min:32|max:250',
            'maintenance_msg' => 'required|string|min:10|max:250',
            'active' => 'required|boolean',
            'password' => 'required|min:6|max:32',
        ]);

        if (!Hash::check($request->password, auth()->user()->password)) {
            throw ValidationException::withMessages([__('cp.other.password_is_incorrect')]);
        }

        app_settings()->update($request->except('password'));
    }
}
