<?php

namespace grabem\Http\Controllers;

use grabem\Renter;
use grabem\Object;
use grabem\Building;
use Illuminate\Http\Request;
use Session;
use DB;

class RenterController extends Controller
{
    /*
     * Fill in Street, Street number, zip code and city into renter creation form
     */
    public function fillInBuildingData($id) {
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
        $objects = Object::all();

        return view('renter.index', compact('renter', 'objects'));
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
        $buildings = Building::all();

        return view('renter.create', compact('objects', 'buildings'));
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
            'street' => 'required|max:255|regex:/^[(a-zäöüéèàA-Z\ÄÖÜs\s\-)]+$/u',
            'street_number' => 'required|numeric|min:0|digits_between:1,3',
            'zip_code' => 'required|min:0|digits:4',
            'city' => 'required|max:255|regex:/^[(a-zäöüéèàA-Z\ÄÖÜs\s\-)]+$/u',
            'is_main_domicile' => 'boolean',
            'beginning_of_contract' => 'required|date',
            'end_of_contract' => 'date'
        ]);

        $input = $request->all();
        $object_ids = $input['object_ids']; //array of selected object IDs

        /*Check if a contract end date has been entered*/
        if( empty($input['end_of_contract'])) {
            $input['end_of_contract'] = null;
        }

        /*
         * Create record in database
         * Create relationship in table 'object_renter' if one or more object(s) has/have been selected, else just create a new renter
         */
        if( !empty($input['object_ids']) && (! in_array('n/a', $object_ids))) {

            Renter::create($input);

            foreach($object_ids as $object_id){
                $object = Object::find($object_id);
                $renter_id = DB::table('renter')->orderBy('id', 'desc')->first()->id;
                $object->renter()->attach($renter_id);
            }
        } else {
            Renter::create($input);
        }

        /*Get data and redirect to specific route with success-message*/
        $renter = Renter::all();
        $objects = Object::all();

        return redirect()->route('renter.index')->with(compact('renter', 'objects'))->with('success_message', 'Renter successfully added!');
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

        /*Get all other objects except the ones which already are in relation to this renter*/
        foreach($renter->objects as $object){
            $list_of_object_ids[] = $object->id;
        }
        $objects = DB::table('objects')->whereNotIn('id', $list_of_object_ids)->get();

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
            'street' => 'required|max:255|regex:/^[(a-zäöüéèàA-Z\ÄÖÜs\s\-)]+$/u',
            'street_number' => 'required|numeric|min:0|digits_between:1,3',
            'zip_code' => 'required|min:0|digits:4',
            'city' => 'required|max:255|regex:/^[(a-zäöüéèàA-Z\ÄÖÜs\s\-)]+$/u',
            'is_main_domicile' => 'boolean',
            'beginning_of_contract' => 'required|date',
            'end_of_contract' => 'date'
        ]);

        /*Update record in database*/
        $input = $request->all();
        $renter = Renter::findOrFail($id);
        $object_ids = $input['object_ids']; //array of selected object IDs
        $existing_corr_objects = $renter->objects;

        foreach($existing_corr_objects as $corr_object){
            $ids[] = $corr_object->id;
        }

        /*Check if a contract end date has been entered*/
        if( empty($input['end_of_contract'])) {
            $input['end_of_contract'] = null;
        }

        /*
         * Update record in database
         * Create relationship in table 'object_renter' if one or more additional object(s) has/have been selected, else just update the renter
         */
        if( !empty($input['object_ids']) && (! in_array('n/a', $object_ids))) {

            $renter->fill($input)->save();

            $difference = array_diff($object_ids, $ids);

            if(!empty($difference)){
                foreach($difference as $additional_object_id){
                    $object = Object::find($additional_object_id);
                    $object->renter()->attach($id);
                }
            }
        } else {
            $renter->fill($input)->save();
        }

        return redirect()->back()->with('success_message', 'Renter successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request, $id)
    {
        $renter = Renter::findOrFail($id);

        /*If renter is attached to one or more object(s), detach them before deleting*/
        if(count($renter->objects)){
            /*detach all objects from renter*/
            $renter->objects()->detach();

            /*delete renter*/
            $renter->delete();

            /*Display Success-Message*/
            Session::flash('success_message', 'Renter successfully deleted!');

            if($request->request_from = 'object_view'){
                return ['url' => url('/objects')];
            } elseif ($request->request_from = 'renter_view') {
                return ['url' => url('/renter')];
            }

        } else {
            /*delete renter*/
            $renter->delete();

            /*Display Success-Message*/
            Session::flash('success_message', 'Renter successfully deleted!');

            if($request->request_from = 'object_view'){
                return ['url' => url('/objects')];
            } elseif ($request->request_from = 'renter_view') {
                return ['url' => url('/renter')];
            }
        }
    }
}
