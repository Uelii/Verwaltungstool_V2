<!--Layout to show all renter-->

@extends('layouts.master')

@section('title')
    INDEX-Renter
@endsection

@section('content')
    <section class="row data">
        <div class="col-md-12">
            <h2>Overview Renter</h2>
            <hr>

            <div class="table-responsive">
                <table id="renter_data" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Contact data</th>
                        <th>Street</th>
                        <th>No.</th>
                        <th>Zip code</th>
                        <th>City</th>
                        <th>Beginning</th>
                        <th>End</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <!--Display data-->
                    <tbody>
                    @foreach($renter as $renter)
                        <tr>
                            <td>{{ $renter->title }}</td>
                            <td>{{ $renter->first_name }}</td>
                            <td>{{ $renter->last_name }}</td>
                            <td>{{ $renter->email }} </br> {{$renter->phone_landline}} </br> {{ $renter->phone_mobile_phone }} </br>
                                @if($renter->is_main_domicile == 1)
                                    <i class="fa fa-check" aria-hidden="true"></i> Main domicile
                                @else
                                    <i class="fa fa-times" aria-hidden="true"></i> Main domicile
                                @endif
                            </td>
                            <td>{{ $renter->street }}</td>
                            <td>{{ $renter->street_number }}</td>
                            <td>{{ $renter->zip_code }}</td>
                            <td>{{ $renter->city }}</td>
                            <td>{{ $renter->beginning_of_contract }}</td>
                            <td>{{ $renter->end_of_contract }}</td>
                            <td>
                                <a href="{{ route('renter.show', $renter->id) }}" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i> Show</a>
                                <a href="{{ route('renter.edit', $renter->id) }}" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                            </td>
                        </tr>
                    @endforeach
                </table>

                <!--jQuery option to sort table data-->
                <script>
                    addSortTableOptions('renter_data');
                </script>

                <a href="{{ url('/renter/create')}}" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add new renter</a>
            </div>
        </div>
    </section>
@endsection