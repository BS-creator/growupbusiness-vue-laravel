<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

// table name === giftcard_hashes
class GiftcardHash extends Model
{
    protected $guarded = [];

    public function customer()
    {
        return $this->belongsTo('App\Customer');
    }

    public function transactions()
    {
        return $this->hasMany('App\CusTransaction');
    }
}
