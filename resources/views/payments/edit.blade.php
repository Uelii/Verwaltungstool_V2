<!--Layout to edit a payment-->

@extends('layouts.master')

@section('title')
    EDIT-Payment
@endsection

@section('content')
    <section class="row">
        <div class="col-md-12">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit payment</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('payments.update', $payment->id) }}">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div class="form-group{{ $errors->has('building_id') ? ' has-error' : '' }}">
                                <label for="building_id" class="col-md-4 control-label">Building</label>

                                <div class="col-md-6">
                                    <label for="building_id" class="control-label">{{ $payment->renter->object->building->name }}</label>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('object_id') ? ' has-error' : '' }}">
                                <label for="object_id" class="col-md-4 control-label">Object</label>

                                <div class="col-md-6">
                                    <label for="object_id" class="control-label">{{ $payment->renter->object->name }}</label>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('renter_id') ? ' has-error' : '' }}">
                                <label for="renter_id" class="col-md-4 control-label">Renter</label>

                                <div class="col-md-6">
                                    <select id="renter_id" class="form-control" name="renter_id" required>

                                        <option value="{{ $payment->renter->id }}" selected="selected">{{ $payment->renter->last_name }}, {{ $payment->renter->first_name }}:
                                            {{ $payment->renter->street }} {{ $payment->renter->street_number }},
                                            {{ $payment->renter->zip_code }} {{ $payment->renter->city }}
                                        </option>

                                        @foreach($renter as $renter)
                                            <option value="{{ $renter->id }}"> {{ $renter->last_name }}, {{ $renter->first_name }}:
                                                {{ $renter->street }} {{ $renter->street_number }},
                                                {{ $renter->zip_code }} {{ $renter->city }}
                                            </option>
                                        @endforeach

                                    </select>

                                    @if ($errors->has('renter_id'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('renter_id') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('amount_total') ? ' has-error' : '' }}">
                                <label for="amount_total" class="col-md-4 control-label">Amount total [Fr.]</label>

                                <div class="col-md-6">
                                    <label for="amount_total" class="control-label">{{ number_Format($payment->amount_total, 2, '.', '') }}</label>
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('amount_paid') ? ' has-error' : '' }}">
                                <label for="amount_paid" class="col-md-4 control-label">Amount paid [Fr.]</label>

                                <div class="col-md-6">
                                    <input id="amount_paid" type="number" class="form-control" name="amount_paid" step="any" value="{{ number_Format($payment->amount_paid, 2, '.', '') }}" required>
                                    @if ($errors->has('amount_paid'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('amount_paid') }}</strong>
                                    </span>
                                    @endif
                                </div>

                            </div>

                            <div class="form-group">
                                <div class="col-md-8 col-md-offset-4">
                                    <button type="submit" class="btn btn-primary">
                                        Update
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="panel-footer">
                        <a href="{{ url('/payments') }}" class="btn btn-info"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to overview</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection