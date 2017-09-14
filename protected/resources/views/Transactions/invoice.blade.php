@extends('layouts.body')

@section('page-plugin-styles')
<link href="{{ asset('amg//css/components.min.css') }}" rel="stylesheet" id="style_components" type="text/css" />
	<link href="{{ asset('amg/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('amg/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('amg/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('amg/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('amg/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('abc/invoice.min.css') }}" rel="stylesheet" type="text/css" />
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
    <div class="invoice bordered">
        <div class="row invoice-logo">
            <div class="col-xs-6 invoice-logo-space">
                <img src="{{ asset('abi/logo-web-login.png') }}" class="img-responsive" alt="" style="width: 75%;" /> </div>
            <div class="col-xs-6">
                <p id="invoice_id" class="invoice-title-space">
                    #{{ $data['invoice']['id_transaction'] }}
                    <br><br>
                    {{ date_format(new DateTime($data['invoice']['created_at']), 'jS \o\f F, Y') }}
                    <br>
                    {{ date_format(new DateTime($data['invoice']['created_at']), 'g:i:s a') }}

                </p>
            </div>
        </div>
        <hr/>
        <div class="row invoice-subtitle-space">
            <div class="col-xs-4">
                <h3>Client:</h3>
                <ul class="list-unstyled">
                    <li> John Doe </li>
                    <li> Mr Nilson Otto </li>
                    <li> FoodMaster Ltd </li>
                    <li> Madrid </li>
                    <li> Spain </li>
                    <li> 1982 OOP </li>
                </ul>
            </div>
            <div class="col-xs-4">
                <h3>About:</h3>
                <ul class="list-unstyled">
                    <li> Drem psum dolor sit amet </li>
                    <li> Laoreet dolore magna </li>
                    <li> Consectetuer adipiscing elit </li>
                    <li> Magna aliquam tincidunt erat volutpat </li>
                    <li> Olor sit amet adipiscing eli </li>
                    <li> Laoreet dolore magna </li>
                </ul>
            </div>
            <div class="col-xs-4 invoice-payment">
                <h3>Payment Details:</h3>
                <ul class="list-unstyled">
                    <li>
                        <strong>No Transaksi #:</strong>{{ $data['invoice']['id_transaction'] }}
                    </li>
                    <li>
                        <strong>Account Name:</strong> FoodMaster Ltd 
                    </li>
                    <li>
                        <strong>SWIFT code:</strong> 45454DEMO545DEMO 
                    </li>
                    <li>
                        <strong>Account Name:</strong> FoodMaster Ltd 
                    </li>
                    <li>
                        <strong>SWIFT code:</strong> 45454DEMO545DEMO 
                    </li>
                </ul>
            </div>
        </div>
        <div class="row invoice-detail">
            <div class="col-xs-12">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th> Wisata Balkondes </th>
                            <th> Harga </th>
                            <th> Jumlah </th>
                            <th> Total Harga </th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td id="package_name"> {{ $data['invoice']['name'] }} </td>
                            <td id="price"> {{ MyHelper::moneyFormat($data['invoice']['price']) }} </td>
                            <td id="tourist_count"> {{ $data['invoice']['tourist_count'] }} orang </td>
                            <td id="grand_total"> {{ MyHelper::moneyFormat($data['invoice']['grand_total']) }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
        <div class="row">
            <div class="col-xs-6">
                <div class="well">
                    <strong>Kantor :</strong>
                    <br><br>
                    <address>
                        <strong>Kantor Pusat</strong>
                        <br>
                        Jalan Raya Jogya – Solo Km 16 Prambanan Sleman,<br>
                        Yogyakarta 55571, Indonesia<br>
                        Phone: +62 274 496 402 / +62 274 496 406<br>
                        Fax: +62 274 496 404<br>
                        Email: <a href="mailto:info@borobudurpark.co.id"> info@borobudurpark.co.id </a><br>
                    </address>
                    <address>
                        <strong>Kantor Perwakilan</strong>
                        <br>
                        Gedung Sarinah, Jl. M.H. Thamrin No. 11 Lt. 12<br>
                        Jakarta 10350, Indonesia<br>
                        Phone : +62 21 39832154<br>
                        Email : <a href="mailto:jakarta@borobudurpark.co.id"> jakarta@borobudurpark.co.id </a><br>
                    </address>
                </div>
            </div>
            <div class="col-xs-6 invoice-block">
                <ul class="list-unstyled amounts">
                    <li>
                        <strong>Total Pembayaran :</strong>
                        {{ MyHelper::moneyFormat($data['invoice']['grand_total']) }}
                    </li>
                </ul>
            </div>
        </div>
    </div>
    @endif
@endsection
