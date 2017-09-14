@extends('body-driver')

@section('page-plugin-styles')
  <link href="{{asset('assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('assets/global/plugins/bootstrap-datetimepicker/css/bootstrap-datetimepicker.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('assets/global/plugins/bootstrap-timepicker/css/bootstrap-timepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/plugins/bootstrap-datepicker/css/bootstrap-datepicker3.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
  <link href="{{asset('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
@endsection

@section('page-plugin-js')
  <script src="{{asset('assets/global/plugins/bootstrap-timepicker/js/bootstrap-timepicker.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('assets/global/plugins/bootstrap-datetimepicker/js/bootstrap-datetimepicker.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('assets/global/plugins/bootstrap-datepicker/js/bootstrap-datepicker.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('assets/global/plugins/bootstrap-fileinput/bootstrap-fileinput.js')}}" type="text/javascript"></script>
  <script src="{{asset('assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
  <script src="{{asset('assets/global/plugins/bootstrap-confirmation/bootstrap-confirmation.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('assets/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
@endsection

@section('page-scripts')
  <script type="text/javascript">var something = "Users";</script>
  <script src="{{asset('assets/pages/scripts/components-select2.js')}}" type="text/javascript"></script>
  <script type="text/javascript" src="{{asset('assets/pages/scripts/delete.js')}}"></script>
  <script type="text/javascript" src="{{asset('assets/global/scripts/app.min.js')}}"></script>
  <script src="{{asset('assets/pages/scripts/ui-confirmations.min.js')}}" type="text/javascript"></script>
  <script src="{{asset('assets/pages/scripts/components-date-time-pickers.min.js')}}" type="text/javascript"></script>
	<script type="text/javascript">
  		$(document).ready(function() {
			$.fn.modal.Constructor.prototype.enforceFocus = function() {};
  			$('.sample_1').dataTable({
		        language: {
		            aria: {
		                sortAscending: ": activate to sort column ascending",
		                sortDescending: ": activate to sort column descending"
		            },
		            emptyTable: "No data available in table",
		            info: "Showing _START_ to _END_ of _TOTAL_ entries",
		            infoEmpty: "No entries found",
		            infoFiltered: "(filtered1 from _MAX_ total entries)",
		            lengthMenu: "_MENU_ entries",
		            search: "Search:",
		            zeroRecords: "No matching records found"
		        },
		        buttons: [{
		            extend: "print",
		            className: "btn green btn-outline",
		            exportOptions: {
		                 columns: "thead th:not(.noExport)"
		            },
		        }, {
		          extend: "copy",
		          className: "btn green btn-outline",
		          exportOptions: {
		               columns: "thead th:not(.noExport)"
		          },
		        }],
		        columnDefs: [{
		            className: "control",
		            orderable: !1,
		            targets: 0
		        }],
		        order: [0, "asc"],
		        lengthMenu: [
		            [5, 10, 15, 20, 50, 100, -1],
		            [5, 10, 15, 20, 50, 100, "All"]
		        ],
		        pageLength: 20,
		        "bPaginate" : true,
		        "bInfo" : true,
		        dom: "<'row' <'col-md-12'B>><'row'<'col-md-6 col-sm-12'l><'col-md-6 col-sm-12'f>r><'table-scrollable't><'row'<'col-md-5 col-sm-12'i><'col-md-7 col-sm-12'p>>"
  			});
  			
  		});
		$('#goFilter').click(function() {
			document.getElementById("customerfilter").submit(); 
		});
  	</script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="url('home')">Home</a>
			<i class="fa fa-circle"></i>
		</li>
		<li>
			<a href="url('home')">Tugas Pengantaran</a>
		</li>
	</ul>
</div>
<h2> Selamat Datang {{$driver['name']}} </h2>
<p>Berikut ini adalah tugas pengantaran yang sudah selesai:</p>
<br>
<div class="portlet light bordered" style="margin-top:13px">
	<div class="portlet-title tabbable-line">
		<div class="caption caption-md">
			<i class="icon-globe theme-font hide"></i>
			<span class="caption-subject font-green bold uppercase">Pengantaran Yang Sudah Selesai</span>
		</div>
	</div>
	<div class="portlet-body" >
		@if(isset($schedule) && !empty($schedule))
			<table  class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
				<thead>
					<tr>
						<th class="all">No</th>
						<th class="all">Penjemputan</th>
						<th class="all">Tujuan</th>
						<th>Jarak</th>
						<th>Nominal</th>
						<th>Rombongan</th>
					</tr>
				</thead>
				<tbody>
					@foreach($schedule as $key=>$row)
					<tr>
						<td> {{ $key+1 }}</td>
						<td> {{$row['balkondes_from_name']}}</td>
						<td> {{$row['balkondes_to_name']}}</td>
						<td> {{$row['distances']}} KM</td>
						<td> Rp {{number_format($row['price_km'] * $row['distances'], 2, '.', ',')}}</td>
						<td> <b>{{$row['receipt_number']}}</b><br>{{$row['tourist_count']}} orang: <br>
							<ul>
							@foreach($row['tourist'] as $turis)
								<li>{{$turis['name']}}</li>
							@endforeach
							</ul>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		@else
			<p>
				Maaf, Belum ada jadwal pengantaran yang sudah selesai
			</p>
		@endif
	</div>
</div>
@endsection
