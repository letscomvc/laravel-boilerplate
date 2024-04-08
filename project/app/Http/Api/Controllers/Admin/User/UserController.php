<?php

namespace App\Http\Api\Controllers\Admin\User;

use App\Domain\User\Actions\CreateUserAction;
use App\Domain\User\Actions\DeleteUserAction;
use App\Domain\User\Actions\UpdateUserAction;
use App\Domain\User\Actions\UserData;
use App\Domain\User\Models\User;
use App\Http\Api\Requests\Admin\UserRequest;
use App\Http\Api\Resources\Admin\UserResource;
use App\Http\Shared\Controllers\ResourceController;
use Spatie\QueryBuilder\AllowedFilter;

class UserController extends ResourceController
{
    public function index()
    {
        $this->authorize('viewAny', User::class);

        return pagination(User::class)
            ->allowedFilters([
                AllowedFilter::partial('name'),
                AllowedFilter::partial('email'),
                AllowedFilter::partial('role', 'roles.name'),
                AllowedFilter::partial('group'),
            ])
            ->with(['roles', 'permissions'])
            ->allowedSorts(['created_at', 'updated_at'])
            ->defaultSort('-created_at')
            ->resource(UserResource::class);
    }

    public function show(User $user)
    {
        $this->authorize('view', $user);

        $user->loadMissing('roles', 'permissions');

        return response()->json(UserResource::make($user));
    }

    public function store(UserRequest $request)
    {
        $this->authorize('create', User::class);

        $data = UserData::validateAndCreate($request->validated());

        $user = app(CreateUserAction::class)
            ->execute($data);

        return response()->json(UserResource::make($user), 201);
    }

    public function update(UserRequest $request, User $user)
    {
        $this->authorize('update', $user);

        $data = UserData::validateAndCreate($request->validated());

        $user = app(UpdateUserAction::class)
            ->execute($user, $data);

        return response()->json(UserResource::make($user));
    }

    public function destroy(User $user)
    {
        $this->authorize('delete', $user);

        app(DeleteUserAction::class)
            ->execute($user);

        return response()->noContent();
    }
}
