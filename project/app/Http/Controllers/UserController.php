<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\UserRepository;
use App\Http\Resources\User as UserResource;

class UserController extends Controller
{
    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('users.index');
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
