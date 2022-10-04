<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use JWTAuth;
use JWTFactory;

class AuthController extends Controller
{
    public function __construct()
    {
        $this->middleware('jwt', ['except' => ['login']]);
    }
    public function login()
    {
        $credentials = request(['email', 'password']);

        if (! $token = JWTAuth::attempt($credentials)) {
            return response()->json(['status' => 0,'error' => 'Unauthorized'], 401);
        }

        return $this->respondWithToken($token);
    }

    public function me()
    {
        return response()->json(auth()->user());
    }

    public function logout()
    {
        auth()->logout();

        return response()->json(['message' => 'Successfully logged out']);
    }

    public function refresh()
    {
        return $this->respondWithToken(auth()->refresh());
    }

    protected function respondWithToken($token)
    {
        return response()->json([
            'status' => 1,
            'access_token' => $token,
            'token_type' => 'bearer',
            'expires_in' => auth()->factory()->getTTL() * 60
        ]);
    }
}
