@extends('body')
@section('page-plugin-styles')
	<link href="{{asset('assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{ URL::to('assets/global/plugins/bootstrap-sweetalert/sweetalert.css') }}" rel="stylesheet" type="text/css" />
@endsection


@section('page-plugin-js')
	<script src="{{asset('assets/global/scripts/datatable.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/jquery.input-ip-address-control-1.0.min.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/bootstrap-sweetalert/sweetalert.min.js') }}" type="text/javascript"></script> 
@endsection

@section('page-scripts')
	<script src="{{asset('assets/pages/scripts/table-datatables-pembelian.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/pages/scripts/components-select2.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/web/scripts/remove-table.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/pages/scripts/form-input-mask.js')}}" type="text/javascript"></script>
	<script src="{{ asset('assets/pages/scripts/ui-sweetalert.min.js') }}" type="text/javascript"></script>
	<script>
	function hapus(value){
		swal({
		  title: "Anda yakin menghapus roll ? Penghapusan ini tidak tercatat di stok opname.",
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
	
	function habis(value){
		swal({
		  title: "Anda yakin set roll ini menjadi 'habis' ? Roll ini tidak akan muncul pada pencarian roll di form tambah penjualan.",
		  type: "warning",
		  showCancelButton: true,
		  confirmButtonClass: "btn-danger",
		  confirmButtonText: "Ya, Roll ini habis!",
		  closeOnConfirm: false
		},
		function(){
			document.getElementById('txtvaluehabis').value = value;
			frmhabis.submit();
		});
	}
	
	function penyesuaianStok(kode_roll){
		var kg = document.getElementById('kg_roll_'+kode_roll).innerHTML;
		var total_kg = document.getElementById('total_kg').innerHTML;
		var token = "<?php echo csrf_token(); ?>";
		var id_barang_toko = "<?php echo $details['id_barang_toko']; ?>";
		var id_user = "<?php echo Session::get('id_user'); ?>";
		swal({
			title: "Berapa berat roll  '"+kode_roll+"' saat ini? ",
			text: "Berat terdaftar "+kg+" kg",   
            type: "input",
            showCancelButton: true,   
            closeOnConfirm: false,   
            animation: "slide-from-top",   
            inputPlaceholder: "Contoh: 10",
			animation: "slide-from-top"
		},
		function(inputValue){
			if (inputValue === false){
				return false;
			} 
			if (isNaN(inputValue)){
				swal.showInputError("Anda harus menginputkan angka (diatas 0) !");
				return false;
			}
			if (inputValue < 0){
				swal.showInputError("Anda harus menginputkan angka (diatas 0)!");
				return false;
			} 
			if (inputValue === "") {
				swal.showInputError("Anda harus menginputkan angka (diatas 0)!");
				return false;
			}
			
			$.ajax({
                type: "POST",
                url : "<?php echo url('penyesuaian/add')?>",
                data: "id_user="+id_user+"&id_barang_toko="+id_barang_toko+"&kode_roll="+kode_roll+"&kg_baru="+inputValue+"&_token="+token,
                success: function(data){
                  if(data == 'success'){
					  document.getElementById('kg_roll_'+kode_roll).innerHTML = parseFloat(inputValue).toFixed(2);
					  
					  var selisih = parseFloat(inputValue) - parseFloat(kg);
					  var selisih_total = parseFloat(total_kg) + selisih;
					  
					  document.getElementById('total_kg').innerHTML = parseFloat(selisih_total).toFixed(2);
					  swal('Success!','Penyesuaian Stok Berhasil',"success");
				  }else {
					  swal('Error',data,"error");
				  }
                }
            });
	
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
			<i class="fa fa-plus"></i>
			<span>Detail</span>
		</li>
	</ul>
</div>

<h1 class="page-title">{{session('data')['title']}}</h1>

@include('notifications')

<div class="portlet box green-turquoise ">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-user"></i>Detail Barang
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse"> </a>
		</div>
	</div>
	<div class="portlet-body form">
		<form class="form-horizontal">
		{{csrf_field()}}
			<div class="form-body row">
				<div class="col-md-8">
					<div class="form-group">
						<label class="col-md-3 control-label">Nama</label>
						<div class="col-md-9">
							<div class="input-group" style="margin-top: 8px;">
							: {{$details['nama_barang']}}
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Kategori</label>
						<div class="col-md-9">
							<div class="input-group" style="margin-top: 8px;">
							: <?php $x = explode(',',$details['list_kategori']);?>
							@foreach($x as $category) <span class="label label-primary"> {{$category}} </span> &nbsp; @endforeach
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Harga Eceran</label>
						<div class="col-md-9">
							<div class="input-group" style="margin-top: 8px;">
							: @if(App\Lib\MyHelper::hasAccess('66')) {{ 'Rp. '. number_format($details['harga_eceran'], 2, '.', ',') }} @else -Tidak Ditampilkan- @endif
							</div>
						</div>
					</div>
					<div class="form-group">
						<label class="col-md-3 control-label">Harga Grosir</label>
						<div class="col-md-9">
							<div class="input-group" style="margin-top: 8px;">
							: @if(App\Lib\MyHelper::hasAccess('66')) {{ 'Rp. '. number_format($details['harga_grosir'], 2, '.', ',') }} @else -Tidak Ditampilkan- @endif
							</div>
						</div>
					</div>
				</div>
				<div class="col-md-4">
					@if($details['total_pcs'] > 0)
					<div class="form-group">
						<label class="col-md-6 control-label">Total Quantity</label>
						<div class="col-md-6">
							<div class="input-group" style="margin-top: 8px;">
							: {{$details['total_pcs']}} pcs
							</div>
						</div>
					</div>
					@endif
					
						@if($details['harga_brg_satuan'] > 0)
						<div class="form-group">
							<label class="col-md-6 control-label">Harga Beli Satuan</label>
							<div class="col-md-6">
								<div class="input-group" style="margin-top: 8px;">
								: @if(App\Lib\MyHelper::hasAccess('63')){{ 'Rp. '. number_format($details['harga_brg_satuan'], 2, '.', ',') }} @else -Tidak Ditampilkan- @endif
								</div>
							</div>
						</div>
						@endif
					
					@if($details['total_roll'] > 0)
					<div class="form-group">
						<label class="col-md-6 control-label">Total Roll</label>
						<div class="col-md-6">
							<div class="input-group" style="margin-top: 8px;">
							: {{$details['total_roll']}} Roll
							</div>
						</div>
					</div>
					@endif
					@if($details['total_kg'] > 0)
					<div class="form-group">
						<label class="col-md-6 control-label">Total Berat</label>
						<div class="col-md-6">
							<div class="input-group" style="margin-top: 8px;">
							: <div style="display:inline;" id="total_kg">{{$details['total_kg']}}</div> Kg
							</div>
						</div>
					</div>
					@endif
					<div class="form-group">
						<label class="col-md-6 control-label">Status</label>
						<div class="col-md-6">
							<div class="input-group" style="margin-top: 8px;">
							: {{ $details['status_barang'] }}
							</div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
</div>
@if(App\Lib\MyHelper::hasAccess('64'))
@if($details['id_parent'] != '5')
<div class="portlet box green-turquoise ">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-user"></i>Tambah Roll Tanpa Pembelian
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse"> </a>
		</div>
	</div>
	<div class="portlet-body">
		<form class="form-horizontal" action="{{URL::to('barang/roll/add')}}/{{$details['id_barang_toko']}}" method="POST">
			{{csrf_field()}}
			<div class="form-body" >
				<div class="form-group">
					<label class="col-md-3 control-label">Harga Per Kg</label>
					<div class="col-md-4">
						<div class="input-group">
							<span class="input-group-addon" id="sizing-addon1">Rp.</span>
							<input class="form-control" type="text" name="harga_kg" value="{{ old('harga_kg') }}">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Berat Roll</label>
					<div class="col-md-2">
						<div class="input-group">
							<input class="form-control" type="text" name="kg_beli" value="{{ old('kg_beli') }}"><span class="input-group-addon" id="sizing-addon1">Kg</span>
						</div>
					</div>
				</div>
			</div>
			<div class="form-actions" style="margin-bottom:50px">
				<div class="col-md-3"></div>
				<div class="col-md-2">
					<button id="submit_button" type="submit" class="btn btn md green"><i class="fa fa-plus"></i> Tambah</button>
				</div>
			</div>
		</form>
	</div>
</div>
@else 
<div class="portlet box green-turquoise ">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-user"></i>Ubah Stok Barang Tanpa Pembelian
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse"> </a>
		</div>
	</div>
	<div class="portlet-body">
		<form class="form-horizontal" action="{{URL::to('barang/nonroll/add')}}/{{$details['id_barang_toko']}}" method="POST">
			{{csrf_field()}}
			<div class="form-body" >
				<div class="form-group">
					<label class="col-md-3 control-label">Harga Beli Barang</label>
					<div class="col-md-4">
						<div class="input-group">
							<span class="input-group-addon" id="sizing-addon1">Rp.</span>
							<input class="form-control" type="text" name="harga_brg_satuan" value="@if(App\Lib\MyHelper::hasAccess('63')) @if($details['harga_brg_satuan'] > 0) {{$details['harga_brg_satuan']}} @endif @else -tidak ditampilkan- @endif">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Quantity</label>
					<div class="col-md-2">
						<div class="input-group">
							<input class="form-control" type="text" name="total_pcs" value="@if($details['total_pcs'] > 0){{$details['total_pcs']}}@endif"> <span class="input-group-addon" id="sizing-addon1">Pcs</span>
						</div>
					</div>
				</div>
			</div>
			<div class="form-actions" style="margin-bottom:50px">
				<div class="col-md-3"></div>
				<div class="col-md-2">
					<button id="submit_button" type="submit" class="btn btn md green"><i class="fa fa-edit"></i> Ubah Stok</button>
				</div>
			</div>
		</form>
	</div>
</div>
@endif
@endif
@if(isset($details['roll']))
<div class="portlet box green-turquoise ">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-user"></i>Detail Roll
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse"> </a>
		</div>
	</div>
	<div class="portlet-body"><br><br><br>
	<h2>Roll Ready Stock</h2>
		<table  class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_3">
		<?php setlocale(LC_MONETARY, 'id_ID');?>
			<thead>
				<tr>
					<th>No</th>
					<th>Kode&nbsp;Roll</th>
					<th>Berat</th>
					<th>Berat&nbsp;Awal</th>
					<th>Hrg&nbsp;per&nbsp;Kg</th>
					<th>Hrg&nbsp;per&nbsp;Roll</th>
					<th class="noExport">Tindakan</th>
					<th>Status</th>
					
				</tr>
			</thead>
			<tbody>
			<?php $no=1;?>
				@foreach($details['roll'] as $row)
				@if($row['status'] != 'Habis')
				<tr @if($row['status'] == 'Sudah Dibuka') style="color:blue;" @endif @if($row['status'] == 'Habis') style="color:red;" @endif>
					<td>{{$no}}</td>
					<td id="kode_roll_{{$row['kode_roll']}}">{{$row['kode_roll']}}</td>
					<td><div style="display:inline;" id="kg_roll_{{$row['kode_roll']}}">{{$row['kg']}}</div> Kg</td>
					<td>{{$row['kg_beli']}} Kg</td>
					<td>@if(App\Lib\MyHelper::hasAccess('63')) {{ 'Rp. '. number_format($row['harga_beli_per_kg'], 2, '.', ',') }} @else -Tidak DItampilkan- @endif</td>
					<td>@if(App\Lib\MyHelper::hasAccess('63')) {{ 'Rp. '. number_format($row['harga_beli_per_kg'] * $row['kg_beli'], 2, '.', ',') }} @else -Tidak DItampilkan- @endif</td>
					<td class="noExport">
						<div class="btn-group">
							<button class="btn green btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">Pilihan <i class="fa fa-angle-down"></i></button>
							<ul class="dropdown-menu pull-right">
								@if(App\Lib\MyHelper::hasAccess('20'))
								<li>
									<a href="javascript:;" onClick="penyesuaianStok('{{$row['kode_roll']}}')" ><i class="fa fa-balance-scale"></i> Ubah Stok </a>
								</li>
								@endif
								@if(App\Lib\MyHelper::hasAccess('20'))
								<li>
									<a class="mt-sweetalert"  onClick="habis('{{$row['kode_roll']}}')"><i class="fa fa-battery-empty"></i> Set Habis </a>
								</li>
								@endif
								@if(App\Lib\MyHelper::hasAccess('20'))
								<li>
									<a class="mt-sweetalert" onClick="hapus('{{$row['kode_roll']}}')"><i class="fa fa-close"></i> Hapus Roll</a>
								</li>
								@endif
						  </ul>
					  </div>
					</td>
					<td>{{$row['status']}}</td>
				</tr>
				<?php $no++;?>
				@endif
				@endforeach
			
			</tbody>
		</table>
	</div>
	<div class="portlet-body"><br>
		<h2>Roll Habis</h2>
		<table  class="table table-striped table-bordered table-hover dt-responsive" width="100%" id="sample_4">
		<?php setlocale(LC_MONETARY, 'id_ID');?>
			<thead>
				<tr>
					<th>No</th>
					<th>Kode&nbsp;Roll</th>
					<th>Berat</th>
					<th>Berat&nbsp;Awal</th>
					<th>Hrg&nbsp;per&nbsp;Kg</th>
					<th>Hrg&nbsp;per&nbsp;Roll</th>
					<th class="noExport">Tindakan</th>
					<th>Status</th>
					
				</tr>
			</thead>
			<tbody>
			<?php $no=1;?>
				@foreach($details['roll'] as $row)
				@if($row['status'] == 'Habis')
				<tr @if($row['status'] == 'Sudah Dibuka') style="color:blue;" @endif @if($row['status'] == 'Habis') style="color:red;" @endif>
					<td>{{$no}}</td>
					<td id="kode_roll_{{$row['kode_roll']}}">{{$row['kode_roll']}}</td>
					<td><div style="display:inline;" id="kg_roll_{{$row['kode_roll']}}">{{$row['kg']}}</div> Kg</td>
					<td>{{$row['kg_beli']}} Kg</td>
					<td>@if(App\Lib\MyHelper::hasAccess('63')) {{ 'Rp. '. number_format($row['harga_beli_per_kg'], 2, '.', ',') }} @else -Tidak DItampilkan- @endif</td>
					<td>@if(App\Lib\MyHelper::hasAccess('63')) {{ 'Rp. '. number_format($row['harga_beli_per_kg'] * $row['kg_beli'], 2, '.', ',') }} @else -Tidak DItampilkan- @endif</td>
					<td class="noExport">
						<div class="btn-group">
							<button class="btn green btn-xs btn-outline dropdown-toggle" data-toggle="dropdown">Pilihan <i class="fa fa-angle-down"></i></button>
							<ul class="dropdown-menu pull-right">
								@if(App\Lib\MyHelper::hasAccess('20'))
								<li>
									<a href="javascript:;" onClick="penyesuaianStok('{{$row['kode_roll']}}')" ><i class="fa fa-balance-scale"></i> Ubah Stok </a>
								</li>
								@endif
								@if(App\Lib\MyHelper::hasAccess('20'))
								<li>
									<a class="mt-sweetalert"  onClick="habis('{{$row['kode_roll']}}')"><i class="fa fa-battery-empty"></i> Set Habis </a>
								</li>
								@endif
								@if(App\Lib\MyHelper::hasAccess('20'))
								<li>
									<a class="mt-sweetalert" onClick="hapus('{{$row['kode_roll']}}')"><i class="fa fa-close"></i> Hapus Roll</a>
								</li>
								@endif
						  </ul>
					  </div>
					</td>
					<td>{{$row['status']}}</td>
				</tr>
				<?php $no++;?>
				@endif
				@endforeach
			
			</tbody>
		</table>
	</div>
</div>
@endif
<form id="frmdelete" method="post" action="{{URL::to('barang/delete/roll')}}">
	{{csrf_field()}}
	<input type="hidden" name="kode_roll" id="txtvalue">
</form>
<form id="frmhabis" method="post" action="{{URL::to('penyesuaian/habis')}}">
	{{csrf_field()}}
	<input type="hidden" name="kode_roll" id="txtvaluehabis">
</form>
@endsection
