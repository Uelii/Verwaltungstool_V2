<!--Layout to show one specific object-->

@extends('layouts.master')

@section('title')
    SHOW-Object
@endsection

@section('content')
    <section class="row">
        <div class="col-md-12">
            <h2>Object details</h2>
            <hr>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Object</div>
                    <div class="panel-body">
                        <h3>{{ $object->name }}</h3>
                        <hr>
                        <p><b>Description: </b>{{ $object->description }}</p>
                        <p><b>Living space [sqm]: </b>{{ $object->living_space }}</p>
                        <p><b>Number of rooms: </b>{{ $object->number_of_rooms }}</p>
                        <p><b>Floor number / Room number: </b>{{ $object->floor_room_number }}</p>
                        <p><b>Rent [Fr.], per annum: </b>{{ $object->rent }}</p>
                    </div>
                    <div class="panel-footer">
                        <a href="{{ url('/objects') }}" class="btn btn-info"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to overview</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="row renter">
        <div class="col-md-12 renter">
            <h4>Renter correspondending to this object</h4>
            <hr>
            <div class="table-responsive">
                <table id="renter_data" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>First name</th>
                        <th>Last name</th>
                        <th>Contact data</th>
                        <th>Beginning</th>
                        <th>End</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($object->renter as $renter)
                        <tr>
                            <td>{{ $renter->title }}</td>
                            <td>{{ $renter->first_name }}</td>
                            <td>{{ $renter->last_name }}</td>
                            <td>{{ $renter->email }} </br> {{$renter->phone_landline}} </br> {{ $renter->phone_mobile_phone }} </br>
                                @if($renter->is_main_domicile == 1)
                                    <i class="fa fa-check" aria-hidden="true"></i> Main domicile
                                @else
                                    <i class="fa fa-times" aria-hidden="true"></i> Main domicile
                                @endif
                            </td>
                            <td>{{ $renter->beginning_of_contract }}</td>
                            <td>{{ $renter->end_of_contract }}</td>
                            <td>
                                <a href="{{ route('renter.show', $renter->id) }}" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i> Show</a>
                                <a href="{{ route('renter.edit', $renter->id) }}" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
                                <a href="#modalDelete_{{ $renter->id }}" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>

                                <!-- Modal -->
                                <div class="modal fade" id="modalDelete_{{ $renter->id }}" tabIndex="-1">
                                    <div class="modal-dialog">

                                        <!-- Modal content-->
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <button type="button" class="close" data-dismiss="modal">
                                                    ×
                                                </button>
                                                <h4 class="modal-title">Please confirm</h4>
                                            </div>
                                            <div class="modal-body">
                                                Do you want to delete the relation or the renter itself?
                                                </br>
                                                <h3>{{ $renter->title }} {{ $renter->first_name }}, {{ $renter->last_name }}</h3>
                                            </div>
                                            <div class="modal-footer">


                                                <form id="delete_form" class="form-horizontal" role="form" method="POST"
                                                      action="#">



                                                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                    <button id="btnDeleteRenterAndRelation" type="button" data-id="{{ $renter->id }}" class="btn btn-danger">Delete RENTER</button>
                                                    <button id="btnDeleteRelation"  type="button" data-id="{{ $renter->id }}" class="btn btn-danger">Delete RELATION</button>

                                                </form>



                                                <!--
                                                <form class="form-horizontal" role="form" method="POST"
                                                      action="url('/renter', $renter->id)}}">

                                                    <input type="hidden" name="_method" value="DELETE">
                                                    <input type="hidden" name="_token" value="csrf_token() }}" />

                                                    <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                                                    <button type="button" class="btn btn-danger" onclick="submitFormDeleteRenter()">Delete RENTER</button>

                                                    <button type="submit" class="btn btn-danger">Delete RELATION</button>
                                                </form>-->


                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!--jQuery option to sort table data-->
                <script>
                    addSortTableOptions('renter_data');

                    var id = {{ json_encode($object->id) }};
                    deleteRenterAndRelationFromObjectView(id);
                    deleteRelationFromObjectView(id);
                </script>

            </div>
        </div>
    </section>
@endsection