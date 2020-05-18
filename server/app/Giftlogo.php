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
        $app_url = env("APP_URL", 'http://localhost:8000');
        return "{$app_url}storage/uploads/giftcards/logos/{$this->name}.{$this->extension}";
    }
}
