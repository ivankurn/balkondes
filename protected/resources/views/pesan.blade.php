@extends('body-front')
@section('page-plugin-styles')
	<link href="{{ URL::to('assets/global/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
@section('page-plugin-js')
	<script src="{{ asset('assets/global/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/morris/raphael-min.js') }}" type="text/javascript"></script>@endsection

@section('page-scripts')
	<script src="{{ asset('assets/pages/scripts/dashboard.min.js') }}" type="text/javascript"></script>

@endsection

@section('content')
<div class="row">
	<div class="col-md-12">
		<div class="portlet light portlet-fit bordered">
			<div class="portlet-title">
			   <div class="caption">
				   <i class="fa fa-search"></i>
				   <span class="caption-subject bold uppercase font-green"></span>
			   </div>
		   </div>
			<div class="portlet-body">
                <h3>{{ $messages }}</h3>
                <center>
                    <a href="{{ url('') }}" class="btn btn-primary">Kembali ke awal!</a>
                </center>
			</div>
		</div>
	</div>
</div>
@endsection
    