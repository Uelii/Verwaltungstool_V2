@extends('layouts.master_pdfs')

@section('content')
    <section class="row data">
        <div class="col-md-12">
            <h1>Balance Sheet</h1>
            <hr>

            <h3>Building: {{ $building->name }},
                {{ $building->street }} {{ $building->street_number }},
                {{ $building->zip_code }} {{ $building->city }}
            </h3>
            <h3><b>Period  : {{ $start_date }} until {{ $end_date }}</b></h3>
            <hr>

            <div class="col-xs-6">
                <table class="table data">
                    <thead>
                    <tr>
                        <th>Description</th>
                        <th>Cost</th>
                        <th>Earnings</th>
                    </tr>
                    </thead>

                    <!--Display data-->
                    <tbody>
                    <tr>
                        <td>Net rent</td>
                        <td></td>
                        <td>{{ number_Format($total_rent_earnings, 2, '.', '') }}</td>
                    </tr>

                    <tr>
                        <td>...</td>
                        <td></td>
                        <td>...</td>
                    </tr>

                    <tr>
                        <td><b>Total earnings</b></td>
                        <td></td>
                        <td><b>{{ number_Format($total_rent_earnings, 2, '.', '') }}</b></td>
                    </tr>

                    <tr>
                        <td>Heat cost</td>
                        <td>{{ number_Format($total_heat_cost, 2, '.', '') }}</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Repair cost</td>
                        <td>{{ number_Format($total_repair_cost, 2, '.', '') }}</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Water cost</td>
                        <td>{{ number_Format($total_water_cost, 2, '.', '') }}</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Power cost</td>
                        <td>{{ number_Format($total_power_cost, 2, '.', '') }}</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td>Caretaker cost</td>
                        <td>{{ number_Format($total_caretaker_cost, 2, '.', '') }}</td>
                        <td></td>
                    </tr>

                    <tr>
                        <td><b>Total cost</b></td>
                        <td><b>{{ number_Format($total_cost, 2, '.', '') }}</b></td>
                        <td></td>
                    </tr>
                    </tbody>

                    <tfoot>
                    <tr>

                    </tr>
                    </tfoot>
                </table>
            </div>
        </div>
    </section>
@endsection

