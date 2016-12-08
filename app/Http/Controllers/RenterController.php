<?php

namespace grabem\Http\Controllers;

use Illuminate\Http\Request;
use grabem\Renter;
use grabem\Object;
use grabem\Building;
use grabem\Payment;
use Session;
use DB;
use Carbon\Carbon;

class RenterController extends Controller
{
    /*
     * Fill in Street, Street number, zip code and city into renter creation form
     */
    public function getBuildingData($id) {
        $building = Building::findOrFail(Object::findOrFail($id)->building_id);
        $building_street = $building->street;
        $building_street_number = $building->street_number;
        $building_zip_code = $building->zip_code;
        $building_city = $building->city;

        return response([
            'building_street' => $building_street,
            'building_street_number' => $building_street_number,
            'building_zip_code' => $building_zip_code,
            'building_city' => $building_city
        ]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $renter = Renter::all();

        return view('renter.index', compact('renter'));
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

        return view('renter.create', compact('objects'));
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
            'title' => 'required|in:Mr.,Ms.',
            'first_name' => 'required|max:255|regex:/^[(a-zäöüéèàA-Z\ÄÖÜs\s\-)]+$/u',
            'last_name' => 'required|max:255|regex:/^[(a-zäöüéèàA-Z\ÄÖÜs\s\-)]+$/u',
            'email' => 'required|email|max:255|unique:renter',
            'phone_landline' => 'max:255|regex:/(0)([0-9]{2})\s([0-9]{3})\s([0-9]{2})\s([0-9]{2})/', /*Format 0xx xxx xx xx*/
            'phone_mobile_phone' => 'max:255|regex:/(0)([0-9]{2})\s([0-9]{3})\s([0-9]{2})\s([0-9]{2})/', /*Format 0xx xxx xx xx*/
            'object_id' => 'required',
            'street' => 'required|max:255|regex:/^[(a-zäöüéèàA-Z\ÄÖÜs\s\-)]+$/u',
            'street_number' => 'required|numeric|min:0|digits_between:1,3',
            'zip_code' => 'required|min:0|digits:4',
            'city' => 'required|max:255|regex:/^[(a-zäöüéèàA-Z\ÄÖÜs\s\-)]+$/u',
            'is_main_domicile' => 'boolean',
            'beginning_of_contract' => 'required|date',
            'end_of_contract' => 'date'
        ]);

        $input = $request->all();

        /*Check if a contract end date has been entered*/
        if( empty($input['end_of_contract'])) {
            $input['end_of_contract'] = null;
        }

        /*Create record in database*/
        Renter::create($input);

        /*Create new record in table 'payments' (pending payment)*/
        $new_renter_id = DB::table('renter')->orderBy('id', 'desc')->first()->id;
        $corr_object = Object::findOrFail($request->object_id);
        $corr_object_rent = $corr_object->rent;
        $current_date = Carbon::today()->format('Y-m-d');

        $payment = new Payment;
        $payment->renter_id = $new_renter_id;
        $payment->amount_total = $corr_object_rent/12;
        $payment->amount_paid = 0.00;
        $payment->is_paid = 0;
        $payment->date = $current_date;
        $payment->save();

        /*Get data and redirect to specific route with success-message*/
        $renter = Renter::all();

        return redirect()->route('renter.index')->with(compact('renter'))->with('success_message', 'Renter successfully added!');
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
        $renter = Renter::findOrFail($id);

        return view('renter.show', compact('renter'));
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
        $renter = Renter::findOrFail($id);

        /*Get all other object except the one which is going to be edited*/
        $objects = Object::where('id', '!=', $renter->object->id)->orderBy('name', 'asc')->get();

        return view('renter.edit', compact('renter', 'objects'));
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
            'title' => 'required|in:Mr.,Ms.',
            'first_name' => 'required|max:255|regex:/^[(a-zäöüéèàA-Z\ÄÖÜs\s\-)]+$/u',
            'last_name' => 'required|max:255|regex:/^[(a-zäöüéèàA-Z\ÄÖÜs\s\-)]+$/u',
            'email' => 'required|email|max:255',
            'phone_landline' => 'max:255|regex:/(0)([0-9]{2})\s([0-9]{3})\s([0-9]{2})\s([0-9]{2})/', /*Format 0xx xxx xx xx*/
            'phone_mobile_phone' => 'max:255|regex:/(0)([0-9]{2})\s([0-9]{3})\s([0-9]{2})\s([0-9]{2})/', /*Format 0xx xxx xx xx*/
            'object_id' => 'required',
            'street' => 'required|max:255|regex:/^[(a-zäöüéèàA-Z\ÄÖÜs\s\-)]+$/u',
            'street_number' => 'required|numeric|min:0|digits_between:1,3',
            'zip_code' => 'required|min:0|digits:4',
            'city' => 'required|max:255|regex:/^[(a-zäöüéèàA-Z\ÄÖÜs\s\-)]+$/u',
            'is_main_domicile' => 'boolean',
            'beginning_of_contract' => 'required|date',
            'end_of_contract' => 'date'
        ]);

        $input = $request->all();
        $renter = Renter::findOrFail($id);

        /*Check if a contract end date has been entered*/
        if( empty($input['end_of_contract'])) {
            $input['end_of_contract'] = null;
        }
        /*Update record in database*/

        $renter->fill($input)->save();

        return redirect()->back()->with('success_message', 'Renter successfully updated!');
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
        $renter = Renter::findOrFail($id);
        $renter->delete();

        return redirect()->back()->with('success_message', 'Renter successfully deleted!');
    }
}
