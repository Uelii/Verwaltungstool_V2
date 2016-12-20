<!--Layout to show one specific payment-->

@extends('layouts.master')

@section('title')
    SHOW-Payment
@endsection

@section('content')
    <section class="row">
        <div class="col-md-12">
            <h2>Payment details</h2>
            <hr>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Payment</div>
                    <div class="panel-body">
                        <div class="col-md-6">
                            <p><b>Amount total: </b>{{ number_Format($payment->amount_total, 2, '.', '\'') }} Fr.</p>
                            <p><b>Amount paid: </b>{{ number_Format($payment->amount_paid, 2, '.', '\'') }} Fr.</p>
                            <p><b>Date: </b>{{ $payment->date }}</p>
                            @if($payment->is_paid == 0)
                                <p class="is_paid_no"><i class="fa fa-times" aria-hidden="true"></i> NOT PAID</p>
                            @else
                                <p class="is_paid_yes"><i class="fa fa-check" aria-hidden="true"></i> PAID</p>
                            @endif
                            <p><b>Renter: </b>{{ $payment->renter->last_name }}, {{ $payment->renter->first_name }}</p>
                        </div>
                    </div>
                </div>

                <a href="{{ url('/payments') }}" class="btn btn-info"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to overview</a>
            </div>
        </div>
    </section>
@endsection