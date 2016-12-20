<!--Layout to show one specific invoice-->

@extends('layouts.master')

@section('title')
    SHOW-Invoice
@endsection

@section('content')
    <section class="row">
        <div class="col-md-12">
            <h2>Invoice details</h2>
            <hr>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Invoice</div>
                    <div class="panel-body">
                        <div class="col-md-6">
                            <p><b>Type: </b>{{ $invoice->invoice_type }}</p>
                            <p><b>Amount: </b>{{ number_Format($invoice->amount, 2, '.', '\'') }} Fr.</p>
                            <p><b>Date: </b>{{ $invoice->invoice_date }}</p>
                            <p><b>Payable until: </b>{{ $invoice->payable_until }}</p>
                            <p><b>Payment status: </b>
                                @if($invoice->is_paid == 0)
                                    <p class="is_paid_no"><i class="fa fa-times" aria-hidden="true"></i> NOT PAID</p>
                                @else
                                    <p class="is_paid_yes"><i class="fa fa-check" aria-hidden="true"></i> PAID</p>
                                @endif
                            <p><b>Object: </b>{{ $invoice->object->name}} | {{ $invoice->object->building->street}} {{ $invoice->object->building->street_number}}, {{ $invoice->object->building->zip_code}} {{ $invoice->object->building->city}}</p>
                        </div>
                    </div>
                </div>

                <a href="{{ url('/invoices') }}" class="btn btn-info"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to overview</a>
            </div>
        </div>
    </section>
@endsection