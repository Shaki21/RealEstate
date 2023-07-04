<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $houses = House::all();

        return response()->json([
            'houses' => $houses,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'bedroom' => 'required|integer',
            'bathroom' => 'required|integer',
            'quadrature' => 'required|integer',
            'floors' => 'required|integer',
            'garden_quadrature' => 'required|integer',
            'address' => 'required|string|max:255',
            'property_type' => 'required|string|max:255',
            'property_status' => 'required|string|max:255',
            'city_id' => 'required|string|max:255'
        ]);
        $house = House::create([
            'title' => $request->title,
            'price' => $request->price,
            'bedroom' => $request->bedroom,
            'bathroom' => $request->bathroom,
            'quadrature' => $request->quadrature,
            'floors' => $request->floors,
            'garden_quadrature' => $request->garden_quadrature,
            'address' => $request->address,
            'property_type' => $request->property_type,
            'property_status' => $request->property_status,
            'city_id'=>$request->city_id
        ]);

        return response()->json([
            'house' => $house,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(House $house)
    {
        return response()->json([
            'house' => $house,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'price' => 'required|numeric',
            'bedroom' => 'required|integer',
            'bathroom' => 'required|integer',
            'quadrature' => 'required|integer',
            'floors' => 'required|integer',
            'garden_quadrature' => 'required|integer',
            'address' => 'required|string|max:255',
            'property_type' => 'required|string|max:255',
            'property_status' => 'required|string|max:255'
        ]);
        $house = House::find($id);
        if ($house) {
            $house->update([
                'title' => $request->title,
                'price' => $request->price,
                'bedroom' => $request->bedroom,
                'bathroom' => $request->bathroom,
                'quadrature' => $request->quadrature,
                'floors' => $request->floors,
                'garden_quadrature' => $request->garden_quadrature,
                'address' => $request->address,
                'property_type' => $request->property_type,
                'property_status' => $request->property_status
            ]);
            return response()->json([
                'house' => $house
            ]);
        }else {
            return response()->json([
                'message' => 'House not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $house = House::find($id);
        if ($house){
            $house->delete();
            return response()->json([
                'message' => 'House ' . $house->name . ' deleted successfully'
            ]);
        }
        else{
            return response()->json([
                'message' => 'House not found',
            ], 404);
        }

    }

    public function getHouseById($id)
    {
        $house = House::find($id);

        if (!$house) {
            return response()->json([
                'message' => 'House not found',
            ], 404);
        }

        return $house;
    }

}
