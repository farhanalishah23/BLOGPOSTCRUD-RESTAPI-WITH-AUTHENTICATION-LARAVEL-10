<?php

namespace App\Http\Controllers\API;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    public function signup(Request $request)
    {
        $validatedUser =  Validator::make(
            $request->all(),
            [
                'name' => 'required',
                'email' => 'required|email|unique:users,email',
                'password' => 'required',
            ]
        );
        if ($validatedUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => "User is not Validated",
                "error" => $validatedUser->errors()->all(),
            ], 401);
        }

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' =>  bcrypt($request->password),
        ]);
        if ($user) {
            return response()->json([
                'status' => true,
                'message' => "user sign up successfully",
                "user" => $user
            ], 200);
        }
    }


    public function login(Request $request)
    {
        $validatedUser =  Validator::make(
            $request->all(),
            [
                'email' => 'required|email',
                'password' => 'required',
            ]
        );

        if ($validatedUser->fails()) {
            return response()->json([
                'status' => false,
                'message' => 'login failed!',
                'error' => $validatedUser->errors()->all()
            ], 404);
        }

        if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
            $user = Auth::user();
            return response()->json([
                'status' => true,
                'message' => 'User Login successfully.',
                'token' => $user->createToken("Login Api Token")->plainTextToken,
                'token_type' => 'bearer'
            ], 200);
        } else {
            return response()->json([
                'status' => false,
                'message' => 'Email & Password Not Matched.',
                'error' => $validatedUser->errors()->all()
            ], 401);
        }
    }
    public function logout(Request $request)
    {
        $user = $request->user();
        $user->tokens()->delete();

        return response()->json([
            'status' => true,
            'user' => $user,
            'message' => 'User Logout Successfully.'
        ], 200);
    }
}
