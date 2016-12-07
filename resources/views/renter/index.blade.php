<!--Layout to show all renter-->

@extends('layouts.master')

@section('title')
    INDEX-Renter
@endsection

@section('content')
    <section class="row data">
        <div class="col-md-12">
            <h2>Overview Renter</h2>
            <hr>

            <div class="test">
                <table id="renter_data" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Last name</th>
                        <th>First name</th>
                        <th>Contact data</th>
                        <th>Street</th>
                        <th>No.</th>
                        <th>Zip code</th>
                        <th>City</th>
                        <th>Beginning</th>
                        <th>End</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <!--Display data-->
                    <tbody>
                    @foreach($renter as $renter)
                        <tr>
                            <td>{{ $renter->title }}</td>
                            <td>{{ $renter->last_name }}</td>
                            <td>{{ $renter->first_name }}</td>
                            <td>{{ $renter->email }} </br> {{$renter->phone_landline}} </br> {{ $renter->phone_mobile_phone }}</td>
                            <td>{{ $renter->street }}</td>
                            <td>{{ $renter->street_number }}</td>
                            <td>{{ $renter->zip_code }}</td>
                            <td>{{ $renter->city }}</td>
                            <td>{{ $renter->beginning_of_contract }}</td>
                            <td>{{ $renter->end_of_contract }}</td>
                            <td>
                                <a href="{{ route('renter.show', $renter->id) }}" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i> Show</a>
                                <a href="{{ route('renter.edit', $renter->id) }}" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>

                                <!--Check if relation exists (if so: show a warning button)-->
                                @if(count($renter->payments))
                                    <button type="button" class="btn btn-warning" data-toggle="deletion_popover"
                                            title="Deletion not possible." data-content="There are some payments attached to this renter. Therefore this renter cannot be deleted."
                                            data-trigger="focus" data-placement="left"><i class="fa fa-exclamation-triangle" aria-hidden="true"></i> Note</button>
                                    <script>
                                        addPopoverOnIndexView();
                                    </script>
                                @else
                                    <button type="button" id="btnOpenModal" class="btn btn-danger" data-id="{{ $renter->id }}" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                                @endif

                            </td>
                        </tr>

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
                                        Do you really want to delete this renter?
                                        </br>
                                        <h3>{{ $renter->title }} {{ $renter->last_name }}, {{ $renter->first_name }}</h3>
                                        <hr>
                                        <p><b>Contact data: </b></br>{{ $renter->email }}</br>{{ $renter->phone_landline }}</br>{{ $renter->phone_mobile_phone }}</p>
                                        <p><b>Beginning of contract: </b>{{ $renter->beginning_of_contract }}</p>
                                        <p><b>End of contract: </b>{{ $renter->end_of_contract }}</p>
                                        <div class="modal-footer">
                                            <form class="form-horizontal" role="form" method="POST" action="{{ url('/renter', $renter->id)}}">
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
                    @endforeach
                </table>

                <!--JavaScript-->
                <script>
                    addSortTableOptions('renter_data');
                    loadBootstrapModal();
                </script>

                <a href="{{ url('/renter/create')}}" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add new renter</a>
            </div>
        </div>
    </section>
@endsection