<!--Layout to show all invoices-->

@extends('layouts.master')

@section('title')
    INDEX-Invoices
@endsection

@section('content')
    <section class="row data">
        <div class="col-md-12">
            <h2>Overview Invoices</h2>
            <hr>
            <div class="table-responsive">
                <table id="invoices_data" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Object</th>
                        <th>Type</th>
                        <th>Amount [Fr.]</th>
                        <th>Invoice Date</th>
                        <th>Payable until</th>
                        <th>Invoice status</th>
                        <th>Action</th>
                    </tr>
                    </thead>

                    <!--Display data-->
                    <tbody>
                    @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->object->name }}</td>
                            <td>{{ $invoice->invoice_type }}</td>
                            <td>{{ number_Format($invoice->amount, 2, '.', '') }}</td>
                            <td>{{ $invoice->invoice_date }}</td>
                            <td>{{ $invoice->payable_until }}</td>
                            <td id="isPaid_{{ $invoice->id }}">
                                @if($invoice->is_paid == 0)
                                    <p class="is_paid_no"><i class="fa fa-times" aria-hidden="true"></i> NOT PAID</p>
                                    <label class="checkbox-inline"><input type="checkbox" class="is_paid_checkbox" data-id="[{{ $invoice->id }}, {{ $invoice->is_paid }}]"><i>Mark as paid</i></label>
                                @else
                                    <p class="is_paid_yes"><i class="fa fa-check" aria-hidden="true"></i> PAID</p>
                                @endif
                            </td>
                            <td>
                                <a href="{{ route('invoices.show', $invoice->id) }}" class="btn btn-info"><i class="fa fa-eye" aria-hidden="true"></i> Show</a>
                                <a href="{{ route('invoices.edit', $invoice->id) }}" class="btn btn-primary"><i class="fa fa-pencil" aria-hidden="true"></i> Edit</a>

                                <button type="button" id="btnOpenModal" class="btn btn-danger" data-id="{{ $invoice->id }}" data-toggle="modal"><i class="fa fa-trash" aria-hidden="true"></i> Delete</button>
                            </td>
                        </tr>

                        <!-- Modal -->
                        <div class="modal fade" id="modalDelete_{{ $invoice->id }}" tabIndex="-1">
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
                                        Do you really want to delete this invoice?

                                        <h3>{{ $invoice->invoice_type }}: {{ $invoice->amount }} Fr.</h3>
                                        <hr>
                                        <p><b>Object: </b>{{ $invoice->object->name }}: {{ $invoice->object->number_of_rooms }}-room, {{ $invoice->object->floor_room_number }}</p>
                                        <p><b>Payment status: </b>
                                        @if($invoice->is_paid == 0)
                                            <p class="is_paid_no"><i class="fa fa-times" aria-hidden="true"></i> NOT PAID</p>
                                        @else
                                            <p class="is_paid_yes"><i class="fa fa-check" aria-hidden="true"></i> PAID</p>
                                        @endif
                                            </p>
                                            <p><b>Invoice date: </b>{{ $invoice->invoice_date }}</p>
                                            <p><b>Payable until: </b>{{ $invoice->payable_until }}</p>
                                            <div class="modal-footer">
                                                <form class="form-horizontal" role="form" method="POST" action="{{ url('/invoices', $invoice->id)}}">
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
                    addSortTableOptions('invoices_data');
                    loadBootstrapModal();
                    changeIsPaidOnCheckboxClick();
                </script>

                <a href="{{ url('/invoices/create')}}" class="btn btn-primary"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add new invoice</a>
            </div>
        </div>
    </section>
@endsection