@extends('body-front')
@section('page-plugin-styles')
	<link href="{{ URL::to('assets/global/plugins/morris/morris.css') }}" rel="stylesheet" type="text/css" />
    <style>
        @media print{
            .no-print {
                display: none;
            }
        }
    </style>
@endsection
@section('page-plugin-js')
	<script src="{{ asset('assets/global/plugins/morris/morris.min.js') }}" type="text/javascript"></script>
	<script src="{{ asset('assets/global/plugins/morris/raphael-min.js') }}" type="text/javascript"></script>
@endsection

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
				   <span class="caption-subject bold uppercase font-green">{{ $id }}</span>
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
                                    @foreach($tourists as $tourist)
                                        <tr>
                                            <td>{{ $tourist['name'] }}</td>
                                            <td>{{ $tourist['email'] }}</td>
                                            <td>{{ $tourist['mobilephone'] }}</td>
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
                                                                <th>Driver</th>
                                                                <th>CP Driver</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach($routes['details'] as $route)
                                                            <tr>
                                                                <td>{{ $route['route'] }}</td>
                                                                <td>{{ $route['by'] }}</td>
                                                                <td>{{ $route['distance'] }} km</td>
                                                                <td>Rp{{ number_format($route['price'], 2, ',', '.') }}</td>
                                                                <td>{{ $route['name'] }}</td>
                                                                <td>{{ $route['phone'] }}</td>
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
                    <div class="row no-print">
                        <div class="col-md-12">
                            <div class="pull-right">
                                <a href="{{ url('') }}" class="btn btn-primary">Home</a>
                            </div>
                        </div>
                    </div>
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
    