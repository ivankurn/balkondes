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
	<script src="{{ asset('assets/global/plugins/jquery.sparkline.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/jquery-repeater/jquery.repeater.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/select2/js/select2.full.min.js') }}" type="text/javascript"></script>
@endsection

@section('page-scripts')
	<script src="{{ asset('assets/pages/scripts/dashboard.min.js') }}" type="text/javascript"></script>
	<script src="{{ URL::asset('assets/pages/scripts/components-select2.min.js') }}" type="text/javascript"></script>
	<script>

        $('.select2').select2();
		$('.mt-repeater').repeater({
			show: function () {
            	$(this).slideDown();
            	$('.select2-container').remove();
        	    $('.select2').select2();
            },
            hide: function (deleteElement) {
                if(confirm('Are you sure you want to delete this route?')) {
                    $(this).slideUp(deleteElement);
                }
            },
            isFirstItemUndeletable: true,
		});
		</script>
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
				<div class="portlet-body">
                    <div class="row">
                        <div class="col-md-8">
                            <h3>Data Turis</h3>
                            <div class="table-responsive">   
                                <table class="table table-hover table-condensed">
                                    <thead>
                                        <tr>
                                            <th>Nama</th>
                                            <th>Email</th>
                                            <th>No. HP </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($tourist_array as $tourist)
                                        <tr>
                                            <td>{{ $tourist['name'] }}</td>
                                            <td>{{ $tourist['email'] }}</td>
                                            <td>{{ $tourist['phone'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-10">
                            <h3>Rute yang dipilih</h3>
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <tbody>
                                        <tr>
                                            <th>Rute</td>
                                            <td><strong>{{ $routes['route'] }}</strong></td>
                                        </tr>
                                        <tr>
                                            <th>Total KM</td>
                                            <td>{{ $routes['total_km'] }} km</td>
                                        </tr>
                                        <tr>
                                            <th>Price</td>
                                            <td>Rp{{ number_format($routes['price'], 2, ',', '.') }}</td>
                                        </tr>
                                        <tr>
                                            <th>Details</td>
                                            <td>
                                                <div class="table-responsive">
                                                    <table class="table">
                                                        <thead>
                                                            <tr>
                                                                <th>Rute</th>
                                                                <th>Kendaraan</th>
                                                                <th>Jarak</th>
                                                                <th>Harga</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($routes['details'] as $route)
                                                            <tr>
                                                                <td>{{ $route['route'] }}</td>
                                                                <td>{{ $route['by'] }}</td>
                                                                <td>{{ $route['distance'] }} km</td>
                                                                <td>Rp{{ number_format($route['price'], 2, ',', '.') }}</td>
                                                            </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <form action="/order" method="post">
                                <input type="hidden" name="tourist_data" value="{{ $tourist_serialize }}">
                                <input type="hidden" name="route_data" value="{{ $routes_serialize }}">
                                <div class="form-actions">
                                    <div class="pull-right">
                                        <button type="submit" class="btn green"> Pesan <i class="fa fa-check"></i></button> 
                                        {{ csrf_field() }}
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
    