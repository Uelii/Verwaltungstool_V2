<?php

namespace App\Http\Controllers;

use App\Building;
use Illuminate\Http\Request;
use Session;

class BuildingsController extends Controller
{
    private $building;

    public function __constructor(Building $building)
    {
        $this->building = $building;
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $buildings = Building::paginate(3);

        return view('buildings.index')->with('buildings', $buildings);
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
            'name' => 'required|unique:buildings',
            'street' => 'required',
            'street_number' => 'required',
            'zip_code' => 'required',
            'city' => 'required'
        ]);

        $input = $request->all();

        //Create record in database
        Building::create($input);

        Session::flash('flash_message', 'Building successfully added!');

        /*$buildings = Building::paginate(3);*/

        return view('buildings.index')->with('buildings', $buildings);
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
        //If the record is found, access view
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
            'street_number' => 'required',
            'zip_code' => 'required',
            'city' => 'required'
        ]);

        $input = $request->all();

        //Update record in database
        $building->fill($input)->save();

        Session::flash('flash_message', 'Building successfully updated!');

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
        $building = Building::findOrFail($id);
        $building->delete();

        Session::flash('flash_message', 'Building successfully deleted!');

        return redirect()->route('buildings.index');
    }
}
