<?php

namespace App\Http\Controllers;

use App\Http\Requests\LoginRequest;
use App\Http\Requests\RegisterRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function __construct() 
    {
        $this->middleware("auth:api", ["except" => ["login", "register", "getUsers", "getUser", "getUserGalleries"]]);
    }

    public function login(LoginRequest $loginRequest)
    {
        $data = $loginRequest->validated();

        $token = Auth::attempt($data);
        if (!$token) {
            return response()->json([
                "status" => "error",
                "message" => "Invalid password", 
            ], 403); 
        }

        $user = Auth::user();
        return response()->json([
            "status" => "success",
            "user" => $user,
            "authorisation" => [
                "token" => $token,
                "type" => "bearer",
            ]
        ]);  
    }

    public function register(RegisterRequest $registerRequest)
    {
        $data = $registerRequest->validated();

        $user = User::create([
            "first_name" => $data["first_name"],
            "last_name" => $data["last_name"],
            "email" => $data["email"],
            "password" => Hash::make($data["password"])
        ]); 

        $token = Auth::login($user);
        return response()->json([
            "status" => "success",
            "message" => "User created successfully",
            "user" => $user,
            "authorisation" => [
                "token" => $token,
                "type" => "bearer",
            ]
        ]); 
    }

    public function logout()
    {
        Auth::logout();
        return response()->json([
            "status" => "success",
            "message" => "Successfully logged out",
        ]);
    }

    public function refresh()
    {
        return response()->json([
            "status" => "success",
            "user" => Auth::user(),
            "authorisation" => [
                "token" => Auth::refresh(),
                "type" => "bearer",
            ]
        ]);
    }

    public function getUsers()
    {
        $users = User::with("gallery")->get();

        return response()->json([
            "status" => "success",
            "users" => $users,
        ]);
    }

    public function getUser($id)
    {
        $user = User::with("gallery")->find($id);
        return response()->json([
            "user" => $user,
        ]);
    }

    public function getUserGalleries($userId)
    {
        $user = User::with("gallery")->find($userId);

        if (!$user) {
            return response()->json([
                "status" => "error",
                "message" => "User not found.",
            ], 404);
        }

        $galleries = $user->gallery()->orderBy("created_at", "DESC")->get();

        return response()->json([
            "status" => "success",
            "galleries" => $galleries,
        ]);
    }
}

