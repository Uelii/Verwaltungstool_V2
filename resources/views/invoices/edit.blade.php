<!--Layout to edit a specific invoice-->

@extends('layouts.master')

@section('title')
    EDIT-Invoice
@endsection

@section('content')
    <section class="row">
        <div class="col-md-12">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Edit invoice</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('invoices.update', $invoice->id) }}">
                            <input type="hidden" name="_method" value="PATCH">
                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                            <div class="form-group{{ $errors->has('object_id') ? 'has-error' : '' }}">
                                <label for="object_id" class="col-md-4 control-label">Object</label>

                                <div class="col-md-6">
                                    <select id="object_id" class="form-control" name="object_id" required>

                                        <option value="{{ $invoice->object->id }}" selected="selected"> {{ $invoice->object->name }}:
                                            {{ $invoice->object->living_space }} sqm, {{$invoice->object->number_of_rooms}}-room,
                                            {{ $invoice->object->floor_room_number }}
                                        </option>

                                        @foreach($objects as $object)
                                            <option value="{{ $object->id }}"> {{ $object->name }}:
                                                {{ $object->living_space }} sqm, {{$object->number_of_rooms}}-room,
                                                {{ $object->floor_room_number }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('object_id'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('object_id') }}</strong>
                                        </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('invoice_type') ? 'has-error' : '' }}">
                                <label for="title" class="col-md-4 control-label">Invoice type</label>

                                <div class="col-md-6">
                                    <select id="invoice_type" class="form-control" name="invoice_type" required>
                                        <option value="{{ $invoice->invoice_type }}" selected="selected">
                                            {{ $invoice->invoice_type }}
                                        </option>

                                        @foreach($invoice_types_enums as $key => $invoice_type)
                                            <option value="{{ $key }}">
                                                {{ $invoice_type }}
                                            </option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('invoice_type'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('invoice_type') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('amount') ? 'has-error' : '' }}">
                                <label for="amount" class="col-md-4 control-label">Amount [Fr.]</label>

                                <div class="col-md-6">
                                    <input id="amount" type="number" class="form-control" name="amount" step="any" value="{{ number_Format($invoice->amount, 2, '.', '') }}" required>

                                    @if ($errors->has('amount'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('amount') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('invoice_date') ? 'has-error' : '' }}">
                                <label for="invoice_date" class="col-md-4 control-label">Invoice date</label>

                                <div class="col-md-6">
                                    <input id="invoice_date" type="text" class="form-control" name="invoice_date" value="{{ $invoice->invoice_date }}" required>

                                    @if ($errors->has('invoice_date'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('invoice_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div><div class="form-group{{ $errors->has('payable_until') ? 'has-error' : '' }}">
                                <label for="payable_until" class="col-md-4 control-label">Payable until</label>

                                <div class="col-md-6">
                                    <input id="payable_until" type="text" class="form-control" name="payable_until" value="{{ $invoice->payable_until }}" required>

                                    @if ($errors->has('payable_until'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('payable_until') }}</strong>
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
                        <a href="{{ url('/invoices') }}" class="btn btn-info"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to overview</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--JavaScript-->
    <script>
        loadDatepickerOnInputClick();
    </script>
@endsection