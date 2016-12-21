<!--Layout to create a new payment-->

@extends('layouts.master')

@section('title')
    CREATE-Payment
@endsection

@section('content')
    <section class="row">
        <div class="col-md-12">
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Create payment</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('payments.store') }}">
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

                            <div class="form-group{{ $errors->has('renter_id') ? ' has-error' : '' }}">
                                <label for="renter_id" class="col-md-4 control-label">Renter</label>

                                <div class="col-md-6">
                                    <select id="renter_id" class="form-control" name="renter_id" required>
                                        <option selected disabled value="" selected="selected">Please select...</option>
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
                                    <input id="amount_total" type="number" class="form-control" name="amount_total" step="any" value="{{ old('amount_total') }}" required>

                                    @if ($errors->has('amount_total'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('amount_total') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('amount_paid') ? ' has-error' : '' }}">
                                <label for="amount_paid" class="col-md-4 control-label">Amount paid [Fr.]</label>

                                <div class="col-md-6">
                                    <input id="amount_paid" type="number" class="form-control" name="amount_paid" step="any" value="0.00" required>

                                    @if ($errors->has('amount_paid'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('amount_paid') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('date') ? 'has-error' : '' }}">
                                <label for="date" class="col-md-4 control-label">Date</label>

                                <div class="col-md-6">
                                    <input id="date" type="text" class="form-control" name="date" value="{{ old('date') }}" required>

                                    @if ($errors->has('date'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('date') }}</strong>
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
                        <a href="{{ url('/payments') }}" class="btn btn-info"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to overview</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--JavaScript-->
    <script>
        loadDatepickerOnInputClick();
        changeRenterOnBuildingChange();
    </script>
@endsection