<!--Layout to create reports-->

@extends('layouts.master')

@section('title')
    Reports
@endsection

@section('content')
    <section class="row data">
        <div class="col-md-12">
            <h2>Create report</h2>
            <hr>

            <div class="col-md-4">
                <form class="form-horizontal" role="form" method="POST" action="{{ url('/createPDF') }}">
                    {{ csrf_field() }}

                    <div class="form-group{{ $errors->has('building_id') ? ' has-error' : '' }}">
                        <label for="building_id" class="control-label">Building</label>
                        <select id="building_id" class="form-control" name="building_id" value="{{ old('building_id') }}" required autofocus>
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

                    <div class="form-group{{ $errors->has('start_date') ? ' has-error' : '' }}">
                        <label for="start_date" class="control-label">Start Date</label>
                        <input id="start_date" class="form-control" name="start_date" value="{{ old('start_date') }}">

                        @if ($errors->has('start_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('start_date') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group{{ $errors->has('end_date') ? ' has-error' : '' }}">
                        <label for="end_date" class="control-label">End Date</label>
                        <input id="end_date" class="form-control" name="end_date" value="{{ old('end_date') }}">

                        @if ($errors->has('end_date'))
                            <span class="help-block">
                                <strong>{{ $errors->first('end_date') }}</strong>
                            </span>
                        @endif
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary" formtarget="_blank" type="submit" value="create_renter_directory" name="action"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Create Renter Directory</button>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary" formtarget="_blank" type="submit" value="create_heat_and_ancillary_cost_billing" name="action"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Create Heat & Ancillary Cost Billing</button>
                    </div>

                    <div class="form-group">
                        <button class="btn btn-primary" formtarget="_blank" type="submit" value="create_closing_statement" name="action"><i class="fa fa-file-pdf-o" aria-hidden="true"></i> Create Closing Statement (31.12)</button>
                    </div>
                </form>
            </div>
        </div>
    </section>

    <!--JavaScript-->
    <script>
        loadDatepickerOnInputClick();
    </script>
@endsection