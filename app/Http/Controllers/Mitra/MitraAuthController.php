<?php

namespace App\Http\Controllers\Mitra;

use App\Http\Controller\BaseController;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class MitraAuthController extends BaseController
{
    public function mitraLogin(LoginRequest $request)
    {
        return $this->login($request);
    }

    public function logout(Request $request): JsonResponse
    {
        return $this->logout($request);
    }
}
