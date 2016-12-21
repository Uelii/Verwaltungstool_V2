<!--Layout to add a new invoice-->

@extends('layouts.master')

@section('title')
    CREATE-Invoice
@endsection

@section('content')
    <section class="row">
        <div class="col-md-12">
            <h2>Add a new invoice</h2>
            <hr>

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add invoice</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('invoices.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('building_id') ? 'has-error' : '' }}">
                                <label for="building_id" class="col-md-4 control-label">Building</label>

                                <div class="col-md-6">
                                    <select id="building_id" class="form-control" name="building_id" required autofocus>
                                        <option selected disabled value="">Please select...</option>
                                        @foreach($buildings as $building)
                                            <option value="{{ $building->id }}"> {{ $building->name }}:
                                                {{ $building->street }} {{$building->street_number}},
                                                {{ $building->zip_code }} {{ $building->city }}</option>
                                        @endforeach
                                    </select>

                                    @if ($errors->has('building_id'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('building_id') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>


                            <div class="form-group{{ $errors->has('object_id') ? 'has-error' : '' }}">
                                <label for="object_id" class="col-md-4 control-label">Object</label>

                                <div class="col-md-6">
                                    <select id="object_id" class="form-control" name="object_id" required>
                                        <option selected disabled value="">Please select...</option>
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
                                        <option selected disabled value="" >Please select...</option>

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
                                    <input id="amount" type="number" class="form-control" name="amount" step="any" value="{{ old('amount') }}" required>

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
                                    <input id="invoice_date" type="text" class="form-control" name="invoice_date" value="{{ old('invoice_date') }}" required>

                                    @if ($errors->has('invoice_date'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('invoice_date') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('payable_until') ? 'has-error' : '' }}">
                                <label for="payable_until" class="col-md-4 control-label">Payable until</label>

                                <div class="col-md-6">
                                    <input id="payable_until" type="text" class="form-control" name="payable_until" value="{{ old('payable_until') }}" required>

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
                                        Add
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
        changeObjectOnBuildingChange()
        loadDatepickerOnInputClick();
    </script>
@endsection