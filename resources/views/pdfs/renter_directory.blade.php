@extends('layouts.master_pdfs')

@section('content')
    <section class="row data">
        <div class="col-md-12">
            <h1>Renter Directory</h1>
            <hr>

            <h3>Building: {{ $building->name }},
                {{ $building->street }} {{ $building->street_number }},
                {{ $building->zip_code }} {{ $building->city }}
            </h3>

            <table class="table data">
                <thead>
                <tr>
                    <th>Renter</th>
                    <th>Renter Address</th>
                    <th>Beginning of Contract</th>
                    <th>End of Contract</th>
                    <th>Rent p.m.</th>
                </tr>
                </thead>

                <!--Display data-->
                <tbody>
                @foreach($renter_collection as $renter)
                    <tr>
                        <td>{{ $renter->last_name }}, {{ $renter->first_name }}</td>
                        <td>{{ $renter->street }} {{ $renter->street_number }}, {{ $renter->zip_code }}, {{ $renter->city }}</td>
                        <td>{{ $renter->beginning_of_contract }}</td>
                        <td>{{ $renter->end_of_contract }}</td>
                        <td>{{ number_Format($renter->object->rent, 2, '.', '\'') }} Fr.</td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

