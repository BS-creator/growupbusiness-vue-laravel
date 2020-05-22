<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    protected $guarded = [];

    public function giftCardHash()
    {
        return $this->hasOne('App\GiftcardHash');
    }
}
