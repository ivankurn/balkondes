@extends('body-front')
@section('page-plugin-styles')
	<link href="{{ URL::to('assets/global/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ URL::to('assets/global/plugins/mapplic/mapplic/mapplic.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/global/plugins/datatables/datatables.min.css') }}" rel="stylesheet" type="text/css" />
@endsection
@section('page-plugin-js')
	<script src="{{ asset('assets/global/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/morris/raphael-min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/mapplic/js/hammer.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/mapplic/js/jquery.easing.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/mapplic/js/jquery.mousewheel.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/mapplic/mapplic/mapplic.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/counterup/jquery.waypoints.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/jquery.sparkline.min.js') }}" type="text/javascript"></script>

	<script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/scripts/datatable.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/datatables/datatables.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/datatables/plugins/bootstrap/datatables.bootstrap.js') }}" type="text/javascript"></script>
@endsection

@section('page-scripts')
	<script src="{{ asset('assets/pages/scripts/dashboard.min.js') }}" type="text/javascript"></script>
	<script src="{{ URL::asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="portlet light portlet-fit bordered">
			<div class="portlet-title">
			   <div class="caption">
				   <i class="fa fa-search"></i>
				   <span class="caption-subject bold uppercase font-green">Form Registrasi</span>
			   </div>
		   </div>
			<div class="portlet-body">
				<div class="portlet-body form">
					<form action="" class="form-horizontal" method="POST">
					<div class="form-body">
						<div class="form-group">
						   <label class="col-md-3 control-label">Nama</label>
						   <div class="input-group select2-bootstrap-prepend col-md-7">
							   <div class="form-group row">
								   <div class="col-md-6">
									   <input type="text" class="form-control" placeholder="Nama" name="nama" id="nama" required>
								   </div>
							   </div>
						   </div>
					   </div>
					   <div class="form-group">
						   <label class="col-md-3 control-label">Phone</label>
						   <div class="input-group select2-bootstrap-prepend col-md-7">
							   <div class="form-group row">
								   <div class="col-md-6">
									   <input type="text" class="form-control" placeholder="No Telpon" name="phone" id="phone" required>
								   </div>
							   </div>
						   </div>
					   </div>
				   </div>
				   <div class="form-actions">
					   <div class="row">
						   <div class="col-md-offset-3 col-md-4">
							   <button type="submit" class="btn green" id="submitCari"><i class="fa fa-search"></i> Pesan Sekarang!</button> 
							   <input type="hidden" name="_token" value="{{ csrf_token() }}">
						   </div>
					   </div>
				   </div>
				  </form>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
    