<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Giftlogo extends Model
{
    //
    protected $fillable = [
        "user_id", "name", "extension", "uuid", "size"
    ];

    public function getUrlAttribute() {
        $app_url = env("APP_URL", 'http://aaaeda1b.ngrok.io/');
        return "{$app_url}storage/uploads/giftcards/logos/{$this->name}.{$this->extension}";
    }
}
