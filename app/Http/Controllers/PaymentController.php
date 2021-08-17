<?php

namespace App\Http\Controllers;

use App\Models\Account;
use App\Models\Payment;
use Illuminate\Http\Request;
use NumberFormatter;
use Intervention\Image\Facades\Image;

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

    public function download(Request $request, $id)
    {
        $payment = Payment::findOrFail($id);

        $img = Image::make(public_path($payment->account->cheque_image));
        
        // add text from database 
        $img->text($payment->serial, 1050, 155, function($font) {
            $font->file(public_path('fonts/OpenSans-Regular.ttf'));
            $font->size(21);
            $font->color('#000000');
        });

        $img->text($payment->payee_name, 100, 275, function($font) {
            $font->file(public_path('fonts/OpenSans-Regular.ttf'));
            $font->size(21);
            $font->color('#000000');
        });

        $img->text($payment->amount_in_words, 110, 315, function($font) {
            $font->file(public_path('fonts/OpenSans-Regular.ttf'));
            $font->size(21);
            $font->color('#000000');
        });

        $img->text($payment->account->iban, 110, 408, function($font) {
            $font->file(public_path('fonts/OpenSans-Regular.ttf'));
            $font->size(25);
            $font->color('#000000');
        });

        $img->text($payment->account->title, 34, 438, function($font) {
            $font->file(public_path('fonts/OpenSans-Regular.ttf'));
            $font->size(23);
            $font->color('#000000');
        });

        $img->text(implode("   ", str_split($payment->created_at->format('dmY'))), 995, 230, function($font) {
            $font->file(public_path('fonts/OpenSans-Regular.ttf'));
            $font->size(23);
            $font->color('#000000');
        });

        $img->text($payment->amount."/-", 1050, 330, function($font) {
            $font->file(public_path('fonts/OpenSans-Regular.ttf'));
            $font->size(21);
            $font->color('#000000');
        });

        $sign = Image::make(public_path($payment->account->signature_image));
        $sign = $sign->resize(null, 50, function ($constraint) {
            $constraint->aspectRatio();
        });
        $img->insert($sign, 'bottom-right', 150, 150);

        $img->save(public_path('image/demo-new.png')); 
        
        // dd('Watermark create successfully.');

        $name = 'cheque.jpg';

        $image = $img->encode('jpg');
        $headers = [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'attachment; filename='. $name,
        ];
        return response()->stream(function() use ($image) {
            echo $image;
        }, 200, $headers);
        
        return $img->response('png');
    }
}
