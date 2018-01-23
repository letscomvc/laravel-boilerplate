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

    protected function getPagination()
    {
        $this->pagination->repository(new UserRepository())
                         ->resource(UserResource::class);
    }
}
