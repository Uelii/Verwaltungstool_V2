<?php

namespace immogate\Http\Controllers;

use Illuminate\Http\Request;
use immogate\Renter;
use immogate\Object;
use immogate\Building;
use immogate\Payment;
use immogate\Invoice;
use Session;
use DB;
use Carbon\Carbon;
use Config;

class InvoicesController extends Controller
{
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
    public function index()
    {
        $invoices = Invoice::all();

        return view('invoices.index', compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        /*Order objects and get all buildings from DB*/
        $objects = DB::table('objects')->orderBy('name', 'asc')->get();

        return view('invoices.create', compact('objects'));
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

        ]);

        /*Create record in database*/
        $invoice = new Invoice;
        $invoice->object_id = $request->object_id;
        $invoice->amount = $request->amount;
        $invoice->invoice_date = $request->invoice_date;
        $invoice->payable_until = $request->payable_until;
        $invoice->is_paid = 0;
        $invoice->invoice_type = $request->invoice_type;
        $invoice->save();

        /*Get data and redirect to specific route with success-message*/
        $invoices = Invoice::all();
        $objects = Object::all();

        return redirect()->route('invoices.index')->with(compact('invoices', 'objects'))->with('success_message', 'Invoice successfully added!');
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
        $invoice = Invoice::findOrFail($id);

        /*Get all other object except the one which is already stored in database*/
        $objects = Object::where('id', '!=', $invoice->object->id)->orderBy('name', 'asc')->get();

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
    public function update(Request $request, $id)
    {
        /*Validate Input*/
        $this->validate($request, [

        ]);

        $input = $request->all();
        $renter = Invoice::findOrFail($id);

        /*Update record in database*/
        $renter->fill($input)->save();

        /*Get data and redirect to specific route with success-message*/
        $invoices = Invoice::all();
        $objects = Object::all();

        return redirect()->route('invoices.index')->with(compact('invoices', 'objects'))->with('success_message', 'Invoice successfully updated!');
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
        $invoice = Invoice::findOrFail($id);
        $invoice->delete();

        return redirect()->back()->with('success_message', 'Invoice successfully deleted!');
    }
}
