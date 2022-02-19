<?php

namespace App\Http\Controllers\CP;

use App\Http\Controllers\Controller;
use App\Models\Branch;
use Illuminate\Http\Request;
use Mapper;

class BranchController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $branches = Branch::orderBy('city')->get();

        $map_all = Mapper::map(27.367568, 17.550938, ['marker' => false, 'zoom' => 6, 'draggable' => true]);

        foreach ($branches as $b) {
            $map_all->informationWindow($b->latitude, $b->longitude, "<h5 class='text-right mb-1 f-18px'>$b->city</h5>", [
                'marker' => true,
                'open' => true,
                'draggable' => true,
                'eventDragEnd' => '
                    $("#location_lat' . $b->id . '").val(event.latLng.lat());
                    $("#location_lng' . $b->id . '").val(event.latLng.lng());
                    $("#butSaveMap").removeClass("d-none");',
            ]);
        }

        // map for add new item
        Mapper::map(27, 17, [
            'zoom' => 5,
            'draggable' => true,
            'eventDragEnd' => '
                $("#location_lat").val(event.latLng.lat());
                $("#location_lng").val(event.latLng.lng());',
        ]);

        return view('CP.branches', [
            'branches' => $branches,
        ]);
    }

    private function validateData()
    {
        $this->validate(request(), [
            'city' => 'required|unique:branches|min:3|max:32',
            'address' => 'required|unique:branches|min:10|max:100',
            'email' => 'required|unique:branches|email',
            'phone' => 'required|unique:branches|string|min:3|max:24',
            'phone2' => 'nullable|unique:branches|string|min:3|max:24',
            'active' => 'required|boolean',
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
        $this->validateData();
        $this->validate($request, [
            'longitude' => 'numeric|min:-180|max:180',
            'latitude' => 'numeric|min:-90|max:90',
        ]);

        // $m = new Branch();

        //$m->longitude = $request->longitude;
        //$m->latitude = $request->latitude;
        // $this->setData($m);

        $branche = request();
        $branche->longitude = $request->longitude;
        $branche->latitude = $request->latitude;
        $branche = $branche->toArray();
        Branch::create($branche);

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
        $this->validateData();
        $m = Branch::findOrFail($request->id);
        $this->setData($m);
    }

    /**
     * Update branches locations.
     *
     * @return \Illuminate\Http\Response
     */
    public function updateLocation(Request $request)
    {
        $this->validate($request, [
            'branches.*' => 'required|array|size:2',
            'branches.*' => 'required|array|size:2',
            'branches.*.longitude' => 'nullable|numeric|min:-180|max:180',
            'branches.*.latitude' => 'nullable|numeric|min:-90|max:90',
        ]);

        foreach ($request->branches as $b_id => $b_location) {
            if ($b_location['latitude'] && $b_location['longitude']) {
                Branch::where('id', $b_id)->update([
                    'latitude' => $b_location['latitude'],
                    'longitude' => $b_location['longitude'],
                ]);
            }
        }
    }

    private function setData($branch)
    {
        $request = request();
        $branch->city = $request->city;
        $branch->address = $request->address;
        $branch->email = $request->email;
        $branch->phone = $request->phone;
        $branch->phone2 = $request->phone2;
        $branch->active = $request->active;
        $branch->save();

    }

}
