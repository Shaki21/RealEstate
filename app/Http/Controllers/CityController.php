<?php

namespace App\Http\Controllers;

use App\Models\City;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return City::all();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name'=>'required',
            'country_id'=>'required|exists:countries,id'
        ]);

        return City::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(City $city)
    {
        return $city;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, City $city)
    {
        $request->validate([
            'name'=>'required',
            'country_id'=>'required|exists:countries,id'
        ]);

        return $city->update($request->all());
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(City $city)
    {
        return $city->delete();
    }
}
