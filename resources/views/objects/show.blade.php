<!--Layout to show one specific object-->

@extends('layouts.master')

@section('title')
    SHOW-Object
@endsection

@section('content')
    <section class="row">
        <div class="col-md-12">
            <h2>Object details</h2>
            <hr>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Object</div>
                    <div class="panel-body">
                        <h3>{{ $object->name }}</h3>
                        <hr>
                        <p><b>Description: </b>{{ $object->description }}</p>
                        <p><b>Living space [sqm]: </b>{{ $object->living_space }}</p>
                        <p><b>Number of rooms: </b>{{ $object->number_of_rooms }}</p>
                        <p><b>Floor number / Room number: </b>{{ $object->floor_room_number }}</p>
                        <p><b>Rent [Fr.], per annum: </b>{{ $object->rent }}</p>
                    </div>
                    <div class="panel-footer">
                        <a href="{{ url('/objects') }}" class="btn btn-info"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to overview</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection