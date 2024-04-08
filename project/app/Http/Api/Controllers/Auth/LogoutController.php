<?php

namespace App\Http\Api\Controllers\Auth;

use App\Http\Shared\Controllers\Controller;
use Illuminate\Http\Request;

class LogoutController extends Controller
{
    public function __invoke(Request $request)
    {
        $user = $request->user();

        if ($user) {
            $user->tokens()->delete();

            return response()->json(['message' => 'Logout realizado com sucesso']);
        }

        return response()->json([
            'error' => 'Essas credenciais não correspondem aos nossos registros.',
        ], 401);
    }
}
