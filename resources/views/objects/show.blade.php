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
                        <p><b>Size: </b>{{ $object->size }}-room</p>
                        <p><b>Room number: </b>{{ $object->room }}</p>
                    </div>
                    <div class="panel-footer">
                        <a href="{{ url('/objects') }}" class="btn btn-info"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to overview</a>
                        <a href="#modalDelete_{{ $object->id }}" class="btn btn-danger" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i> Delete</a>

                        <!-- Modal -->
                        <div class="modal fade" id="modalDelete_{{ $object->id }}" tabIndex="-1">
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
                                        Dou you really want to delete this object?
                                        </br>
                                        <h3>{{ $object->name }}</h3>
                                        <hr>
                                        <p><b>Description: </b>{{ $object->description }}</p>
                                        <p><b>Size: </b>{{ $object->size }}-room</p>
                                        <p><b>Room number: </b>{{ $object->room }}</p>
                                    </div>
                                    <div class="modal-footer">

                                        <form class="form-horizontal" role="form" method="POST"
                                              action="{{ url('/objects', $object->id)}}">

                                            <input type="hidden" name="_method" value="DELETE">
                                            <input type="hidden" name="_token" value="{{ csrf_token() }}" />

                                            <button class="btn btn-default" data-dismiss="modal">Cancel</button>
                                            <button type="submit" class="btn btn-danger">Yes</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection