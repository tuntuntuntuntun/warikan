<?php

namespace App\Policies;

use App\User;
use App\Bill;
use Illuminate\Auth\Access\HandlesAuthorization;

class BillPolicy
{
    use HandlesAuthorization;

    public function view(User $user, Bill $bill)
    {
        return $user->id === $bill->userd_id;
    }
}
