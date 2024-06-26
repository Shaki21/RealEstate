<?php

namespace App\Http\Controllers;

use App\Models\House;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $query = House::query();

        if ($request->has('bedroom')) {
            $bedroom = $request->input('bedroom');
            $query->where('bedroom', $bedroom);
        }

        if ($request->has('floors')) {
            $floors = $request->input('floors');
            $query->where('floors', $floors);
        }
        if ($request->has('bathroom')) {
            $bathroom = $request->input('bathroom');
            $query->where('bathroom', $bathroom);
        }
        if ($request->has('cityName')) {
            $cityName = $request->input('cityName');
            $query->where('cityName', $cityName);
        }

        if ($request->has('countryName')) {
            $countryName = $request->input('countryName');
            $query->where('countryName', $countryName);
        }

        if ($request->has('price')) {
            $priceRange = explode(',', $request->input('price'));
            if (count($priceRange) === 2) {
                $minPrice = (int) $priceRange[0];
                $maxPrice = (int) $priceRange[1];
                $query->whereBetween('price', [$minPrice, $maxPrice])
                    ->orderBy('price', 'asc');
            }
        }

        $houses = $query->paginate(12);

        $houses->getCollection()->transform(function ($house) {
            $imagePath = DB::table('images')
                ->where('house_id', $house->id)
                ->pluck('image_path')
                ->toArray();
            $house->image_path = $imagePath;
            return $house;
        });
    
        return response()->json([
            'houses' => $houses,
        ]);
    }
    public function maxHousePrice(Request $request)
    {
        $query = House::query();

        if ($request->has('price')) {
            $priceRange = explode(',', $request->input('price'));
            if (count($priceRange) === 2) {
                $minPrice = (int) $priceRange[0];
                $maxPrice = (int) $priceRange[1];
                $query->whereBetween('price', [$minPrice, $maxPrice]);
            }
        }
    
        // Find the maximum price among the filtered houses
        $maxPrice = $query->max('price');
    
        return response()->json([
            'maxPrice' => $maxPrice,
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
            'description' => 'required|string|max:255',
            'cityName' => 'required|string|max:255',
            'countryName' => 'required|string|max:255'
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
            'description' => $request->description,
            'cityName'=>$request->cityName,
            'countryName'=>$request->countryName
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
            'property_status' => 'required|string|max:255',
            'description' => 'required|string|max:255'
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
                'property_status' => $request->property_status,
                'description' => $request->description
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
    
        $imagePath = DB::table('images')
            ->where('house_id', $house->id)
            ->pluck('image_path')
            ->toArray();
    
            $house->image_path = $imagePath;

            return $house;
    }


    public function uploadImage(Request $request){
        $pathToFile = $request->file('image')->store('images', 'public');

        return $pathToFile;
    }

}
