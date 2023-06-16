<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::all();

        return response()->json([
            'users' => $users,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'is_admin' => 'boolean'
        ]);
        $user = User::create([
            'first_name' => $request->first_name,
            'last_name' => $request->last_name,
            'username' => $request->username,
            'email' => $request->email,
            'password' =>  Hash::make($request->password),
            'is_admin' => $request->is_admin
        ]);

        return response()->json([
            'user' => $user,
        ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $user)
    {
        return response()->json([
            'user' => $user,
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'username' => 'required|string||max:255',
            'email' => 'required|string|email|max:255',
            'password' => 'required|string|min:6',
            'is_admin' => 'boolean',
            'image_path' => 'string|max:255'
        ]);
        $user = User::find($id);
        if ($user) {
            $user->update([
                'first_name' => $request->first_name,
                'last_name' => $request->last_name,
                'username' => $request->username,
                'email' => $request->email,
                'password' =>  hash('sha256', $request->password),
                'is_admin' => $request->is_admin,
                'image_path' => $request->image_path
            ]);
            return response()->json([
                'user' => $user
            ]);
        }else {
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = User::find($id);
        if ($user){
            $user->delete();
            return response()->json([
                'message' => 'User ' . $user->name . ' deleted successfully',
            ]);
        }
        else{
            return response()->json([
                'message' => 'User not found',
            ], 404);
        }

    }
}
