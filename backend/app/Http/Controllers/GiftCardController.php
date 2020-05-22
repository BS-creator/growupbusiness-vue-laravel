<?php

namespace App\Http\Controllers;


use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\DB;
use Validator;
use App\User;
use App\Giftcard;
use App\Helpers\Helper;

class GiftCardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = Helper::getCurrentUserByToken(Helper::getCurrentToken($request));
        $cards = $user->giftCards;
        return response()->json(array('code'=>20000, 'cards'=>$cards));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $cardId = $request->input('id');
        $card = $request->except('id');
        $user = Helper::getCurrentUserByToken(Helper::getCurrentToken($request));
        $uuid = Str::random(32);
        $card['user_id'] = $user['id'];
        $card['uuid'] = $uuid;
        $cardFromDB = Giftcard::find($cardId);
        if($cardFromDB) {
            Giftcard::where('id', $cardId)->update($card);
            $card['id'] = $cardId;
        } else {
            $card = Giftcard::create($card);
        }
        return response()->json(array('code'=>20000, 'card'=>$card));
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
        $card = GiftCard::find($id);
        $url = $card["card_url"];
        $card->delete();
        File::delete($url);
        return response()->json(array('code'=>20000, 'card'=>$card));
    }
}
