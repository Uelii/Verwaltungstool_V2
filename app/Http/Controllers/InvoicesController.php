<?php

namespace immogate\Http\Controllers;

use Illuminate\Http\Request;
use immogate\Object;
use immogate\Building;
use immogate\Invoice;
use Session;
use DB;
use Config;
use Auth;

class InvoicesController extends Controller
{
    /*
    * Get id of current user
    */
    public function getUserId(){
        return Auth::user()->id;
    }

    public function getObjectData($id){
        $objects = DB::table('objects')->where('building_id', '=', $id)->get();

        return response($objects);
    }

    public function changeBooleanIsPaid(Request $request){
        $invoice = Invoice::findOrFail($request->invoiceId);
        $invoice->is_paid = 1;

        $invoice->save();

        return ['is_paid' => $invoice->is_paid];
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $invoices = Invoice::all()->where('user_id', '=', $this->getUserId());

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $buildings = Building::all()->where('user_id', '=', $this->getUserId());
        $invoice_types_enums = Config::get('enums.invoice_types');

        return view('invoices.create', compact('buildings', 'invoice_types_enums'));
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
            'object_id' => 'required',
            'invoice_type' => 'required',
            'amount' => 'required|numeric',
            'invoice_date' => 'required|date',
            'payable_until' => 'required|date'
        ]);

        $input = $request->all();
        $input['user_id'] = $this->getUserId();
        $input['is_paid'] = 0;

        unset($input['building_id']);

        /*Create record in database*/
        Invoice::create($input);

        return redirect()->route('invoices.index')->with(compact('invoices'))->with('success_message', 'Invoice successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        /*If the record has been found, access view*/
        $invoice = Invoice::findOrFail($id);

        return view('invoices.show', compact('invoice'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        /*If the record has been found, access view*/
        $invoice = Invoice::findOrFail($id);

        /*Get all other objects except the one which is already stored in database*/
        $objects = DB::table('objects')
            ->where('id', '!=', $invoice->object->id)
            ->where('user_id', '=', $this->getUserId())
            ->orderBy('name', 'asc')
            ->get();

        /*Get all other invoice-type enums except the one which is already stored in database*/
        $invoice_types_enums = Config::get('enums.invoice_types');
        if(($key = array_search($invoice->invoice_type, $invoice_types_enums)) !== false) {
            unset($invoice_types_enums[$key]);
        }

        return view('invoices.edit', compact('invoice', 'objects', 'invoice_types_enums'));
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
            'object_id' => 'required',
            'invoice_type' => 'required',
            'amount' => 'required|numeric',
            'invoice_date' => 'required|date',
            'payable_until' => 'required|date'
        ]);

        /*Update record in database*/
        $invoice = Invoice::findOrFail($id);
        $input = $request->all();
        $input['user_id'] = $this->getUserId();

        /*Update record in database*/
        $invoice->fill($input)->save();

        return redirect()->back()->with('success_message', 'Invoice successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        /*Delete record in database*/
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->back()->with('success_message', 'Invoice successfully deleted!');
    }
}
