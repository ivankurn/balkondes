@extends('body')

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
			<a href="url('home')">Pesanan Selesai</a>
		</li>
	</ul>
</div>

<div class="portlet light bordered" style="margin-top:13px">
	<div class="portlet-title tabbable-line">
		<div class="caption caption-md">
			<i class="icon-globe theme-font hide"></i>
			<span class="caption-subject font-green bold uppercase">Pesanan Selesai</span>
		</div>
	</div>
	<div class="portlet-body" >
		@if(isset($data) && !empty($data))
			<table  class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
				<thead>
					<tr>
						<th class="all">No</th>
						<th class="all">Kode</th>
						<th class="all">Turis</th>
						<th>Rute</th>
						<th >Grand Total</th>
						<th >Status</th>
					</tr>
				</thead>
				<tbody>
					@foreach($data as $key=>$row)
					<tr>
						<td> {{ $key+1 }}</td>
						<td> <b>{{$row['receipt_number']}}</b>
						<br><br>
							<a class="btn green btn-sm btn-block" data-toggle="modal" href="#assign_{{$row['id_transaction']}}"><i class="fa fa-edit"></i> Jadwalkan Driver </a>
							<a class="btn red btn-sm btn-block" type="button" href="{{URL::to('pesanan/hapus')}}/{{$row['id_transaction']}}" data-toggle="confirmation" data-placement="top" class="tooltips" data-original-title="Delete"><i class="fa fa-trash"></i> Hapus Pesanan</a>
						</td>
						<td> {{$row['tourist_count']}} orang: <br>
							<ul>
							@foreach($row['tourist'] as $turis)
								<li>{{$turis['name']}}</li>
							@endforeach
							</ul>
						</td>
						<td>
							<?php $total_jarak = 0;?>
							@foreach($row['schedule'] as $jadwal)
								{{$jadwal['balkondes_from_name']}}&nbsp;-&nbsp;{{$jadwal['balkondes_to_name']}}&nbsp;({{$jadwal['distances']}}&nbsp;KM)<br>&nbsp;&nbsp;&nbsp;{{$jadwal['vehicle_type']}} @if(!empty($jadwal['name'])) Driver: {{$jadwal['name']}} @endif<br>
								<?php $total_jarak = $total_jarak + $jadwal['distances']?><br>
							@endforeach
							<br>
							Total: {{$total_jarak}} KM
						</td>
						<td> Rp {{number_format($row['grand_total'], 2, '.', ',')}}</td>
						<td> {{$row['status']}}</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		@else
			<p>
				Maaf, Belum ada pesanan baru
			</p>
		@endif
	</div>
</div>
@foreach($data as $key=>$row)
<div class="modal fade bs-modal-g" tabindex="-1" id="assign_{{$row['id_transaction']}}" role="dialog" aria-hidden="true">
	<div class="modal-dialog modal-lg">
		<div class="modal-content">
			<form action="" method="post">
			<input type="hidden" name="id_transaction" value="{{$row['id_transaction']}}">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-hidden="true"></button>
				<h4 id="delete-title" class="modal-title">Jadwalkan Driver</h4>
			</div>
			<div class="modal-body"> 
				<table  class="table table-striped table-bordered table-hover dt-responsive sample_1" width="100%">
					<thead>
						<tr>
							<th class="all">No</th>
							<th class="all">Driver</th>
							<th >Berangkat</th>
							<th >Tujuan</th>
							<th>Kendaraan</th>
							
						</tr>
					</thead>
					<tbody>
						@foreach($row['schedule'] as $kunci=>$jadwal)
						<tr>
							<td> {{ $kunci+1 }} </td>
							<td>
								<select id="driver" name="id_driver[]" class="form-control" id="multiple" tabindex="-1" aria-hidden="true" data-placeholder="Pilih Driver" required>
									@if($jadwal['vehicle_type'] == 'VW')
										@foreach($vw as $driver)
											@if($driver['id_driver'] == $jadwal['id_driver'])
												<option value="{{$driver['id_driver']}}" selected>{{$driver['name']}} ({{$driver['phone']}})</option>
											@else
												<option value="{{$driver['id_driver']}}">{{$driver['name']}} ({{$driver['phone']}})</option>
											@endif
										@endforeach
									@else
										@foreach($andong as $driver)
											@if($driver['id_driver'] == $jadwal['id_driver'])
												<option value="{{$driver['id_driver']}}" selected>{{$driver['name']}} ({{$driver['phone']}})</option>
											@else
												<option value="{{$driver['id_driver']}}">{{$driver['name']}} ({{$driver['phone']}})</option>
											@endif
										@endforeach
									@endif
								</select>
							</td>
							<td>{{$jadwal['balkondes_from_name']}} </td>
							<td>{{$jadwal['balkondes_to_name']}}</td>
							<td>{{$jadwal['vehicle_type']}}</td>
						</tr>
						@endforeach
					</tbody>
				</table>
			</div>
			<div class="modal-footer">
				<input type="submit" class="btn green" value="Simpan">
					<button type="button" class="btn dark btn-outline" data-dismiss="modal">Close</button>
			</div>
		</form>
      </div>
  </div>
</div>
@endforeach
@endsection
