<!--Layout to show all objects-->

@extends('layouts.master')

@section('title')
    INDEX-Objects
@endsection

@section('content')
    <section class="row data">
        <div class="col-md-12">
            <h1>Overview Objects</h1>
            <hr>

            <div class="table-responsive">
                <table id="objects_data" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Size</th>
                        <th>Room</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <!--Display data-->
                    <tbody>
                    @foreach($objects as $object)
                        <tr>
                            <td>{{$object->id}}</td>
                            <td>{{$object->name}}</td>
                            <td>{{$object->street}}</td>
                            <td>{{$object->street_number}}</td>
                            <td>{{$object->zip_code}}</td>
                            <td>{{$object->city}}</td>
                            <td>
                                <a href="{{ route('objects.show', $object->id) }}" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i> Show</a>
                                <a href="{{ route('objects.edit', $object->id) }}" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>
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
                                                </br>
                                                <b>{{$object->street}} {{$object->street_number}},
                                                    {{$object->zip_code}} {{$object->city}}</b>
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
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!--jQuery option to sort table data-->
                <script>
                    $(document).ready(function(){
                        $("#objects_data").DataTable( {
                            responsive: true,
                            ajax:           '/api/data',
                            scrollY:        200,
                            deferRender:    true,
                            scroller:       true
                        });
                    });
                </script>

                <a href="{{ url('/objects/create')}}" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add new object</a>
                <a href="{{ url('/generate_pdf')}}" target="_blank" class="btn btn-primary"> <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Generate PDF</a>
            </div>
        </div>
    </section>
@endsection