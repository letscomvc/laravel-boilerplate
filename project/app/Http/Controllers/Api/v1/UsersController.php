<?php

namespace App\Http\Controllers\Api\v1;

use Illuminate\Http\Request;

use App\Http\Controllers\Controller;

class UsersController extends Controller
{
    /**
     * Return request user.
     *
     * @return \Illuminate\Http\Response
     */
    public function me(Request $request)
    {
        return $request->user();
    }
}
