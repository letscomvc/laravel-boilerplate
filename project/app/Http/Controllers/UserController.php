<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Presenters\UserPresenter;
use App\Builders\PaginationBuilder;
use App\Repositories\UserRepository;

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

    public function pagination()
    {
        $pagination = new PaginationBuilder();
        $pagination->repository(new UserRepository());

        return $pagination->build();
    }
}
