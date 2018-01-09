<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Repositories\UserRepository;
use App\Builders\PaginationBuilder;
use App\Presenters\UserPresenter;

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
        $pagination->repository(new UserRepository())
                   ->presenter(new UserPresenter());

        return $pagination->build();
    }
}
