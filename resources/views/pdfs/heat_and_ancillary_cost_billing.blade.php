@extends('layouts.master_pdfs')

@section('content')
    <section class="row data">
        <div class="col-md-12">
            <h1>Heat Billing / Ancillary Cost</h1>
            <hr>

            <h3>Building: {{ $building->name }},
                {{ $building->street }} {{ $building->street_number }},
                {{ $building->zip_code }} {{ $building->city }}
            </h3>
            <h3><b>Period  : {{ $start_date }} until {{ $end_date }}</b></h3>
            <hr>

            <div class="col-xs-6">
                <h3 class="sub-header">Heat Cost</h3>
                <table class="table heat_cost">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Amount</th>
                    </tr>
                    </thead>

                    <!--Display data-->
                    <tbody>
                    @foreach($heat_invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_date }}</td>
                            <td>{{ number_Format($invoice->amount, 2, '.', '')}}</td>
                        </tr>
                    @endforeach
                    </tbody>

                    <tfoot>
                        <tr>
                            <td><p class="pull-right"><b>Total</b></p></td>
                            <td><b>{{ number_Format($total_heat_cost, 2, '.', '')}}</b></td>
                        </tr>
                    </tfoot>
                </table>
            </div>

            <div class="col-xs-6">
                <h3 class="sub-header">Ancillary Cost</h3>
                <table class="table ancillary_cost">
                    <thead>
                    <tr>
                        <th>Date</th>
                        <th>Repair</th>
                        <th>Water</th>
                        <th>Power</th>
                        <th>Caretaker</th>
                        <th>Amount</th>
                    </tr>
                    </thead>

                    <!--Display data-->
                    <tbody>
                    @foreach($ancillary_invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->invoice_date }}</td>
                            <td>
                                @if($invoice->invoice_type == 'Repair')
                                    {{ number_format($invoice->amount, 2, '.', '') }}
                                @endif
                            </td>
                            <td>
                                @if($invoice->invoice_type == 'Water')
                                    {{ number_format($invoice->amount, 2, '.', '') }}
                                @endif
                            </td>
                            <td>
                                @if($invoice->invoice_type == 'Power')
                                    {{ number_format($invoice->amount, 2, '.', '') }}
                                @endif
                            </td>
                            <td>
                                @if($invoice->invoice_type == 'Caretaker')
                                    {{ number_format($invoice->amount, 2, '.', '') }}
                                @endif
                            </td>
                            <td>{{ number_format($invoice->amount, 2, '.', '') }} </td>
                        </tr>
                    @endforeach
                    </tbody>

                    <tfoot>
                    <tr>
                        <td><p class="pull-right"><b>Total</b></p></td>
                        <td><b>{{ number_format($total_repair_cost, 2, '.', '') }}</b></td>
                        <td><b>{{ number_format($total_water_cost, 2, '.', '') }}</b></td>
                        <td><b>{{ number_format($total_power_cost, 2, '.' , '') }}</b></td>
                        <td><b>{{ number_format($total_caretaker_cost, 2, '.', '') }}</b></td>
                        <td><b>{{ number_format($total_ancillary_cost, 2, '.', '') }}</b></td>
                    </tr>
                    </tfoot>
                </table>
            </div>

        </div>
    </section>
@endsection

