<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Giftbgimg extends Model
{
    //
    protected $fillable = [
        "user_id", "name", "extension", "uuid", "size"
    ];

    public function getUrlAttribute() {
        $app_url = env("APP_URL", 'http://localhost:8000');
        return "{$app_url}storage/uploads/giftcards/bgImgs/{$this->name}.{$this->extension}";
    }
}
