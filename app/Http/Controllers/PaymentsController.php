<?php

namespace grabem\Http\Controllers;

use Illuminate\Http\Request;
use grabem\Renter;
use grabem\Object;
use grabem\Building;
use grabem\Payment;
use Session;
use DB;

class PaymentsController extends Controller
{
    public function changeBooleanIsPaid(Request $request){

        DB::enableQueryLog();

        $payment = Payment::findOrFail($request->paymentId);
        $payment->is_paid = $request->new_boolean;

        if($request->new_boolean == 1){
            $payment->amount_paid = $request->amountTotal;
        } else {
            $payment->amount_paid = $request->amountPaid;
        }
        $payment->save();

        return ['is_paid' => $payment->is_paid];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $payments = Payment::all();

        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $renter = Renter::all();

        return view('renter.create', compact('renter'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        /*If the record has been found, access view*/
        $payment = Payment::findOrFail($id);

        /*Get all other renter except the one which is going to be edited*/
        $renter = Renter::where('id', '!=', $payment->renter->id)->get();


        return view('payments.edit', compact('payment', 'renter'));
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
        /*Validate Input*/
        $this->validate($request, [
            'renter_id' => 'required',
            'amount_paid' => 'required|numeric',
        ]);

        /*Update record in database*/
        $payment = Payment::findOrFail($id);
        $payment->renter_id = $request->renter_id;
        $payment->amount_paid = $request->amount_paid;

        if($request->amount_paid < $payment->amount_total){
            $payment->is_paid = 0;
            $payment->save();
        } else {
            $payment->is_paid = 1;
            $payment->save();
        }

        return redirect()->back()->with('success_message', 'Payment successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        /*Delete record in database*/
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->back()->with('success_message', 'Payment successfully deleted!');
    }
}
