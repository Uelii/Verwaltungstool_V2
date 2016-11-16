<!--Layout to add a new object-->

@extends('layouts.master')

@section('title')
    CREATE-Objects
@endsection

@section('content')
    <section class="row">
        <div class="col-md-12">
            <h2>Add a new object</h2>
            <hr>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add object</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('objects.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('building_id') ? 'has-error' : '' }}">
                                <label for="building_id" class="col-md-4 control-label">Building</label>

                                <div class="col-md-6">
                                    <select id="building_id" class="form-control" name="building_id" required autofocus>
                                        @foreach($buildings as $building)
                                            <option value="{{ $building->id }}"> {{ $building->name }}:
                                                {{ $building->street }} {{$building->street_number}},
                                                {{ $building->zip_code }} {{ $building->city }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('building_id'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('building_id') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('name') ? ' has-error' : '' }}">
                                <label for="name" class="col-md-4 control-label">Name</label>

                                <div class="col-md-6">
                                    <input id="name" type="text" class="form-control" name="name" value="{{ old('name') }}" required autofocus>

                                    @if ($errors->has('name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('description') ? ' has-error' : '' }}">
                                <label for="description" class="col-md-4 control-label">Description</label>

                                <div class="col-md-6">
                                    <textarea id="description" class="form-control" rows="5" name="description" value="{{ old('description') }}" required></textarea>

                                    @if ($errors->has('description'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('description') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('living_space') ? ' has-error' : '' }}">
                                <label for="living_space" class="col-md-4 control-label">Living space [sqm]</label>

                                <div class="col-md-6">
                                    <input id="living_space" type="number" class="form-control" name="living_space" step="any" value="{{ old('living_space') }}" required>

                                    @if ($errors->has('living_space'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('living_space') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('number_of_rooms') ? ' has-error' : '' }}">
                                <label for="number_of_rooms" class="col-md-4 control-label">Number of rooms</label>

                                <div class="col-md-6">
                                    <select id="number_of_rooms" type="number" class="form-control" name="number_of_rooms" step="any" value="{{ old('number_of_rooms') }}" required>
                                        <option>0.5</option>
                                        <option>1.0</option>
                                        <option>1.5</option>
                                        <option>2.0</option>
                                        <option>2.5</option>
                                        <option>3.0</option>
                                        <option>3.5</option>
                                        <option>4.0</option>
                                        <option>4.5</option>
                                        <option>5.0</option>
                                        <option>5.5</option>
                                        <option>6.0</option>
                                    </select>

                                    @if ($errors->has('number_of_rooms'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('number_of_rooms') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('floor_room_number') ? ' has-error' : '' }}">
                                <label for="floor_room_number" class="col-md-4 control-label">Floor number / Room number</label>

                                <div class="col-md-6">
                                    <input id="floor_room_number" type="number" class="form-control" name="floor_room_number" step="any" value="{{ old('floor_room_number') }}" required>

                                    @if ($errors->has('floor_room_number'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('floor_room_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('rent') ? ' has-error' : '' }}">
                                <label for="rent" class="col-md-4 control-label">Rent [Fr.], per annum</label>

                                <div class="col-md-6">
                                    <input id="rent" type="number" class="form-control" name="rent" step="any" value="{{ old('rent') }}" required>

                                    @if ($errors->has('rent'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('rent') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Add
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-footer">
                        <a href="{{ url('/objects') }}" class="btn btn-info"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to overview</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection