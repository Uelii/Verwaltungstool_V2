@extends('layouts.master_pdfs')

@section('content')
    <section class="row data">
        <div class="col-md-12">
            <h1>List of Buildings</h1>
            <hr>

            <table class="table buildings_data">
                <thead>
                <tr>
                    <th class="col-md-1">ID</th>
                    <th class="col-md-3">Name</th>
                    <th class="col-md-3">Street</th>
                    <th class="col-md-1">Street number</th>
                    <th class="col-md-1">Zip code</th>
                    <th class="col-md-3">City</th>
                </tr>
                </thead>

                <!--Display data-->
                @foreach($buildings as $building)
                    <tr class="buildings_data">
                        <td>{{$building->id}}</td>
                        <td>{{$building->name}}</td>
                        <td>{{$building->street}}</td>
                        <td>{{$building->street_number}}</td>
                        <td>{{$building->zip_code}}</td>
                        <td>{{$building->city}}</td>
                    </tr>
                @endforeach
            </table>
        </div>
    </section>
@endsection

