@extends('body')
@section('page-plugin-styles')
	<link href="{{asset('assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ URL::to('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('page-plugin-js')
	<script src="{{asset('assets/global/scripts/datatable.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script> 
	<script src="{{asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
@endsection

@section('page-scripts')
	<script src="{{asset('assets/pages/scripts/table-datatables-barang.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script> 
	<script>
	function hapus(value){
		swal({
		  title: "Anda yakin menghapus data barang ? ",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Ya, Hapus saja!",
		  closeOnConfirm: false
		},
		function(){
			document.getElementById('txtvalue').value = value;
			frmdelete.submit();
		});
	}
	</script>
@endsection

@section('content')
<div class="page-bar">
	<ul class="page-breadcrumb">
		<li>
			<a href="url('home')">Home</a>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<i class="fa fa-user"></i>
			<span>{{session('data')['menu_active']}}</span>
			<i class="fa fa-angle-right"></i>
		</li>
		<li>
			<i class="fa fa-list"></i>
			<span>List</span>
		</li>
	</ul>
</div>

<h1 class="page-title">{{session('data')['title']}}</h1>

@include('notifications')

<div class="portlet box green-turquoise ">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-user"></i>{{Session::get('data')['title']}} Ready Stock
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse"> </a>
		</div>
	</div>
	<div class="portlet-body"><br><br><br>
		<table  class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_2">
		<?php setlocale(LC_MONETARY, 'id_ID');?>
			<thead>
				<tr>
					<th>No</th>
					<th>Jenis</th>
					<th>Kategori</th>
					<th>Nama&nbsp;Barang</th>
					<th>Harga</th>
					<th>Quantity</th>
					<th class="noExport">Tindakan</th>
					<th>Status</th>
					<th></th>
					<th>Tgl Terdaftar</th>
				</tr>
			</thead>
			<tbody>
			<?php $no=1;?>
			@if($ready_stock != "")
				@foreach($ready_stock as $row)
				<tr @if($row['status_barang'] == 'Aktif')
					@if($row['id_parent'] == '5')
						style="background-color:#d7f8ff;"
					@else
						style="background-color:#f2f9b1;"
					@endif
					@else
						style="background-color:red;"
					@endif
					>
					<td>{{$no}}</td>
					<td>
					@if($row['id_parent'] == '5')
						Non Kain
					@else
						Kain
					@endif
					</td>
					<td>
					@if($row['id_parent'] == '5')
						{{$row['list_kategori']}}
					@else
						<?php echo str_replace(',','<br>',$row['list_kategori']);?>
					@endif
					</td>
					<td>{{$row['nama_barang']}}</td>
					<td>
						@if(App\Lib\MyHelper::hasAccess('66'))
						<ul>
							<li>Eceran:&nbsp; {{ 'Rp.&nbsp;'. number_format($row['harga_eceran'], 2, '.', ',') }}</li>
							<li>Grosir:&nbsp; {{ 'Rp.&nbsp;'. number_format($row['harga_grosir'], 2, '.', ',') }}</li>
						</ul>
						 @else -Tidak ditampilkan- @endif
					</td>
					<td>
					@if($row['id_parent'] == '5')
						{{$row['total_pcs']}} pcs
					@else
						{{$row['total_roll']}}&nbsp;roll<br>
						{{$row['total_kg']}}&nbsp;kg
					@endif
					</td>
					<td class="noExport">
						<div class="btn-group">
							<button class="btn green btn-xs dropdown-toggle" data-toggle="dropdown">Tindakan <i class="fa fa-angle-down"></i></button>
							<ul class="dropdown-menu pull-right">
								@if(App\Lib\MyHelper::hasAccess('18'))
								<li>
									<a  href="{{url('barang/detail/'.$row['id_barang_toko'])}}"><i class="fa fa-search"></i> Details </a>
								</li>
								@endif
								@if(App\Lib\MyHelper::hasAccess('20'))
								<li>
									<a  href="{{url('barang/edit/'.$row['id_barang_toko'])}}"><i class="fa fa-edit"></i> Edit </a>
								</li>
								@endif
								@if(App\Lib\MyHelper::hasAccess('21'))
								<li>
									<a class="mt-sweetalert" onClick="hapus('{{$row['id_barang_toko']}}')"><i class="fa fa-close"></i> Hapus</a>
								</li>
								@endif
						  </ul>
					  </div>
					
					</td>
					<td>{{ $row['status_barang'] }}</td>
					<td>@if(isset($row['roll']))
						<ul>
						@foreach($row['roll'] as $roll)
							<li><b>{{$roll['kode_roll']}}</b> ({{$roll['kg']}} kg)</li>
						@endforeach
						</ul>
					@endif</td>
					<td>{{ date('F d, Y H:i', strtotime($row['created_at'])) }}</td>
				</tr>
				<?php $no++;?>
				@endforeach
			@endif
			</tbody>
		</table>
	</div>
</div>

<div class="portlet box red ">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-user"></i>{{Session::get('data')['title']}} Stok Habis
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse"> </a>
		</div>
	</div>
	<div class="portlet-body"><br><br><br>
		<table  class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_1">
		<?php setlocale(LC_MONETARY, 'id_ID');?>
			<thead>
				<tr>
					<th>No</th>
					<th>Jenis</th>
					<th>Kategori</th>
					<th>Nama&nbsp;Barang</th>
					<th>Harga&nbsp;Eceran</th>
					<th>Harga&nbsp;Grosir</th>
					<th class="noExport">Tindakan</th>
					<th>Total&nbsp;(Roll / Pcs)</th>
					<th>Status</th>
					<th>Tgl Terdaftar</th>
				</tr>
			</thead>
			<tbody>
			<?php $no=1;?>
			@if($no_stock != "")
				@foreach($no_stock as $row)
				<tr @if($row['status_barang'] == 'Aktif')
					@if($row['id_parent'] == '5')
						style="background-color:#d7f8ff;"
					@else
						style="background-color:#f2f9b1;"
					@endif
					@else
						style="background-color:#f891b5;"
					@endif
					>
					<td>{{$no}}</td>
					<td>
					@if($row['id_parent'] == '5')
						Non Kain
					@else
						Kain
					@endif
					</td>
					<td>
					@if($row['id_parent'] == '15')
						{{$row['list_kategori']}}
					@else
						<?php echo str_replace(',','<br>',$row['list_kategori']);?>
					@endif
					</td>
					<td>{{$row['nama_barang']}}</td>
					<td>@if(App\Lib\MyHelper::hasAccess('66')) {{ 'Rp. '. number_format($row['harga_eceran'], 2, '.', ',') }} @else -Tidak Ditampilkan- @endif</td>
					<td>@if(App\Lib\MyHelper::hasAccess('66')) {{ 'Rp. '. number_format($row['harga_grosir'], 2, '.', ',') }} @else -Tidak Ditampilkan- @endif</td>
					<td class="noExport">
						<div class="btn-group">
							<button class="btn green btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">Pilihan <i class="fa fa-angle-down"></i></button>
							<ul class="dropdown-menu pull-right">
								@if(App\Lib\MyHelper::hasAccess('18'))
								<li>
									<a  href="{{url('barang/detail/'.$row['id_barang_toko'])}}"><i class="fa fa-search"></i> Details </a>
								</li>
								@endif
								@if(App\Lib\MyHelper::hasAccess('20'))
								<li>
									<a  href="{{url('barang/edit/'.$row['id_barang_toko'])}}"><i class="fa fa-edit"></i> Edit </a>
								</li>
								@endif
								@if(App\Lib\MyHelper::hasAccess('21'))
								<li>
									<a class="mt-sweetalert" onClick="hapus('{{$row['id_barang_toko']}}')"><i class="fa fa-close"></i> Hapus</a>
								</li>
								@endif
						  </ul>
					  </div>
					</td>
					<td>
					@if($row['id_parent'] == '5')
						{{$row['total_pcs']}} pcs
					@else
						{{$row['total_roll']}} roll
						<br>
						{{$row['total_kg']}} kg
					@endif
					</td>
					<td>{{ $row['status_barang'] }}</td>
					<td>{{ date('F d, Y H:i', strtotime($row['created_at'])) }}</td>
				</tr>
				<?php $no++;?>
				@endforeach
			@endif
			</tbody>
		</table>
	</div>
</div>
<form id="frmdelete" method="post" action="{{URL::to('barang/delete')}}">
	{{csrf_field()}}
	<input type="hidden" name="id_barang_toko" id="txtvalue">
</form>
@endsection
