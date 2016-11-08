<!--Layout to show all buildings-->

@extends('layouts.master')

@section('title')
    INDEX-Buildings
@endsection

@section('content')
    <section class="row data">
        <div class="col-md-12">
            <h1>Overview Buildings</h1>
            <hr>

            <table class="table table-hover table-condensed buildings_data">
                <thead>
                <tr>
                    <th class="col-md-1">ID</th>
                    <th class="col-md-2">Name</th>
                    <th class="col-md-2">Street</th>
                    <th class="col-md-1">Street number</th>
                    <th class="col-md-1">Zip code</th>
                    <th class="col-md-2">City</th>
                    <th class="col-md-3">Action</th>
                </tr>
                </thead>

                <!--Display data-->
                @foreach($buildings as $building)
                    <tr class="buildings_data">
                        <td>{{$building->id}}</td>
                        <td>{{$building->name}}</td>
                        <td>{{$building->street}}</td>
                        <td>{{$building->street_number}}</td>
                        <td>{{$building->zip_code}}</td>
                        <td>{{$building->city}}</td>
                        <td>
                            <a href="{{ route('buildings.show', $building->id) }}" class="btn btn-info">Show</a>
                            <a href="{{ route('buildings.edit', $building->id) }}" class="btn btn-primary">Edit</a>
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
                        </td>
                    </tr>
                @endforeach
            </table>
            <a href="{{ url('/buildings/create')}}" class="btn btn-primary">Add new building</a>
        </div>
        <!--Pagination-->
        <div class="col-md-12">
            {{ $buildings->links() }}
        </div>
    </section>

@endsection