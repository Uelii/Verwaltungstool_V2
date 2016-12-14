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
            <h3><b>Period  : {{ $start_date }} until {{ $end_date }}</b></h3>
            <hr>

            <table class="table data">
                <thead>
                <tr>
                    <th>Objects</th>
                    <th>Renter</th>
                    <th>Renter Address</th>
                    <th>Beginning of Contract</th>
                    <th>End of Contract</th>
                    <th>Rent p.a.</th>
                    <th>Nebenkosten?</th>
                </tr>
                </thead>

                <!--Display data-->
                <tbody>
                @foreach($building->objects as $object)
                    <tr>
                        <td>{{ $object->name }}</td>
                        <td>
                            @foreach($object->renter->sortBy('last_name') as $renter)
                            {{ $renter->last_name }} {{ $renter->first_name }}</br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($object->renter->sortBy('last_name') as $renter)
                            {{ $renter->street }} {{ $renter->street_number }}, {{ $renter->zip_code }}, {{ $renter->city }}</br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($object->renter->sortBy('last_name') as $renter)
                            {{ $renter->beginning_of_contract }}</br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($object->renter->sortBy('last_name') as $renter)
                            {{ $renter->end_of_contract }}</br>
                            @endforeach
                        </td>
                        <td>
                            @foreach($object->renter->sortBy('last_name') as $key => $renter)
                                @if($key == 0)
                                    {{ $object->rent }}</br>
                                @else
                                    "
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($object->renter->sortBy('last_name') as $key => $renter)
                                @if($key == 0)
                                    {{ $object->invoices->sum('amount') }}</br>
                                @else
                                    "
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
                </tbody>
            </table>
        </div>
    </section>
@endsection

