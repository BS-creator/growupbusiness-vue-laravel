<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;
use Validator;

use App\Customer;
use App\GiftcardHash;
use App\CusTransaction;

class CustomerController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $customers = Customer::all();
        for ($i=0; $i < count($customers); $i++) {
            $hashInfo = $customers[$i]->giftCardHash;
            // $customers[$i]['giftcard_hash'] = $hashInfo['hash'];
        }
        return response()->json(['customers' => $customers]);
    }

    // GET CUSTOMER LIST
    public function getCustomer(Request $request)
    {
        $hash = $request->input('hash');
        $hashInfo = GiftcardHash::where('hash', $hash)->first();
        if($hashInfo) {
            return response()->json(['customer' => $hashInfo->customer]);
        } else {
            return response()->json(['error' => "invalid hash"]);
        }
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $customer = $request->input();
        $validator = Validator::make($customer, [
            'email' => 'required|unique:customers',
            'giftcard_id' => 'required',
            'amount' => 'required',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()->first()], 422);
        }

        $createdOne = Customer::create($customer);

        $hash = $this->CreateGiftCard($createdOne);
        return response()->json(['giftcard_hash' => $hash, 'customer_id' => $createdOne['id'], 'amount' => $createdOne['amount']]);
    }

    //CREATE GIFTCARD WHEN USER IS CREATED
    public function CreateGiftCard($customer)
    {
        $hash = Str::random(16);
        $toGiftCardHash = [
            'customer_id' => $customer['id'],
            'hash' => $hash
        ];
        $validator = Validator::make($toGiftCardHash, [
            'customer_id' => 'required',
            'hash' => 'required|unique:giftcard_hashes',
        ]);
        if ($validator->fails()) {
            return response()->json(['error' => $validator->messages()->first()], 422);
        }
        $gCardHash = GiftCardHash::create($toGiftCardHash);
        return $gCardHash['hash'];
    }

    // GET GIFTCARD BY EMAIL
    public function getGiftCard(Request $request)
    {
        $email = $request->input('email');
        $customer = Customer::where('email', $email)->first();
        if($customer) {
            return response()->json(['giftcard_hash' => $customer->giftCardHash['hash']]);
        } else {
            return response()->json(['error' => 'user doesn\'t exist']);
        }
    }

    // WHEN USER USE HIS GIFTCARD // hash and amount
    public function useGiftCard(Request $request)
    {
        $data = $request->input();  // hash and amount
        $hash = GiftcardHash::where('hash', $data['hash'])->first();
        // return response()->json(['error' => $hash]);
        if($hash) {
            $usedAmount = DB::table('cus_transactions')
            ->select(DB::raw('SUM(amount) as total_used'))
            ->where('giftcard_hash_id', $hash['id'])
            ->first();

            $customer = $hash->customer;

            $usedAmount = $usedAmount->total_used ? $usedAmount->total_used : 0;
            $restAmount = $customer['amount'] - $usedAmount;
            if($data['amount'] > $restAmount) {
                return response()->json(['error' => 'You have only '.$restAmount]);
            }
            CusTransaction::create([
                'giftcard_hash_id' => $hash['id'],
                'amount' => $data['amount'],
                'description' => $data['description'],
                't_id' => $data['t_id'],
            ]);
            return response()->json([
                'total' => $customer['amount'],
                'beforeNow' => (int)($restAmount*100)/100,
                'now' => (int)(($restAmount-$data['amount'])*100)/100
            ]);
        } else {
            return response()->json(['error' => 'Gift Card doesn\' exist.']);
        }
    }

    // GET TRANSACTIONS HISTORY OF USER AND HIS GIFTCARD
    public function transactions(Request $request)
    {
        $hash = $request->input('hash');
        $hashInfo = GiftcardHash::where('hash', $hash)->first();
        // return response()->json(['transactions' => $hashInfo]);
        $transactions = CusTransaction::where('giftcard_hash_id', $hashInfo['id'])->orderBy('created_at','asc')->get();
        return response()->json(['transactions' => $transactions]);
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
        // $deletedRows = App\Flight::where('id', $id)->delete();
        // return response()->json(['deleted' => $deletedRows[0]]);
    }
}
