<?php

namespace App\Http\Controller;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

abstract class BaseController extends Controller
{
    protected function login(LoginRequest $request): JsonResponse
    {
        $credentials = array($request->input('user_id'), $request->input('password'));
        if(Auth::attempt($credentials)){
            $user = Auth::user();
            $token = $user->createToken('authToken')->plainTextToken;
                return response()->json([
                    'token' => $token,
                    'user' => $user
                ], Response::HTTP_OK);
        }
        throw ValidationException::withMessages([
            'email' => ['The provided credentials are incorrect.'],
        ]);
    }

    protected function logout(Request $request): JsonResponse
    {
        $request->user()->currentAccessToken()->delete();

        return response()->json(['message' => 'Logged out'], 200);
    }
}

