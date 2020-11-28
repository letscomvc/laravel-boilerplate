<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Http\Resources\User as UserResource;
use App\Models\User;
use App\Repositories\UserRepository;
use Inertia\Inertia;

class UserController extends Controller
{
    public function index()
    {
        $pagination = UserRepository::new()
            ->paginate();

        return Inertia::render('Users/Index', ['users' => $pagination]);
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserRequest $request)
    {
        (new UserRepository)->create($request->validated());

        $message = _m('user.success.create');
        return $this->chooseReturn('success', $message, 'users.index');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, User $user)
    {
        (new UserRepository())->update($user, $request->validated());

        $message = _m('user.success.update');
        return $this->chooseReturn('success', $message, 'users.index');
    }

    public function show(User $user)
    {
        return view('users.show', compact('user'));
    }

    public function destroy(User $user)
    {
        try {
            (new UserRepository)->delete($user);
            return $this->chooseReturn('success', _m('user.success.destroy'));
        } catch (\Exception $exception) {
            report($exception);
            return $this->chooseReturn('error', _m('user.error.destroy'));
        }
    }

    public function pagination()
    {
        return pagination()
            ->repository(UserRepository::class)
            ->resource(UserResource::class);
    }
}
