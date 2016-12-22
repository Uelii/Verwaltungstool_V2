<?php

namespace immogate\Http\Controllers;

use Illuminate\Http\Request;
use immogate\Renter;
use immogate\Object;
use immogate\Building;
use immogate\Payment;
use Session;
use DB;
use Auth;

class PaymentsController extends Controller
{
    /*
    * Get id of current user
    */
    public function getUserId(){
        return Auth::user()->id;
    }

    public function changeBooleanIsPaid(Request $request){

        $payment = Payment::findOrFail($request->paymentId);
        $payment->is_paid = 1;
        $payment->amount_paid = $request->amountTotal;

        $payment->save();

        return ['is_paid' => $payment->is_paid];
    }

    public function getRenterData($id){
        $objects = DB::table('objects')->where('building_id', '=', $id)->get();

        foreach($objects as $object){
            $object_id_array[] = $object->id;
        }

        $renter= DB::table('renter')
            ->whereIn('object_id', $object_id_array)
            ->where('is_active', '=', 1)
            ->get();

        return response($renter);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $payments = Payment::all()->where('user_id', '=', $this->getUserId());

        return view('payments.index', compact('payments'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $buildings = Building::all()->where('user_id', '=', $this->getUserId());
        $objects = Object::all()->where('user_id', '=', $this->getUserId());
        $renter = Renter::all()->where('user_id', '=', $this->getUserId());

        return view('payments.create', compact('objects', 'renter', 'buildings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){
        /*Validate Input*/
        $this->validate($request, [
            'renter_id' => 'required',
            'amount_total' => 'required|numeric',
            'amount_paid' => 'required|numeric',
            'date' => 'required|date'
        ]);

        $input = $request->all();
        $input['user_id'] = $this->getUserId();

        unset($input['building_id']);

        if($request->amount_paid >= $request->amount_total){
            $input['is_paid'] = 1;
        } else {
            $input['is_paid'] = 0;
        }

        /*Create record in database*/
        Payment::create($input);

        return redirect()->route('payments.index')->with(compact('payments'))->with('success_message', 'Payment successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
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
    public function edit($id){
        /*If the record has been found, access view*/
        $payment = Payment::findOrFail($id);

        return view('payments.edit', compact('payment'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        /*Validate Input*/
        $this->validate($request, [
            'amount_paid' => 'required|numeric',
        ]);

        /*Update record in database*/
        $payment = Payment::findOrFail($id);
        $input = $request->all();
        $input['user_id'] = $this->getUserId();

        if($request->amount_paid >= $payment->amount_total){
            $input['is_paid'] = 1;
        } else {
            $input['is_paid'] = 0;
        }

        /*Update record in database*/
        $payment->fill($input)->save();

        return redirect()->back()->with('success_message', 'Payment successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        /*Delete record in database*/
        $payment = Payment::findOrFail($id);
        $payment->delete();

        return redirect()->back()->with('success_message', 'Payment successfully deleted!');
    }
}
