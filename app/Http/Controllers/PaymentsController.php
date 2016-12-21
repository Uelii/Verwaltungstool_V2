<?php

namespace immogate\Http\Controllers;

use Illuminate\Http\Request;
use immogate\Renter;
use immogate\Object;
use immogate\Building;
use immogate\Payment;
use Session;
use DB;
use Carbon\Carbon;

class PaymentsController extends Controller
{
    public function changeBooleanIsPaid(Request $request){

        $payment = Payment::findOrFail($request->paymentId);
        $payment->is_paid = 1;
        $payment->amount_paid = $request->amountTotal;

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
        $buildings = Building::all();
        $payments = Payment::all();

        return view('payments.index', compact('payments', 'buildings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $buildings = Building::all();
        $objects = Object::all();
        $renter = Renter::all();

        return view('payments.create', compact('objects', 'renter', 'buildings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*Validate Input*/
        $this->validate($request, [
            'building_id' => 'required',
            'renter_id' => 'required',
            'amount_total' => 'required|numeric',
            'amount_paid' => 'required|numeric',
            'date' => 'required|date'
        ]);

        /*Create record in database*/
        $payment = new Payment();
        $payment->building_id = $request->building_id;
        $payment->renter_id = $request->renter_id;
        $payment->amount_total = $request->amount_total;
        $payment->amount_paid = $request->amount_paid;
        if($request->amount_paid >= $payment->amount_total){
            $payment->is_paid = 1;
        } else {
            $payment->is_paid = 0;
        }
        $payment->date = $request->date;
        $payment->save();

        return redirect()->route('payments.index')->with(compact('payments'))->with('success_message', 'Payment successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        /*If the record has been found, access view*/
        $payment = Payment::findOrFail($id);

        return view('payments.show', compact('payment'));
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
            'amount_paid' => 'required|numeric',
        ]);

        /*Update record in database*/
        $payment = Payment::findOrFail($id);
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
