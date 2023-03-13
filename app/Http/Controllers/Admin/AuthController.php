<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Symfony\Component\HttpFoundation\Response;

class AuthController extends Controller
{
    public function login(LoginRequest $request)
    {
        $user = User::where('mobile', $request->mobile)
                ->orWhere('email', $request->email)
                ->first();

        if(!$user || !Hash::check($request->password, $user->password)){
            return response('Credentials not matched!', Response::HTTP_UNAUTHORIZED);
        }
        $token = $user->createToken('api');
        $response = [
            'user' => $user,
            'token' => $token
        ];
        return response($response);
    }

    public function logout(Request $request)
    {
        $request->user()->currentAccessToken()->delete();
    }
}
