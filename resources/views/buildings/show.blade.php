<!--Layout to show one specific building-->

@extends('layouts.master')

@section('title')
    SHOW-Buildings
@endsection

@section('content')
    <section class="row data">
        <div class="col-md-12">
            <h1>Building "{{$building->name}}"</h1>
            <hr>

            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">Building</div>
                    <div class="panel-body">
                        {{$building->street}} {{$building->street_number}}, {{$building->zip_code}} {{$building->city}}
                        <p>Maybe add a building description?</p>
                    </div>
                    <div class="panel-footer">
                        <a href="{{ url('/buildings') }}" class="btn btn-info">Back to overview</a>
                        <a href="#modalDelete_{{ $building->id }}" class="btn btn-danger" data-toggle="modal">Delete</a>


                        <!-- Modal -->
                        <div class="modal fade" id="modalDelete_{{ $building->id }}" tabIndex="-1">
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
                                        Dou you really want to delete this building?
                                        </br>
                                        </br>
                                        <b>{{$building->street}} {{$building->street_number}},
                                            {{$building->zip_code}} {{$building->city}}</b>
                                    </div>
                                    <div class="modal-footer">

                                        <form class="form-horizontal" role="form" method="POST"
                                            action="{{ url('/buildings', $building->id)}}">

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