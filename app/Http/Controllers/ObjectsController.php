<?php

namespace App\Http\Controllers;

use App\Object;
use App\Building;
use Illuminate\Http\Request;
use Session;

class ObjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $objects = Object::all();
        $buildings = Building::all();

        return view('objects.index', compact('objects', 'buildings'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $buildings = Building::all();

        return view('objects.create', compact('buildings'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //Validate Input
        $this->validate($request, [
            'building_id' => 'required',
            'name' => 'required|regex:/^[(a-zA-Z\s)]+$/u|unique:objects',
            'living_space' => 'required|numeric|min:1',
            'number_of_rooms' => 'required|numeric|',
            'floor_room_number' => 'required|numeric',
            'rent' => 'required|numeric|min:0'
        ]);
        
        //Create record in database
        $input = $request->all();
        Object::create($input);

        //Return whole array and display Success-Message
        $objects = Object::all();
        $buildings = Building::all();
        Session::flash('success_message', 'Object successfully added!');

        return view('objects.index', compact('objects', 'buildings'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //If the record has been found, access view
        $object = Object::findOrFail($id);

        return view('objects.show', compact('object'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //If the record has been found, access view
        $object = Object::findOrFail($id);
        $buildings = Building::all();

        return view('objects.edit', compact('object', 'buildings'));
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
        $object = Object::findOrFail($id);

        //Validate Input
        $this->validate($request, [
            'building_id' => 'required',
            'name' => 'required|regex:/^[(a-zA-Z\s)]+$/u',
            'living_space' => 'required|numeric|min:1',
            'number_of_rooms' => 'required|numeric|',
            'floor_room_number' => 'required|numeric',
            'rent' => 'required|numeric|min:0'
        ]);

        //Update record in database
        $input = $request->all();
        $object->fill($input)->save();

        //Display Success-Message
        Session::flash('success_message', 'Object successfully updated!');

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //Delete record in database
        $object = Object::findOrFail($id);
        $object->delete();

        //Display Success-Message
        Session::flash('success_message', 'Object successfully deleted!');

        return redirect()->route('objects.index');
    }
}
