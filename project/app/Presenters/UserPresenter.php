<?php
namespace App\Presenters;

use App\Base\Presenter;

class UserPresenter extends Presenter
{
    protected function presentation($user)
    {
        $presentation = [];
        $presentation['name'] = $user->name;
        $presentation['email'] = $user->email;

        return $presentation;
    }
}
