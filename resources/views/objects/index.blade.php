<!--Layout to show all objects-->

@extends('layouts.master')

@section('title')
    INDEX-Objects
@endsection

@section('content')
    <section class="row data">
        <div class="col-md-12">
            <h2>Overview Objects</h2>
            <hr>
            <div class="table-responsive">
                <table id="objects_data" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Corresponding building</th>
                        <th>Name</th>
                        <th>Description</th>
                        <th>Size</th>
                        <th>Room number</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <!--Display data-->
                    <tbody>
                    @foreach($objects as $object)
                        <tr>
                            <td>{{ $object->building->name }} </br><i>{{ $object->building->street }} {{ $object->building->street_number }},
                                {{ $object->building->zip_code }} {{ $object->building->city }}</i></td>
                            <td>{{ $object->name }}</td>
                            <td>{{ $object->description }}</td>
                            <td>{{ $object->size }}-room</td>
                            <td>{{ $object->room }}</td>
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
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>

                <!--jQuery option to sort table data-->
                <script>
                    $(document).ready(function(){
                        $("#objects_data").DataTable( {
                            responsive: true
                            /*"pageLength": 12*/
                        });
                    });
                </script>

                <a href="{{ url('/objects/create')}}" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add new object</a>
                <a href="{{ url('/generate_pdf')}}" target="_blank" class="btn btn-primary"> <i class="fa fa-file-pdf-o" aria-hidden="true"></i> Generate PDF</a>
            </div>
        </div>
    </section>
@endsection