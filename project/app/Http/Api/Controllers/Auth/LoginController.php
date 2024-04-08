<?php

namespace App\Http\Api\Controllers\Auth;

use App\Http\Api\Requests\Auth\LoginRequest;
use App\Http\Shared\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function __invoke(LoginRequest $request)
    {
        $data = $request->validated();

        if (Auth::attempt($data)) {
            $user = $request->user();

            $token = $user->createToken('auth_token')->plainTextToken;

            return response()->json([
                'access_token' => $token,
                'type_token' => 'Bearer',
            ], 200);
        }

        return response()->json([
            'error' => 'Não autorizado.',
        ], 401);
    }
}
