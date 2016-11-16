<?php

namespace App\Http\Controllers;

use App\Building;
use App\Object;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Session;

class BuildingsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $buildings = Building::all();
        $objects = Object::all();

        return view('buildings.index', compact('buildings', 'objects'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('buildings.create');
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
            'name' => 'required|alpha|unique:buildings',
            'street' => 'required|alpha',
            'street_number' => 'required|numeric|min:0|digits_between:1,3',
            'zip_code' => 'required|min:0|digits:4',
            'city' => 'required|alpha'
        ]);

        //Create record in database
        $input = $request->all();
        Building::create($input);

        //Return whole array and display Success-Message
        $buildings = Building::all();
        $objects = Object::all();
        Session::flash('success_message', 'Building successfully added!');

        return view('buildings.index', compact('buildings', 'objects'));
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
        $building = Building::findOrFail($id);
        return view('buildings.show')->with('building', $building);
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
        $building = Building::findOrFail($id);
        return view('buildings.edit')->with('building', $building);
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
        $building = Building::findOrFail($id);

        //Validate Input
        $this->validate($request, [
            'name' => 'required',
            'street' => 'required',
            'street_number' => 'required|numeric',
            'zip_code' => 'required|numeric',
            'city' => 'required'
        ]);

        //Update record in database
        $input = $request->all();
        $building->fill($input)->save();

        //Display Success-Message
        Session::flash('success_message', 'Building successfully updated!');

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
        try {
            //Delete record in database
            $building = Building::findOrFail($id);
            $building->delete();

            //Display Success-Message
            Session::flash('success_message', 'Building successfully deleted!');

            return redirect()->route('buildings.index');
        } catch(QueryException $e) {
            Session::flash('error_message', 'This building cannot be deleted!');
            return redirect()->route('buildings.index');
        }

    }
}
