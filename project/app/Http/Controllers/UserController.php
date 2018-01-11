<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Presenters\UserPresenter;
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

    protected function getPagination()
    {
        $this->pagination->repository(new UserRepository())
                         ->presenter(new UserPresenter);
    }
}
