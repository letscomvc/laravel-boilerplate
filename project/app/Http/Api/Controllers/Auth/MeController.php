<?php

namespace App\Http\Api\Controllers\Auth;

use App\Http\Api\Resources\Auth\MeResource;
use App\Http\Shared\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class MeController extends Controller
{
    public function __invoke(): JsonResponse
    {
        $user = current_user();

        return response()->json(MeResource::make($user), 200);
    }
}
