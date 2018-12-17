<?php
namespace App\Support;

use Auth;
use Session;
use App\Models\User;

class Impersonation
{
    public function impersonate(User $user)
    {
        Session::put('original-user', Auth::id());
        Auth::login($user);
        return $this;
    }

    public function revokeImpersonate()
    {
        $originalUserId = Session::pull('original-user');
        if ($originalUserId) {
            $originalUser = User::find($originalUserId);
            Auth::login($originalUser);
            return true;
        }
        return false;
    }

    public function isImpersonating()
    {
        return Session::has('original-user');
    }
}
