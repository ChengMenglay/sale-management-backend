<?php

namespace App\Http\Controllers;

use App\Http\Requests\RegisterRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AuthController extends Controller
{
    public function register(RegisterRequest $request)
    {
        $payload = $request->validated();

        try {
            $payload['password'] = Hash::make($payload["password"]);
            User::create(attributes: $payload);

            
            return response()->json(["message" => "Account created successfully"], 200);
        } catch (\Exception $e) {
            Log::error("Register error => " . $e->getMessage());

            return response()->json(["message" => "Something went wrong, please try again later!"], 500);
        }
    }

    public function login(Request $request)
    {
        $payload = $request->validate([
            'email' => 'required|email',
            'password' => 'required'
        ]);

        try {
            $user = User::where("email", $payload['email'])->first();

            if (!$user) {
                return response()->json(['message' => "Invalid Credentials"], 401);
            }

            if (!Hash::check($payload['password'], $user->password)) {
                return response()->json(['message' => "Invalid Credentials"], 401);
            }

            $token = $user->createToken("web",["*"], now()->addDays(7))->plainTextToken;

            $authRes = array_merge($user->toArray(), ['token' => $token]);

            return response()->json(["message" => "Logged in successfully!", "user" => $authRes]);
        } catch (\Exception $e) {
            Log::error("Login error => " . $e->getMessage());

            return response()->json(["message" => "Something went wrong, please try again later!"], 500);
        }
    }

    public function checkCredentials(Request $request){
        try {
            $payload = $request->validate([
                'email' => 'required|email',
                'password' => 'required'
            ]);
            $user = User::where( "email", $payload['email'])->first();


            if (!$user) {
                return response()->json(['message' => "Invalid Credentials"], 401);
            }

            if (!Hash::check($payload['password'], $user->password)) {
                return response()->json(['message' => "Invalid Credentials"], 401);
            }

            return response()->json(["message" => "Logged in successfully!","status"=>200]);
        } catch (\Exception $e) {
            Log::error("Login Credentials error => " . $e->getMessage());

            return response()->json(["message" => "Something went wrong, please try again later!"], 500);
        }
    }

    public function logout(Request $request){
        try{
            $request->user()->currentAccessToken()->delete();
            return ["message"=>"Logged out successfulle!"];
        }catch (\Exception $e) {
            Log::error("Logout error => " . $e->getMessage());

            return response()->json(["message" => "Something went wrong, please try again later!"], 500);
        }
    }
}