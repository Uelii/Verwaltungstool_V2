<!--Layout to add a new renter-->

@extends('layouts.master')

@section('title')
    CREATE-Renter
@endsection

@section('content')
    <section class="row">
        <div class="col-md-12">
            <h2>Add a new renter</h2>
            <hr>

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Add renter</div>
                    <div class="panel-body">
                        <form class="form-horizontal" role="form" method="POST" action="{{ route('renter.store') }}">
                            {{ csrf_field() }}

                            <div class="form-group{{ $errors->has('object_id') ? 'has-error' : '' }}">
                                <label for="object_id" class="col-md-4 control-label">Object (optional)</label>

                                <div class="col-md-6">
                                    <select id="object_id" class="form-control" name="object_id" autofocus>
                                        <option id= "NULL_option"></option>
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

                            <div class="form-group{{ $errors->has('title') ? 'has-error' : '' }}">
                                <label for="title" class="col-md-4 control-label">Title</label>

                                <div class="col-md-6">
                                    <select id="title" class="form-control" name="title" required>
                                        <option value="Mr.">Mr.</option>
                                        <option value="Ms.">Ms.</option>
                                    </select>

                                    @if ($errors->has('title'))
                                        <span class="help-block">
                                                <strong>{{ $errors->first('title') }}</strong>
                                            </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('first_name') ? 'has-error' : '' }}">
                                <label for="first_name" class="col-md-4 control-label">First name</label>

                                <div class="col-md-6">
                                    <input id="first_name" type="text" class="form-control" name="first_name" value="{{ old('first_name') }}" required autofocus>

                                    @if ($errors->has('first_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('first_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('last_name') ? 'has-error' : '' }}">
                                <label for="last_name" class="col-md-4 control-label">Last name</label>

                                <div class="col-md-6">
                                    <input id="last_name" type="text" class="form-control" name="last_name" value="{{ old('last_name') }}" required>

                                    @if ($errors->has('last_name'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('last_name') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('email') ? 'has-error' : '' }}">
                                <label for="email" class="col-md-4 control-label">E-Mail</label>

                                <div class="col-md-6">
                                    <input id="email" type="text" class="form-control" name="email" value="{{ old('email') }}" required>

                                    @if ($errors->has('email'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('email') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('phone_landline') ? 'has-error' : '' }}">
                                <label for="phone_landline" class="col-md-4 control-label">Phone landline (optional)</label>

                                <div class="col-md-6">
                                    <input id="phone_landline" type="text" class="form-control" name="phone_landline" value="{{ old('phone_landline') }}" placeholder="0xx xxx xx xx">

                                    @if ($errors->has('phone_landline'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('phone_landline') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('phone_mobile_phone') ? 'has-error' : '' }}">
                                <label for="phone_mobile_phone" class="col-md-4 control-label">Phone mobile (optional)</label>

                                <div class="col-md-6">
                                    <input id="phone_mobile_phone" type="text" class="form-control" name="phone_mobile_phone" value="{{ old('phone_mobile_phone') }}" placeholder="0xx xxx xx xx">

                                    @if ($errors->has('phone_mobile_phone'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('phone_mobile_phone') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('is_main_domicile') ? 'has-error' : '' }}">
                                <label for="is_main_domicile" class="col-md-4 control-label">Main domicile?</label>


                                <div class="col-md-6">
                                    <label id="is_main_domicile_yes" class="radio-inline"><input checked type="radio" name="is_main_domicile" value="1">Yes (default)</label>
                                    <label id="is_main_domicile_no" class="radio-inline"><input type="radio" name="is_main_domicile" value="0">No</label>

                                    @if ($errors->has('is_main_domicile'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('is_main_domicile') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('street') ? 'has-error' : '' }}">
                                <label for="street" class="col-md-4 control-label">Street</label>

                                <div class="col-md-6">
                                    <input id="street" type="text" class="form-control" name="street" value="{{ old('street') }}" required>

                                    @if ($errors->has('street'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('street') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('street_number') ? 'has-error' : '' }}">
                                <label for="street_number" class="col-md-4 control-label">Street number</label>

                                <div class="col-md-6">
                                    <input id="street_number" type="number" class="form-control" name="street_number" value="{{ old('street_number') }}" required>

                                    @if ($errors->has('street_number'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('street_number') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('zip_code') ? 'has-error' : '' }}">
                                <label for="zip_code" class="col-md-4 control-label">Zip code</label>

                                <div class="col-md-6">
                                    <input id="zip_code" type="number" class="form-control" name="zip_code" value="{{ old('zip_code') }}" required>

                                    @if ($errors->has('zip_code'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('zip_code') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('city') ? 'has-error' : '' }}">
                                <label for="city" class="col-md-4 control-label">City</label>

                                <div class="col-md-6" id="city_wrap">
                                    <input id="city" type="text" class="form-control" name="city" value="{{ old('city') }}" required>

                                    @if ($errors->has('city'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('city') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('beginning_of_contract') ? 'has-error' : '' }}">
                                <label for="beginning_of_contract" class="col-md-4 control-label">Beginning of contract</label>

                                <div class="col-md-6">
                                    <input id="beginning_of_contract" type="text" class="form-control" name="beginning_of_contract" value="{{ old('beginning_of_contract') }}" required>

                                    @if ($errors->has('beginning_of_contract'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('beginning_of_contract') }}</strong>
                                    </span>
                                    @endif
                                </div>
                            </div>

                            <div class="form-group{{ $errors->has('end_of_contract') ? 'has-error' : '' }}">
                                <label for="end_of_contract" class="col-md-4 control-label">End of contract (optional)</label>

                                <div class="col-md-6">
                                    <input id="end_of_contract" type="text" class="form-control" name="end_of_contract" value="{{ old('end_of_contract') }}">

                                    @if ($errors->has('end_of_contract'))
                                        <span class="help-block">
                                        <strong>{{ $errors->first('end_of_contract') }}</strong>
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
                        <a href="{{ url('/renter') }}" class="btn btn-info"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to overview</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!--load scripts from custom.js-->
    <script>
        loadBuildingDataOnDocumentLoad();
        loadBuildingDataOnDropdownSelectionChange();
        removeBuildingDataOnMainDomicileNo();
        loadBuildingDataOnMainDomicileYes();
        getCityFromZipCode();
        loadDatepickerOnInputClick();
    </script>
@endsection