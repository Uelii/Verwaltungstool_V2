<!--Layout to show one specific renter-->

@extends('layouts.master')

@section('title')
    SHOW-Renter
@endsection

@section('content')
    <section class="row">
        <div class="col-md-12">
            <h2>Renter details</h2>
            <hr>
            <div class="col-md-8 col-md-offset-2">
                <div class="panel panel-default">
                    <div class="panel-heading">{{ $renter->title }} {{ $renter->last_name }}, {{ $renter->first_name }}</div>
                    <div class="panel-body">
                        <div class="col-md-6">
                            <h4>About</h4>
                            <hr>
                            <p><b>Beginning of contract: </b>{{ $renter->beginning_of_contract }}</p>

                            @if($renter->end_of_contract == '')
                                <p><b>End of contract: </b>n/a</p>
                            @else
                                <p><b>End of contract: </b>{{ $renter->end_of_contract }}</p>
                            @endif

                            <p><b>Adresse:</b></p>
                            <p>{{ $renter->street }} {{ $renter->street_number }}</p>
                            <p>{{ $renter->zip_code }} {{ $renter->city }}</p>

                            @if($renter->is_main_domicile == 1)
                                <p class="main_domicile_yes"><i class="fa fa-check" aria-hidden="true"></i> Main domicile</p>
                            @else
                                <p class="main_domicile_no"><i class="fa fa-times" aria-hidden="true"></i> Main domicile</p>
                            @endif
                        </div>
                        <div class="col-md-6">
                            <h4>Contact data</h4>
                            <hr>
                            <p><b>E-Mail: </b>{{ $renter->email }}</p>
                            <p><b>Phone landline: </b>
                                @if($renter->phone_landline = 'null')
                                    n/a
                                @else
                                    {{ $renter->phone_landline }}
                                @endif
                            </p>
                            <p><b>Phone mobile: </b>
                                @if($renter->phone_mobile_phone = 'null')
                                    n/a
                                @else
                                    {{ $renter->phone_mobile_phone }}
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <section class="row payments">
        <div class="col-md-12 payments">
            <h4>Payments correspondending to this renter</h4>
            <hr>

            <div class="table-responsive">
                <table id="payments_data_renter_view" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Amount total</th>
                        <th>Amount paid</th>
                        <th>Payment status</th>
                        <th>Date</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <tbody>
                    @foreach($renter->payments as $payment)
                        <tr>
                            <td id="amountTotal_{{ $payment->id }}">{{ number_Format($payment->amount_total, 2, '.', '\'') }} Fr.</td>
                            <td id="amountPaid_{{ $payment->id }}">{{ number_Format($payment->amount_paid, 2, '.', '\'') }} Fr.</td>
                            <td id="isPaid_{{ $payment->id }}">
                                @if($payment->is_paid == 0)
                                    <p class="is_paid_no"><i class="fa fa-times" aria-hidden="true"></i> NOT PAID</p>
                                    <label class="checkbox-inline"><input type="checkbox" class="is_paid_checkbox" data-id="[{{ $payment->id }}, {{ $payment->amount_total }}, {{ $payment->amount_paid }}]"><i>Mark as paid</i></label>
                                @else
                                    <p class="is_paid_yes"><i class="fa fa-check" aria-hidden="true"></i> PAID</p>
                                @endif
                            </td>
                            <td>{{ $payment->date }}</td>
                            <td>
                                <a href="{{ route('payments.show', $payment->id) }}" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i> Show</a>
                                <a href="{{ route('payments.edit', $payment->id) }}" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>

                                <button type="button" id="btnOpenModal" class="btn btn-danger" data-id="{{ $payment->id }}" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="modalDelete_{{ $payment->id }}" tabIndex="-1">
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
                                        Do you really want to delete this payment?

                                        <h3>{{ $payment->renter->last_name }}, {{ $payment->renter->first_name }}: {{ $payment->amount_total }} Fr.</h3>
                                        <hr>
                                        <p><b>Object: </b>{{ $payment->renter->object->name }}: {{ $payment->renter->object->number_of_rooms }}-room, {{ $payment->renter->object->floor_room_number }}</p>
                                        <p><b>Payment status: </b>
                                        @if($payment->is_paid == 0)
                                            <p class="is_paid_no"><i class="fa fa-times" aria-hidden="true"></i> NOT PAID</p>
                                        @else
                                            <p class="is_paid_yes"><i class="fa fa-check" aria-hidden="true"></i> PAID</p>
                                        @endif
                                            <p><b>Creation date: </b>{{ date('Y-m-d', strtotime($payment->created_at)) }}</p>
                                            <div class="modal-footer">
                                                <form class="form-horizontal" role="form" method="POST" action="{{ url('/payments', $payment->id)}}">
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
                    </tbody>
                </table>

                <!--JavaScript-->
                <script>
                    addSortTableOptions('payments_data_renter_view');
                    loadBootstrapModal();
                    changeAmountOnCheckboxClick();
                </script>

                <a href="{{ url('/renter') }}" class="btn btn-info"><i class="fa fa-chevron-left" aria-hidden="true"></i> Back to overview</a>
            </div>
        </div>
    </section>
@endsection