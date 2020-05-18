<?php

namespace App\Http\Middleware;

use DB;
use Closure;
use Illuminate\Http\Request;

class ApiToken
{
    public $tokenUserId;


    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        $headers = \Request::header();

        if(!empty($headers['X-Auth-Token'])) {

            $token = (array)DB::table('api_tokens')
                ->where('token', '=', $headers['X-Auth-Token'])
                ->first();

            if(!empty($token)) {

                $request->attributes->add(['tokenUserId' => $token['userId']]);

                return $next($request);
            } else{
                return response()->json([
                    'error' => 'Token invalid'
                ], 401);
            }

        } else{
            return response()->json([
                'error' => 'No Auth-token in Header Request'
            ], 401);
        }

    }

}
