@extends('layouts.body')

@section('page-plugin-styles')
<link href="{{ asset('amg//css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
	<link href="{{ asset('amg/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('amg/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('amg/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('amg/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('amg/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('abc/ticket.min.css') }}" rel="stylesheet" type="text/css" />
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
				<a href="{{ url('transaction/list') }}">Daftar Transaksi</a>
			</li>
		</ul>
	</div>
	@include('layouts.notifications')
    <br>
    @if (isset($data['error']))
    <div class="portlet light bordered hidden-print">
        <div class="portlet-title">
            <div class="caption font-dark">
                <i class="fa fa-money"></i>
                <span class="caption-subject bold uppercase"> {{ $title }} </span>
            </div>
            <div class="tools"> </div>
        </div>
        <div class="portlet-body">
            <div class="portlet-body">
                @foreach ($data['error'] as $error)
                    <font color="red">{{ $error }}</font><br>
                @endforeach
            </div>
        </div>
    </div>
    @else
    <div id="print_btn" align="right">
        <a class="btn btn-lg blue hidden-print margin-bottom-5" onclick="javascript:window.print();"> Print
            <i class="fa fa-print"></i>
        </a>
    </div>
    <br>
    @foreach ($data['tickets'] as $key => $ticket)
        @if ($key != 0)
        <div class="page-break"></div>
        @endif
        <div class="ticket bordered">
            <div class="row ticket-logo">
                <div class="col-xs-6 ticket-logo">
                    <p class="left">
                        Wisata Balkondes
                    </p>
                </div>
                <div class="col-xs-6 ticket-logo">
                    <p class="right">
                        Tiket
                    </p>
                </div>
            </div>
            <div class="row ticket-detail">
                <div class="col-xs-12">
                    <span class="bold">Kode Tiket : #{{ $ticket['barcode'] }}</span>
                </div>
                <div class="col-xs-6 text-center">
                    <div class="something-semantic">
                        <div class="something-else-semantic">
                            <img src="/abt/barcode/{{ $ticket['barcode'] }}.png" width="300px;" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-1 text-center">
                    <div class="something-semantic">
                        <div class="something-else-semantic">
                            <img src="/abi/line_6.png" />
                        </div>
                    </div>
                </div>
                <div class="col-xs-5 text-center">
                    <div class="something-semantic">
                        <div class="something-else-semantic">
                            <img src="/abt/qrcode/{{ $ticket['barcode'] }}.png" width="200px;" />
                        </div>
                    </div>
                </div>
            </div>
            <div class="row ticket-tourist">
                <div class="col-xs-12">
                    <font class="bold uppercase" style="color: #D3A64E !important;">Penumpang</font>
                </div>
                <div class="col-xs-3">
                    <p>
                        Nama<br><br>
                        {{ $ticket['tourist_name'] }}
                    </p>
                </div>
                <div class="col-xs-1">
                    <img src="/abi/line_7.png" height="115px" />
                </div>
                <div class="col-xs-3">
                    <p>
                        Nomor Telepon<br><br>
                        {{ $ticket['tourist_mobilephone'] }}
                    </p>
                </div>
                <div class="col-xs-1">
                    <img src="/abi/line_7.png" height="115px" />
                </div>
                <div class="col-xs-3">
                    <p>
                        Email<br><br>
                        {{ $ticket['tourist_email'] }}
                    </p>
                </div>  
            </div>
            <div class="row ticket-driver">
                <div class="col-xs-12">
                    <font class="bold uppercase" style="color: #D3A64E !important;">Driver</font>
                </div>
                <div class="col-xs-12 table-responsive table-head">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th class="invoice-title text-center">
                                    <span class="bold uppercase">
                                        Trip
                                    </span>
                                    <br>
                                    (Balkondes)
                                </th>
                                <th class="invoice-title text-center">
                                    <span class="bold uppercase">
                                        Driver
                                    </span>
                                </th>
                                <th class="invoice-title text-center">
                                    <span class="bold uppercase">
                                        Vehicle
                                    </span>
                                </th>
                                <th class="invoice-title text-center">
                                    <span class="bold uppercase">
                                        Jam
                                    </span>
                                </th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr>
                                <td class="sbold">
                                    
                                </td>
                                <td></td>
                                <td></td>
                                <td class="text-center sbold"></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    @endforeach
    @endif
@endsection
