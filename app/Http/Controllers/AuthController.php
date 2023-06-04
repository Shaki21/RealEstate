<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;

class AuthController extends Controller
{
    public function login(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();

        if (!$user || !Hash::check($request->password, $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['The provided credentials are incorrect.'],
            ]);
        }

        $token = $user->createToken('RealEstateToken')->plainTextToken;

        return response()->json([
            'access_token' => $token,
            'token_type' => 'bearer',
        ]);
    }

    public function user(Request $request)
    {
        return Auth::user();
    }

    public function register(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed',
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'username' => 'required|string|min:4'
        ]);

        $user = User::create(
            [
                'email' => $request->email,
                'first_name' => $request->first_name,
                'password' => Hash::make($request->password),
                'last_name' => $request->last_name,
                'username' => $request->username
            ]
        );

        $token = $user->createToken('RealEstateToken')->plainTextToken;
        $response = [
            'user' => $user,
            'access_token' => $token,
            'token_type' => 'bearer',
        ];

        return response($response, 201);
    }

    public function logout(Request $request)
    {
        $request->user()->tokens()->delete();

        return [
            'message' => 'Logged out successfully'
        ];
    }

    public function destroy(User $user){
        return $user->delete();
    }

    public function update(Request $request){
        $user = Auth::user();

        $validated = $request->validate([
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
            'password' => 'required|min:5',
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'username' => 'required|string|min:4',
            'image_path' => 'required'
        ]);
        return $user->update([
            'email' => $request->email,
            'first_name' => $request->first_name,
            'password' => Hash::make($request->password),
            'last_name' => $request->last_name,
            'username' => $request->username,
            'image_path' => $request->image_path
        ]);
    }

    // Admin methods
    // Get all users for admin
    public function allUsers(){
        return User::all();
    }
    public function adminUpdateUser(Request $request, User $user){

        $validated = $request->validate([
            'email' => [
                'required',
                Rule::unique('users')->ignore($user->id),
            ],
            'first_name' => 'required|string|min:2',
            'last_name' => 'required|string|min:2',
            'username' => 'required|string|min:4'
        ]);
        return $user->update([
            'email' => $request->email,
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            "is_admin" => $request->is_admin
        ]);
    }

}
