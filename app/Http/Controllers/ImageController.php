<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ImageController extends Controller
{
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
