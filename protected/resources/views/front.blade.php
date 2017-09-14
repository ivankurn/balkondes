@extends('body-front')
@section('page-plugin-styles')
	<link href="{{ URL::to('assets/global/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ URL::to('assets/global/plugins/mapplic/mapplic/mapplic.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/global/plugins/select2/css/select2.min.css') }}" rel="stylesheet" type="text/css" />
	<link href="{{ asset('assets/global/plugins/select2/css/select2-bootstrap.min.css') }}" rel="stylesheet" type="text/css" />
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
	<script src="{{ asset('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>

	<script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-scripts')
	<script src="{{ asset('assets/pages/scripts/dashboard.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/pages/scripts/form-repeater.min.js') }}" type="text/javascript"></script>
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
								<form id="form_tourist" action="#" class="mt-repeater form-horizontal">
									<h3 class="mt-repeater-title">Tourist</h3>
									<div data-repeater-list="group-a">
										<div data-repeater-item class="mt-repeater-item">
											<div class="row">
												<div class="col-md-4 validate-group">
													<div class="mt-repeater-input">
														<input type="text" name="name[]" class="form-control" value="" placeholder="Name" required minlength="3" maxlength="45" /> 
													</div>
												</div>
												<div class="col-md-4 validate-group">
													<div class="mt-repeater-input">
														<input type="email" name="email[]" class="form-control" value="" placeholder="Email" maxlength="100" /> 
													</div>
												</div>
												<div class="col-md-3 validate-group">
													<div class="mt-repeater-input">
														<input type="text" pattern="[0-9]{10,18}" name="phone[]" class="form-control" value="" placeholder="Mobilephone" maxlength="18" /> 
													</div>
												</div>
												<div class="col-md-1">
													<div class="mt-repeater-input">
														<a href="javascript:;" data-repeater-delete class="btn btn-danger">
															<i class="fa fa-close"></i>
														</a>
													</div>
												</div>
											</div>
										</div>
									</div>
									<a href="javascript:;" data-repeater-create class="btn btn-success mt-repeater-add">
										<i class="fa fa-plus"></i> Tambah</a>
								</form>
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
    