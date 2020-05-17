<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Validator;
use App\Giftlogo;
use App\User;

class GiftLogoController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $token = $this->getUserToken($request);
        $user = User::where('api_token', $token)->first();
        $logos = $user->giftlogos;
        $logos->map(function($logo) {
            $logo['url'] = $logo->url;
            return true;
        });
        return response()->json(array('code'=> 20000, 'logos'=> $logos));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $logo = $request->input();
        $uuid = Str::random(12);
        $file_name = 'logo_'.$uuid;
        $folderPath = "storage/uploads/giftcards/logos/";
        $img = $logo['content'];
        $image_parts = explode(";base64,", $img);
        $image_type_aux = explode("image/", $image_parts[0]);
        $image_type = $image_type_aux[1];
        $image_base64 = base64_decode($image_parts[1]);
        $file = $folderPath.$file_name . '.'.$image_type;

        $file_size = file_put_contents($file, $image_base64);
        $header = $request->header('Authorization');
        $api_token = str_replace('Bearer ', '', $header);
        $user = User::where('api_token', $api_token)->first();
        $saveData = array(
            'user_id' => $user['id'],
            'name' => $file_name,
            'extension' => $image_type,
            'uuid' => $uuid,
            'size' => $file_size,
        );

        $validator = Validator::make($saveData, [
            'user_id' => 'required',
            'name' => 'required',
            'extension' => 'required',
            'uuid' => 'required|unique:giftlogos',
            'size' => 'required'
        ]);
        if ($validator->fails()) {
            return response()->json(['success' => false, 'error' => $validator->messages()], 200);
        }
        $logo = Giftlogo::create($saveData);
        $logo['code'] = 20000;
        $logo['url'] = $logo->url;
        return response()->json($logo);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $logo = GiftLogo::find($id);
        $url = $logo->url;
        $logo->delete();
        File::delete($url);
        return response()->json(array('code'=>20000, 'logo'=>$logo));
    }

    protected function getUserToken($request) {
        $header = $request->header('Authorization');
        $api_token = str_replace('Bearer ', '', $header);
        return $api_token;
    }
}
