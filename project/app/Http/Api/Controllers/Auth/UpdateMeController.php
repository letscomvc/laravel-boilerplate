<?php

namespace App\Http\Api\Controllers\Auth;

use App\Domain\User\Actions\UpdateUserAction;
use App\Domain\User\Actions\UserData;
use App\Http\Api\Requests\Auth\MeRequest;
use App\Http\Api\Resources\Auth\MeResource;
use App\Http\Shared\Controllers\Controller;
use Illuminate\Http\JsonResponse;

class UpdateMeController extends Controller
{
    public function __invoke(MeRequest $request): JsonResponse
    {
        $user = current_user();
        $data = UserData::validateAndCreate($request->validated());

        $user = app(UpdateUserAction::class)
            ->execute($user, $data);

        return response()->json(MeResource::make($user), 200);
    }
}
