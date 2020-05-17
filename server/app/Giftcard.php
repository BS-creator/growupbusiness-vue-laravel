<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Giftcard extends Model
{
    protected $fillable = [
        "logo", "backgroundImage", "backgroundColor", "text", "price", "card_url", "uuid", "user_id",
    ];

    // protected $casts = [
    //     'logo' => 'array',
    //     'backgroundImage' => 'array',
    //     'backgroundColor' => 'array',
    //     'text' => 'array',
    //     'price' => 'array',
    // ];
}
