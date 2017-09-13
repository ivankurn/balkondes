@extends('body')
@section('page-plugin-styles')
	<link href="{{asset('assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/global/plugins/select2/css/select2.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/global/plugins/select2/css/select2-bootstrap.min.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('page-plugin-js')
	<script src="{{asset('assets/global/scripts/datatable.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/select2/js/select2.full.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/jquery.input-ip-address-control-1.0.min.js')}}" type="text/javascript"></script>
@endsection

@section('page-scripts')
	<script src="{{asset('assets/pages/scripts/table-datatables-operator.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/pages/scripts/components-select2.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/web/scripts/remove-table.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/pages/scripts/form-input-mask.js')}}" type="text/javascript"></script>
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
			<span>Tambah</span>
		</li>
	</ul>
</div>

<h1 class="page-title">{{session('data')['title']}}</h1>

@include('notifications')

<div class="portlet box green-turquoise ">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-user"></i>Form {{Session::get('data')['title']}}
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse"> </a>
		</div>
	</div>
	<div class="portlet-body form">
		
		<?php
			$category = explode(',',$details['id_kategori']);
		?>
		<form class="form-horizontal" action="" method="POST">
		{{csrf_field()}}
			<div class="form-body">
				@if($details['id_parent'] == '5')
					<div class="form-group">
							<label class="col-md-3 control-label" for="multi-prepend">Kategori Barang <span class="required" aria-required="true"> * </span></label>
							<div class="col-md-9 input-group select2-bootstrap-prepend" style="width:72%;padding-left: 14px;">
								<span class="input-group-btn">
									<button class="btn btn-default" type="button" data-select2-open="single-prepend-text">
										<span class="glyphicon glyphicon-search"></span>
									</button>
								</span>
								<select id="single-prepend-text" class="form-control select2" name="nonkain">
									<option></option>
									@foreach($nonkain as $parent)
										@if(in_array($parent['id_kategori'], $category))
											<option value="{{$parent['id_kategori']}}" selected>{{$parent['nama_kategori']}}</option>
										@else
											<option value="{{$parent['id_kategori']}}">{{$parent['nama_kategori']}}</option>
										@endif
									@endforeach
								</select>
							</div>
						</div>
						<div class="form-group">
							<label class="col-md-3 control-label">Nama Barang <span class="required" aria-required="true"> * </span></label>
							<div class="col-md-9">
								<div class="input-icon right">
									<input class="form-control" type="text" name="nama_barang" value="{{ $details['nama_barang'] }}">
								</div>
							</div>
						</div>
				@else
				<div class="form-group">
					<label class="col-md-3 control-label" for="multi-prepend">Kategori Kain <span class="required" aria-required="true"> * </span></label>
					<div class="col-md-9 input-group select2-bootstrap-prepend" style="width:72%;padding-left: 14px;">
						<span class="input-group-btn">
							<button class="btn btn-default" type="button" data-select2-open="multi-append">
								<span class="glyphicon glyphicon-search"></span>
							</button>
						</span>
						<select id="multi-append" class="form-control select2" multiple name="kain[]">
							<option></option>
							@foreach($kain as $parent)
								@if($parent['id_parent'] == '0')
									<optgroup label="{{$parent['nama_kategori']}}">
										@foreach($kain as $child)
											@if($child['id_parent'] == $parent['id_kategori'])
												@if(in_array($child['id_kategori'], $category))
													<option value="{{$child['id_kategori']}}" selected>&nbsp;&nbsp;&nbsp;&nbsp;{{$child['nama_kategori']}}</option>
												@else
													<option value="{{$child['id_kategori']}}">&nbsp;&nbsp;&nbsp;&nbsp;{{$child['nama_kategori']}}</option>
												@endif
											@else
												<?php continue; ?>
											@endif
										@endforeach
									</optgroup>
								@endif
							@endforeach
						</select>
					</div>
				</div>
				@endif
				@if($status_edit == 'visible')
				<div class="form-group">
					<label class="col-md-3 control-label">Status Barang</label>
					<div class="col-md-9">
						<div class="input-group">
							<select id="multi-append" class="form-control" name="status_barang">
								<option value="Aktif" @if($details['status_barang'] == 'Aktif') selected @endif>Aktif</option>
								<option value="Tidak Aktif" @if($details['status_barang'] == 'Tidak Aktif') selected @endif>Tidak Aktif</option>
							</select>
						</div>
					</div>
				</div>
				@endif
				@if(App\Lib\MyHelper::hasAccess('68'))
				<div class="form-group">
					<label class="col-md-3 control-label">Harga Jual Eceran</label>
					<div class="col-md-9">
						<div class="input-group">
							<span class="input-group-addon" id="sizing-addon1">Rp.</span>
							<input class="form-control" type="text" name="harga_eceran" value="{{ $details['harga_eceran'] }}">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Harga Jual Grosir</label> 
					<div class="col-md-9">
						<div class="input-group">
							<span class="input-group-addon" id="sizing-addon1">Rp.</span>
							<input class="form-control" type="text" name="harga_grosir" value="{{ $details['harga_grosir'] }}">
						</div>
					</div>
				</div>
				@endif
			</div>
			<div class="form-actions">
				<div class="col-md-5"></div>
				<div class="col-md-4">
					<button id="submit_button" type="submit" class="btn btn md green"><i class="fa fa-edit"></i> Ubah</button>
				</div>
			</div>
		</form>
		
	</div>
</div>

@endsection