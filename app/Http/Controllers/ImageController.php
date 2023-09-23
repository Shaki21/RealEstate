<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
    public function index()
    {
        $images = Image::all();

        return response()->json([
            'images$images' => $images,
        ]);
    }

    public function filterByHouse($house_id)
    {
    $images = Image::select('id', 'image_path', 'house_id')
        ->whereHas('house', function ($query) use ($house_id) {
            $query->where('id', $house_id);
        })
        ->get();

    return response()->json($images);
    }
    
    public function upload(Request $request)
    {

        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);


        $imageName = Str::random(20) . '.' . $request->file('image')->getClientOriginalExtension();


        $imagePath = 'uploads/' . $imageName;


        Storage::disk('public')->put($imagePath, file_get_contents($request->file('image')));


        $imageUrl = asset('storage/' . $imagePath);

        return response()->json(['message' => 'Slika je uspješno postavljena.', 'image_url' => $imageUrl]);
    }

}
