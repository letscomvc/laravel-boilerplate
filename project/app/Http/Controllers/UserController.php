<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\UserRepository;

use App\Http\Requests\UserRequest;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    public function index()
    {
        return view('users.index');
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(UserRequest $request, UserRepository $userRepository)
    {
        $data = $request->all();
        $userRepository->create($data);

        $message = find_message('user.success.create');
        return $this->chooseReturn('success', $message, 'users.index');
    }

    public function edit($id, UserRepository $userRepository)
    {
        $user = $userRepository->find($id);
        return view('users.edit', compact('user'));
    }

    public function update(UserRequest $request, UserRepository $userRepository, $id)
    {
        $data = $request->all();
        $userRepository->update($id, $data);

        $message = find_message('user.success.update');
        return $this->chooseReturn('success', $message, 'users.index');
    }

    public function show(UserRepository $userRepository, $id)
    {
        $user = $userRepository->find($id);

        return view('users.show', compact('user'));
    }

    public function destroy($id)
    {
        $deleted_user = (new UserRepository())->delete($id);

        if ($deleted_user) {
            $message = find_message('user.success.destroy');
            return $this->chooseReturn('success', $message, 'users.index');
        }

        $message = find_message('user.error.destroy');
        return $this->chooseReturn('error', $message, 'users.index');
    }

    protected function getPagination()
    {
        $this->pagination->repository(new UserRepository())
                         ->resource(UserResource::class)
                         ->perPage(30);
    }
}
