<?php

namespace immogate\Http\Controllers;

use immogate\Object;
use immogate\Building;
use immogate\Renter;
use Illuminate\Http\Request;
use Session;
use DB;
use Auth;

class ObjectsController extends Controller
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
        $objects = Object::all()->where('user_id', '=', $this->getUserId());

        return view('objects.index', compact('objects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(){
        $buildings = DB::table('buildings')
            ->where('user_id', '=', $this->getUserId())
            ->orderBy('name', 'asc')
            ->get();

        return view('objects.create', compact('buildings'));
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
            'building_id' => 'required',
            'name' => 'required|max:50|regex:/^[(0-9.,\\/_a-zäöüéèàA-Z\ÄÖÜs\s\-\')]+$/u',
            'description' => 'regex:/^[(0-9.,\\/_a-zäöüéèàA-Z\ÄÖÜs\s\-\')]+$/u',
            'living_space' => 'required|numeric|min:1',
            'number_of_rooms' => 'required|numeric|',
            'floor_room_number' => 'required|regex:/^[(0-9.,\\/_a-zäöüéèàA-Z\ÄÖÜs\s\-\')]+$/u',
            'rent' => 'required|numeric|min:0'
        ]);
        
        /*Create record in database*/
        $input = $request->all();
        $input['user_id'] = $this->getUserId();
        Object::create($input);

        /*Get data and redirect to specific route with success-message*/
        $objects = Object::all()->where('user_id', '=', $this->getUserId());

        return redirect()->route('objects.index')->with(compact('objects'))->with('success_message', 'Object successfully added!');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        /*If the record has been found, access view*/
        $object = Object::findOrFail($id);

        return view('objects.show', compact('object'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id){
        /*If the record has been found, access view*/
        $object = Object::findOrFail($id);

        /*Get all other buildings except the one which is going to be edited*/
        $buildings = DB::table('buildings')
            ->where('user_id', '=', $this->getUserId())
            ->where('id', '!=', $object->building->id)
            ->orderBy('name', 'asc')
            ->get();

        return view('objects.edit', compact('object', 'buildings'));
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
            'building_id' => 'required',
            'name' => 'required|max:50|regex:/^[(0-9.,\\/_a-zäöüéèàA-Z\ÄÖÜs\s\-\')]+$/u',
            'description' => 'regex:/^[(0-9.,\\/_a-zäöüéèàA-Z\ÄÖÜs\s\-\')]+$/u',
            'living_space' => 'required|numeric|min:1',
            'number_of_rooms' => 'required|numeric|',
            'floor_room_number' => 'required|regex:/^[(0-9.,\\/_a-zA-Z\s\-\')]+$/u',
            'rent' => 'required|numeric|min:0'
        ]);

        /*Update record in database*/
        $object = Object::findOrFail($id);
        $input = $request->all();
        $input['user_id'] = $this->getUserId();
        $object->fill($input)->save();

        return redirect()->back()->with('success_message', 'Object successfully updated!');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        /*Delete record in database*/
        $object = Object::findOrFail($id);
        $object->delete();

        return redirect()->back()->with('success_message', 'Object successfully deleted!');
    }
}
