<!--Layout to show one specific renter-->

@extends('layouts.master')

@section('title')
    SHOW-Renter
@endsection

@section('content')
    <section class="row">
        <div class="col-md-12">
            <h2>Renter details</h2>
            <hr>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $renter->title }} {{ $renter->last_name }}, {{ $renter->first_name }}</div>
                    <div class="panel-body">
                        <div class="col-md-6">
                            <h4>Contact data</h4>
                            <hr>
                            <p><b>E-Mail: </b>{{ $renter->email }}</p>
                            <p><b>Phone landline: </b>
                                @if($renter->phone_landline = 'null')
                                    n/a
                                @else
                                {{ $renter->phone_landline }}</p>
                                @endif
                            <p><b>Phone mobile: </b>
                                @if($renter->phone_mobile_phone = 'null')
                                    n/a
                                @else
                                    {{ $renter->phone_mobile_phone }}</p>
                                @endif
                            </p>

                        </div>
                        <div class="col-md-6">
                            <p><b>???: </b>bla bla</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection