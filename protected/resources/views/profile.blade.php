@extends('body')
@section('page-plugin-styles')
	<link href="{{asset('assets/global/plugins/datatables/datatables.min.css')}}" rel="stylesheet" type="text/css" />
	<link href="{{asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('page-plugin-js')
	<script src="{{asset('assets/global/scripts/datatable.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/datatables/datatables.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/jquery-inputmask/jquery.inputmask.bundle.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/jquery.input-ip-address-control-1.0.min.js')}}" type="text/javascript"></script>
@endsection

@section('page-scripts')
	<script src="{{asset('assets/pages/scripts/table-datatables-operator.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/web/scripts/remove-table.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/pages/scripts/form-input-mask.js')}}" type="text/javascript"></script>
@endsection
@section('content')
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="url('home')">Home</a>
				<i class="fa fa-circle"></i>
			</li>
			<li>
				<a href="#">Update Profile</a>
			</li>
		</ul>
	</div>
	
	@include('notifications')
	
<div class="portlet box green-turquoise">
	<div class="portlet-title">
		<div class="caption">
			<i class="fa fa-user"></i>Form {{Session::get('data')['title']}}
		</div>
		<div class="tools">
			<a href="javascript:;" class="collapse"> </a>
		</div>
	</div>
	<div class="portlet-body form">
		<form class="form-horizontal" action="{{ url('profile')}}" method="POST">
        {{csrf_field()}}
			<div class="form-body">
				<div class="form-group">
					<label class="col-md-3 control-label">Ubah Password </label>
					<div class="col-md-9">
						<div class="input-icon right">
							<input class="form-control" type="password" name="password_edit">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Nama Operator <span class="required" aria-required="true"> * </span></label>
					<div class="col-md-9">
						<div class="input-icon right">
							<input class="form-control" type="text" name="nama_user" value="{{$details['nama_user']}}">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">No Telp Handphone </label>
					<div class="col-md-9">
						<div class="input-icon right">
							<input class="form-control" type="text" name="notelp_hp" value="{{$details['notelp_hp']}}" >
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">No Telp Rumah </label>
					<div class="col-md-9">
						<div class="input-icon right">
							<input class="form-control" type="text" name="notelp_rumah" value="{{$details['notelp_rumah']}}" >
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Alamat </label>
					<div class="col-md-9">
						<div class="input-icon right">
							<textarea class="form-control" name="alamat">{{$details['alamat']}}</textarea>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Kota </label>
					<div class="col-md-9">
						<div class="input-icon right">
							<input class="form-control" type="text" name="kota" value="{{$details['kota']}}">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">Identitas</label>
					<div class="col-md-9">
						<div class="input-icon right">
							<select class="form-control" name="jenis_identitas">
								<option value="none">-</option>
								<option value="KTP" @if($details['jenis_identitas'] == 'KTP') selected @endif>KTP</option>
								<option value="SIM" @if($details['jenis_identitas'] == 'SIM') selected @endif>SIM</option>
								<option value="Passport" @if($details['jenis_identitas'] == 'Passport') selected @endif>Passport</option>
							<select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label class="col-md-3 control-label">No Identitas </label>
					<div class="col-md-9">
						<div class="input-icon right">
							<input class="form-control" type="text" name="no_identitas" value="{{$details['no_identitas']}}">
						</div>
					</div>
				</div>
			<div class="form-actions">
				<div class="col-md-5"></div>
				<div class="col-md-4">
					<button id="submit_button" type="submit" class="btn btn md green"><i class="fa fa-edit"></i> Ubah</button>
				</div>
			</div>
        </div>
		</form>
	</div>
</div>

@endsection
