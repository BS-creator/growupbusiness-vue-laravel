<?php
namespace App\Helpers;
use App\User;

class Helper
{
    static function getCurrentToken($request) {
        $header = $request->header('Authorization');
        $api_token = str_replace('Bearer ', '', $header);
        return $api_token;
    }
    static function getCurrentUserByToken($token)
    {
        $user = User::where('api_token', $token)->first();
        return $user;
    }
}
