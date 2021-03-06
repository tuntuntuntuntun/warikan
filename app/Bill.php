<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Bill extends Model
{
    public function user()
    {
        return $this->belongsTo('App\User');
    }

    public function payment_users()
    {
        return $this->hasMany('App\PaymentUser');
    }
}
