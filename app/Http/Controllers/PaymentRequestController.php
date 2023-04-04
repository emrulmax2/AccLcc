<?php

namespace App\Http\Controllers;

use App\Models\Payment_request;
use App\Http\Requests\PaymentRequestStorRequest;
use App\Models\User;

class PaymentRequestController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        return view('pages/payment_request/index', [
            'title' => 'Payment Request - LCC Account Management',
            'layout' => 'login'
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PaymentRequestStorRequest $request){
        $user_code = (isset($request->user_code) && !empty($request->user_code) ? $request->user_code : '');
        $usersRow = User::where('user_code', $user_code)->first();
        if(!empty($usersRow)):
            $docName = '';
            if($request->hasFile('user_code')):
                $docName = 'PYR_'.time() . '.' . $request->user_code->getClientOriginalExtension();
                $path = $request->file('user_code')->storeAs('public/storages', $docName);
            endif;
            
            $paymentRequest = Payment_request::create([
                'request_date' => date('Y-m-d'),
                'amount' => $request->amount,
                'description' => $request->description,
                'request_by' => $usersRow->id,
                'upload' => ($docName ? $docName : ''),
                'status' => 3
            ]);

            return response()->json($paymentRequest);
        else:
            return response()->json(['message' => 'User code does not found!'], 422);
        endif;
    }
}
