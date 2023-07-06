<?php

namespace App\Http\Controllers;

use App\Models\Country;
use Illuminate\Http\Request;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $countries = Country::all();

        return response()->json([
            'countries' => $countries,
        ]);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
      $request->validate([
         'name' => 'required|unique:countries,name'
      ]);

      return Country::create($request->all());
    }

    /**
     * Display the specified resource.
     */
    public function show(Country $country)
    {
        return $country;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required|string|max:255'
        ]);
        $country = Country::find($id);
        if ($country) {
            $country->update([
                'name' => $request->name,
            ]);
            return response()->json([
                'country' => $country
            ]);
        }else {
            return response()->json([
                'message' => 'Country not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $country = Country::find($id);
        if ($country){
            $country->delete();
            return response()->json([
                'message' => 'Country ' . $country->name . ' deleted successfully'
            ]);
        }
        else{
            return response()->json([
                'message' => 'Country not found',
            ], 404);
        }

    }

    public function getCountryById($id)
    {
        $country = Country::find($id);

        if (!$country) {
            return response()->json([
                'message' => 'Country not found',
            ], 404);
        }

        return $country;
    }
}
