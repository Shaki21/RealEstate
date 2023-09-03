<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\models\Image;

class ImageController extends Controller
{
    public function uploadImage(Request $request)
    {
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
        ]);


        if ($request->hasFile('image')) {
            $image = $request->file('image');
            $imageName = time() . '.' . $image->getClientOriginalExtension();
            $image->storeAs('public/images', $imageName);

            // Spremanje linka do slike u bazu podataka
            $imageUrl = asset('storage/images/' . $imageName);

            $newImage = new Image;
            $newImage->image_url = $imageUrl;
            $newImage->save();

            return response()->json(['message' => 'Slika je uspešno uploadovana.', 'image_url' => $imageUrl]);
        } else {
            return response()->json(['error' => 'Niste odabrali sliku.'], 400);
        }
    }
}
