<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BaseController extends Controller
{
    protected function getUserToken($request) {
        $header = $request->header('Authorization');
        $api_token = str_replace('Bearer ', '', $header);
        return $api_token;
    }
}
