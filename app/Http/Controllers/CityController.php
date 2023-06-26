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
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'country_id'=>'required|exists:countries,id'
        ]);
        $city = City::find($id);
        if ($city) {
            $city->update([
                'name' => $request->name,
            ]);
            return response()->json([
                'city' => $city
            ]);
        }else {
            return response()->json([
                'message' => 'City not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $city = City::find($id);
        if ($city){
            $city->delete();
            return response()->json([
                'message' => 'City ' . $city->name . ' deleted successfully'
            ]);
        }
        else{
            return response()->json([
                'message' => 'City not found',
            ], 404);
        }
    }

    public function getCityById($id)
    {
        $city = City::find($id);

        if (!$city) {
            return response()->json([
                'message' => 'City not found',
            ], 404);
        }

        return $city;
    }
}
