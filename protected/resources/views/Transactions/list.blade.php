@extends('layouts.body')

@section('page-plugin-styles')
<link href="{{ asset('amg//css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
	<link href="{{ asset('amg/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('amg/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('amg/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('amg/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('amg/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin-js')
    <script src="{{ asset('amg/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('amg/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('amg/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('amg/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ asset('amg/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('amg/scripts/datatable.js') }}" type="text/javascript"></script>
    <script src="{{ asset('amg/plugins/datatables/datatables.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('amg/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
@endsection

@section('page-scripts')
	<script src="{{ asset('amp/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('amp/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('abj/transaction_list.min.js') }}" type="text/javascript"></script>
@endsection

@section('content')
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="{{ url('home') }}">Home</a>
				<i class="fa fa-circle"></i>
			</li>
			<li>
				<a href="{{ url('transaction/add') }}">Transaction</a>
			</li>
		</ul>
	</div>
	@include('layouts.notifications')
    <br>
    <div class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption font-dark">
                <i class="fa fa-money"></i>
                <span class="caption-subject bold uppercase"> {{ $title }} </span>
            </div>
            <div class="tools"> </div>
        </div>
        <div class="portlet-body">
            @if (empty($data['transactions_list']))
                <div class="portlet-body">
                    <font color="red">Tidak ada daftar transaksi.</font>
                </div>
            @else
                <table class="table table-striped table-checkable table-bordered table-hover dt-responsive" id="sample_1">
                    <thead>
                        <tr>
                            <th> Tanggal </th>
                            <th> Nama </th>
                            <th> Jumlah </th>
                            <th> Total </th>
                            <th> Status </th>
                            <th> Action </th>
                            <th class="none">Tourist</th>
                        </tr>
                    </thead>
                    <tbody>
                        @if (!empty($data['transactions_list']))
                            @foreach ($data['transactions_list'] as $transaction)
                                <tr>
                                    <td> {{ $transaction['created_at'] }} </td>
                                    <td> {{ $transaction['name'] }} </td>
                                    <td> {{ $transaction['tourist_count'] }} orang </td>
                                    <td> {{ MyHelper::moneyFormat($transaction['grand_total']) }} </td>
                                    <td> {{ $transaction['status'] }} </td>
                                    <td>
                                        <div class="btn-group">
                                            <button class="btn btn-xs green dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false"> Actions
                                                <i class="fa fa-angle-down"></i>
                                            </button>
                                            <ul class="dropdown-menu" role="menu">
                                                <li>
                                                    <a href="/transaction/print/invoice?no={{ $transaction['id_transaction'] }}">
                                                        <i class="fa fa-print"></i> Print Invoice 
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="/transaction/print/ticket?no={{ $transaction['id_transaction'] }}">
                                                        <i class="fa fa-print"></i> Print Ticket 
                                                    </a>
                                                </li>
                                            </ul>
                                        </div> 
                                    </td>
                                    <td>
                                        lalala
                                    </td>
                                </tr>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            @endif
        </div>
    </div>
@endsection
