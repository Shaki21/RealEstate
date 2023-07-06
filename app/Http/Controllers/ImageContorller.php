<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ImageContorller extends Controller
{
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'image' => 'required|image',
        ]);

        if ($validator->fails()) {
            return response()->json(['message' => $validator->errors()->first()], 422);
        }

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('public/images');

            // Čuvanje putanje slike u bazi podataka
            $image = new Image;
            $image->path = $path;
            $image->save();

            // Prikazivanje slike korisniku
            return response()->file(storage_path('app/' . $path));
        }

        return response('Niste izabrali sliku.', 400);
    }
}
