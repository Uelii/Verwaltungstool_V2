<!--Layout to show one specific building-->

@extends('layouts.master')

@section('title')
    SHOW-Building
@endsection

@section('content')
    <section class="row">
        <div class="col-md-12">
            <h2>Building details</h2>
            <hr>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Building</div>
                    <div class="panel-body">
                        <h3>{{ $building->name }}</h3>
                        <hr>
                        <p><b>Street: </b>{{ $building->street }}</p>
                        <p><b>Street number: </b>{{ $building->street_number }}</p>
                        <p><b>Zip code: </b>{{ $building->zip_code }}</p>
                        <p><b>City: </b>{{ $building->city }}</p>
                    </div>
                    <div class="panel-footer">
                        <a href="{{ url('/buildings') }}" class="btn btn-info"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to overview</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection