<?php

namespace App\Http\Controllers\Api\auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\LoginRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    //

    public function login(LoginRequest $request)
    {
        $validated_data=$request->validated();
        if (!auth()->attempt($validated_data)) {
            return errorResponse(null,__('auth.failed'),401);
        }

        $accessToken = auth()->user()->createToken('authToken')->accessToken;

        return successResponse(['user' => auth()->user(), 'access_token' => $accessToken],__('registration.login.success'));
    }

    public function logout()
    {
          // get token value
          $token = Auth::user()->token();

          // revoke this token value
          $token->revoke();

          return successResponse(null,__('auth.logout'));
    }


}
