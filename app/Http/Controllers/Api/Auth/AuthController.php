<?php

namespace App\Http\Controllers\Api\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class AuthController extends Controller
{
    public function register(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|max:55',
            'email' => 'required|email|min:4|max:255|unique:users,email',
            'phone' => 'required',
            'password' => 'required|confirmed',
        ]);

        $validatedData['password'] = bcrypt($request->password);

        $user = User::create($validatedData);

        return response()->json([
            'message' => 'User registered successfully',
            'data' => $user
        ], 201);
    }

    public function login(Request $request)
    {
        $request->validate([
            "email" => "required|email",
            "password" => "required"
        ]);

        if (Auth::attempt([
            "email" => $request->email,
            "password" => $request->password
        ])) {

            $user = Auth::user();
            $token = $user->createToken("token")->accessToken;

            return response()->json([
                "message" => "Login successful",
                "access_token" => $token
            ], 200);
        }

        return response()->json([
            "message" => "Invalid credentials"
        ], 401);
    }
    public function profile()
    {
        $userdata = Auth::user();
        return response()->json([
            "message" => "Profile data",
            "data" => $userdata
        ], 200);
    }

    public function updateProfilePicture(Request $request)
    {
        $request->validate([
            'profile' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        $user = Auth::user();

        if ($request->hasFile('profile')) {
            if ($user->profile) {
                Storage::disk('public')->delete($user->profile);
            }

            $path = $request->file('profile')->store('profile', 'public');

            $user->profile = $path;
            $user->save();

            return response()->json([
                'message' => 'Profile picture updated successfully',
                'data' => $path,
            ], 200);
        } else {
            return response()->json([
                'message' => 'No valid profile picture provided',
            ], 400);
        }
    }
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'max:55',
            'email' => 'email|unique:users,email,' . $user->id,
            'phone' => 'max:255',
        ]);

        if ($request->has('name')) {
            $user->name = $request->name;
        }

        if ($request->has('email')) {
            $user->email = $request->email;
        }

        if ($request->has('phone')) {
            $user->phone = $request->phone;
        }

        if ($request->has('password')) {
            $user->password = bcrypt($request->password);
        }

        $user->save();

        return response()->json([
            'message' => 'Profile updated successfully',
            'data' => $user  
        ], 200);
    }



    public function logout()
    {

        auth()->user()->token()->revoke();
        return response()->json([
            "message" => "User logged out"
        ], 200);
    }
}
