<?php

namespace immogate\Http\Controllers;

use immogate\Building;
use immogate\Object;
use Illuminate\Http\Request;
use Session;
use Auth;

class BuildingsController extends Controller
{
    /*
     * Get id of current user
     */
    public function getUserId(){
        return Auth::user()->id;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(){
        $buildings = Building::all()->where('user_id', '=', $this->getUserId());

        return view('buildings.index', compact('buildings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        return view('buildings.create');
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
            'name' => 'required|max:30|regex:/^[(0-9\a-zäöüéèàA-Z\ÄÖÜs\s\-\')]+$/u',
            'street' => 'required|regex:/^[(a-zäöüéèàA-Z\ÄÖÜs\s)]+$/u',
            'street_number' => 'required|regex:/^[(a-zA-Z0-9\s)]+$/u',
            'zip_code' => 'required|min:0|digits:4',
            'city' => 'required|regex:/^[(a-zäöüéèàA-ZÄÖÜs\s)]+$/u'
        ]);

        /*Create record in database*/
        $input = $request->all();
        $input['user_id'] = $this->getUserId();
        Building::create($input);

        /*Get data and redirect to specific route with success-message*/
        $buildings = Building::all()->where('user_id', '=', $this->getUserId());

        return redirect()->route('buildings.index')->with(compact('buildings'))->with('success_message', 'Building successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        /*If the record has been found, access view*/
        $building = Building::findOrFail($id);
        $objects = Object::all()->where('user_id', '=', $this->getUserId());

        return view('buildings.show', compact('building', 'objects'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        /*If the record has been found, access view*/
        $building = Building::findOrFail($id);

        return view('buildings.edit', compact('building'));
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
            'name' => 'required|max:30|regex:/^[(0-9\a-zäöüéèàA-Z\ÄÖÜs\s\-\')]+$/u',
            'street' => 'required|regex:/^[(a-zäöüéèàA-Z\ÄÖÜs\s)]+$/u',
            'street_number' => 'required|regex:/^[(a-zA-Z0-9\s)]+$/u',
            'zip_code' => 'required|min:0|digits:4',
            'city' => 'required|regex:/^[(a-zäöüéèàA-ZÄÖÜs\s)]+$/u'
        ]);

        /*Update record in database*/
        $building = Building::findOrFail($id);
        $input = $request->all();
        $input['user_id'] = $this->getUserId();
        $building->fill($input)->save();

        return redirect()->back()->with('success_message', 'Building successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        /*Delete record in database*/
        $building = Building::findOrFail($id);
        $building->delete();

        return redirect()->route('buildings.index')->with('success_message', 'Building successfully deleted!');
    }
}
