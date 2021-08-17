<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Payment;
use Illuminate\Http\Request;
use NumberFormatter;

class PaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::all();

        return view('payments')->with(compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $accounts = Account::all();
        return view('payments-create')->with(compact('accounts'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate([
            'payee_name' => 'required',
            'amount' => 'required',
            'account' => 'required|exists:accounts,id',
        ]);

        $serial = $this->getSerial($request->account);
        
        $payment = new Payment;
        $payment->payee_name = $request->payee_name;
        $payment->amount = $request->amount;
        $payment->account_id = $request->account;
        $payment->user_id = auth()->user()->id;
        $payment->amount_in_words =  $this->getAmountInWords((int)$request->amount);
        $payment->serial = $serial;

        $payment->save();

        return redirect()->to(route('payments'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function show(Payment $payment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function edit(Payment $payment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Payment $payment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Payment  $payment
     * @return \Illuminate\Http\Response
     */
    public function destroy(Payment $payment)
    {
        //
    }

    public function getAmountInWords($amount)
    {
        $f = new NumberFormatter("en", NumberFormatter::SPELLOUT);
        return $f->format($amount);
    }

    public function getSerial($accountId)
    {
        $account = Account::findOrFail($accountId);
        $lastestPaymentSerial = Payment::where('account_id', $accountId)->get()->max('serial');
        // next serial will be max serial id + 1
        if ($lastestPaymentSerial) {
            return $lastestPaymentSerial + 1;
        }
        // else there is no serial entry yet
        return $account->serial_start;
    }
}
