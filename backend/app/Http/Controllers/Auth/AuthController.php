<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Validator;

use App\User;

use Socialite;

class AuthController extends Controller
{


    public function __construct()
    {

    }

    // Sign In
    public function signin(Request $request) {
        $usingEmail = $request->input('usingEmail');
        $validatedData = NULL;
        $user = NULL;
        if($usingEmail) {
            $validatedData = $request->validate([
                'email' => 'required',
                'password' => 'required',
            ]);
            $user = User::where('email', $validatedData['email'])->first();
        } else {
            $validatedData = $request->validate([
                'phone' => 'required',
                'password' => 'required',
            ]);
            $user = User::where('phone', $validatedData['phone'])->first();
        }
        if($user) {
            if(!Hash::check($validatedData['password'], $user['password'])){
                return response()->json(array('code'=>4001, 'message'=>'Incorrect password'));
            }
        } else {
            return response()->json(array('code'=>4001, 'message'=>"user doesn't exist"));
        }
        $user['api_token'] = Str::random(60);
        $user['code'] = 20000;
        User::where('id', $user['id'])->update([
            'api_token' => $user['api_token'],
            'auth_type'=>$usingEmail?"phone":"email"
        ]);
        return response()->json($user);

    }

    // Social SignIn
    public function socialSignin($provider) {
        // Socialite will pick response data automatic
        $Suser = Socialite::driver($provider)->stateless()->user();

        $user = User::where('email', $Suser['email'])->where('auth_type', 'third-party')->first();
        // return response()->json(array('a'=>$user['password'], 'b'=>Hash::make($Suser['password'])));
        if($user) {

        } else {
            return response()->json(array('code'=>4001, 'message'=>"user doesn't exist"));
        }
        $user['api_token'] = Str::random(60);
        $user['code'] = 20000;
        User::where('id', $user['id'])->update(['api_token' => $user['api_token']]);
        return response()->json($user);
        return response()->json($user);
    }
    // Social SignUp
    public function socialSignup($provider) {
        // Socialite will pick response data automatic
        $user = Socialite::driver($provider)->stateless()->user();
        $date = date("Y-m-d g:i:s");
        $saveData = array(
            'name' => $user->name,
            'email' => $user->email,
            'avatar' => $user->avatar_original,
            'password' => 'example',
            'auth_type' => 'third-party',
            'api_token' => Str::random(60),
            'email_verified_at' => $date,
        );

        $validator = Validator::make($saveData, [
            'email' => 'required|unique:users|max:190',
            'password' => 'required',
            'api_token' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 200);
        }
        User::create($saveData);
        $saveData['code'] = 20000;
        return response()->json($saveData);
    }
    // Sign Up
    public function signup(Request $request) {
        $saveData = $request->input();

        $validator = Validator::make($saveData, [
            'email' => 'required|unique:users|max:190',
            'phone' => 'required|unique:users',
            'password' => 'required',
        ]);
        if ($validator->fails()) {
            $msg = $validator->errors()->first();
            return response()->json(['message' => $msg, 'type'=>gettype($msg)], 200);
        }
        $saveData['password'] = Hash::make($saveData['password']);
        $saveData['api_token'] = Str::random(60);

        User::create($saveData);
        $saveData["code"] = 20000;
        return response()->json($saveData);
    }

    public function logout(Request $request)
    {
        $header = $request->header('Authorization');
        $api_token = str_replace('Bearer ', '', $header);
        User::where('api_token', $api_token)->update(['api_token' => NULL]);
        return response()->json(array('code'=>20000));
    }

    public function no_authenticated()
    {
        return response()->json(array('code'=>50008, 'message'=>'No authenticated'));
    }

}
