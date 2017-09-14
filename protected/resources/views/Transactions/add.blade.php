@extends('layouts.body')

@section('page-plugin-styles')
    <link href="{{ asset('amg/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('amg/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('amg/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('amg/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('abc/invoice.min.css') }}" rel="stylesheet" type="text/css" />
    <link href="{{ asset('abc/ticket.min.css') }}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin-js')
    <script src="{{ asset('amg/plugins/moment.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('amg/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('amg/plugins/bootstrap-daterangepicker/daterangepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('amg/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
    <script src="{{ asset('amg/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('amg/plugins/jquery-validation/js/jquery.validate.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('amg/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('ajp/jquery.priceformat.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-scripts')
	<script src="{{ asset('amp/scripts/components-select2.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('amp/scripts/form-repeater.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('amp/scripts/components-date-time-pickers.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('abj/csrf_token.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('abj/alert-popup.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('abj/transaction_add.min.js') }}" type="text/javascript"></script>
@endsection

@section('content')
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="{{ url('home') }}">Home</a>
				<i class="fa fa-circle"></i>
			</li>
			<li>
				<a href="{{ url('transaction/add') }}">Transaksi</a>
			</li>
		</ul>
	</div>
	@include('layouts.notifications')
    <br>
    <div id="form" class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <i class="fa fa-money"></i>
                <span class="caption-subject font-green bold uppercase"> {{ $title }} </span>
            </div>
        </div>
        @if (empty($data['balkondes_list']))
            <div class="portlet-body">
                <font color="red">
                    Sistem tidak menemukan paket wisata Balkondes. <br><br>
                    Silakan menghubungi Admin Pusat untuk menambahkan paket wisata Balkondes ke dalam sistem.
                </font>
            </div>
        @else
            <div class="portlet-body form">
                <div class="form-body">
                    <div class="form-group">
                        <form id="form_package_select" action="#" class="mt-repeater form-horizontal">
                            <h3 class="mt-repeater-title">Paket Balkondes</h3>
                            <div class="form-group col-md-6">
                                <select id="package_select" class="form-control">
                                    <option value="">Silakan dipilih</option>
                                    <option value="general">Paket Regular</option>
                                    <option value="custom">Paket Khusus</option>
                                </select>
                            </div>
                        </form>
                        <form id="form_package_type_select" action="#" class="mt-repeater form-horizontal">
                            <div class="form-group col-md-6">
                                <select id="package_type_select" class="form-control">
                                    @if (!empty($data['balkondes_list']))
                                        <option value="">Silakan dipilih</option>
                                        @foreach ($data['balkondes_list'] as $balkondes)
                                            <option value="{{ $balkondes['id_package'] }}" price="{{ $balkondes['price'] }}">{{ $balkondes['name'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </form>
                    </div>
                    <br>
                    <div class="form-group">
                        <form id="form_tourist" action="#" class="mt-repeater form-horizontal">
                            <h3 class="mt-repeater-title">Tourist</h3>
                            <div data-repeater-list="group-a">
                                <div data-repeater-item class="mt-repeater-item">
                                    <div class="row">
                                        <div class="col-md-4 validate-group">
                                            <div class="mt-repeater-input">
                                                <input type="text" name="name-input" class="form-control" value="" placeholder="Name" required minlength="3" maxlength="45" /> 
                                            </div>
                                        </div>
                                        <div class="col-md-4 validate-group">
                                            <div class="mt-repeater-input">
                                                <input type="email" name="email-input" class="form-control" value="" placeholder="Email" maxlength="100" /> 
                                            </div>
                                        </div>
                                        <div class="col-md-3 validate-group">
                                            <div class="mt-repeater-input">
                                                <input type="text" pattern="[0-9]{10,18}" name="mobilephone-input" class="form-control" value="" placeholder="Mobilephone" maxlength="18" /> 
                                            </div>
                                        </div>
                                        <div class="col-md-1">
                                            <div class="mt-repeater-input">
                                                <a href="javascript:updateSummary('subtract');" data-repeater-delete class="btn btn-danger">
                                                    <i class="fa fa-close"></i>
                                                </a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <a href="javascript:updateSummary('add');" data-repeater-create class="btn btn-success mt-repeater-add">
                                <i class="fa fa-plus"></i> Tambah</a>
                        </form>
                    </div>
                </div>
            </div>
        @endif
    </div>
    <div id="summary" class="portlet light bordered">
        <div class="portlet-title">
            <div class="caption">
                <span class="caption-subject font-green bold uppercase"> Kesimpulan </span>
            </div>
        </div>
        <div class="portlet-body">
            <table id="user" class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <td style="width:45%"> Harga Tiket per orang </td>
                        <td style="width:5%" align="center"> : </td>
                        <td id="price_summary" style="width:50%"> </td>
                    </tr>
                    <tr>
                        <td> Jumlah orang </td>
                        <td align="center"> : </td>
                        <td id="total_person_summary"> 1 orang </td>
                    </tr>
                    <tr>
                        <td> Total Harga Tiket </td>
                        <td align="center"> : </td>
                        <td id="total_price_summary"> </td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="form-actions">
        <div class="row">
            <div class="col-md-offset-5 col-md-9">
                <button id="submit_btn" type="submit" class="btn green">Submit</button>
                <button id="cancel_btn" type="button" class="btn grey-salsa btn-outline">Cancel</button>
            </div>
        </div>
    </div>
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
                        <strong>No Transaksi #:</strong><font id="transaction_no"></font>
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
                            <td id="package_name"> </td>
                            <td id="price"> </td>
                            <td id="tourist_count"> </td>
                            <td id="grand_total"> </td>
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
                        <font id="grand_total_2"></font>
                    </li>
                </ul>
            </div>
        </div>
    </div>
@endsection
