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
                            <h4>About</h4>
                            <hr>
                            <p><b>Beginning of contract: </b>{{ $renter->beginning_of_contract }}</p>

                            @if($renter->end_of_contract == '')
                                <p><b>End of contract: </b>n/a</p>
                            @else
                                <p><b>End of contract: </b>{{ $renter->end_of_contract }}</p>
                            @endif

                            <p><b>Adresse:</b></p>
                            <p>{{ $renter->street }} {{ $renter->street_number }}</p>
                            <p>{{ $renter->zip_code }} {{ $renter->city }}</p>

                            @if($renter->is_main_domicile == 1)
                                <p class="main_domicile_yes"><i class="fa fa-check" aria-hidden="true"></i> Main domicile</p>
                            @else
                                <p class="main_domicile_no"><i class="fa fa-times" aria-hidden="true"></i> Main domicile</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h4>Contact data</h4>
                            <hr>
                            <p><b>E-Mail: </b>{{ $renter->email }}</p>
                            <p><b>Phone landline: </b>
                                @if($renter->phone_landline = 'null')
                                    n/a
                                @else
                                    {{ $renter->phone_landline }}
                                @endif
                            </p>
                            <p><b>Phone mobile: </b>
                                @if($renter->phone_mobile_phone = 'null')
                                    n/a
                                @else
                                    {{ $renter->phone_mobile_phone }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <a href="{{ url('/renter') }}" class="btn btn-info"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to overview</a>
            </div>
        </div>
    </section>
@endsection