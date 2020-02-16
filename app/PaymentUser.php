<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class PaymentUser extends Model
{
    protected $fillable = ['bill_id', 'user_id'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
