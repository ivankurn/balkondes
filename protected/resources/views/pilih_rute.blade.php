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
                        <div class="col-md-6">
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
                                            <td>{{ $tourist['phone'] }}</td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <h3>Pilihan Rute</h3>
                        <form action="/pesan" class="form-horizontal mt-repeater" method="post">
                            <input type="hidden" name="tourist_data" value="{{ $tourist_serialize }}">
                            <div class="form-body">
                                <div class="form-group">
                                    <label class="control-label col-md-3">Dari*</label>
                                    <div class="col-md-3">
                                        <select class="form-control select2 select2-allow-clear"  style="width: 100%" name="start" data-placeholder="Berangkat dari mana?" required>
                                            <option value=""></option>
                                            @foreach($balkondes as $balkon)
                                            <option value="{{ $balkon->id_balkondes }}">{{ $balkon->name }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> 
                                <div class="mt-repeater">
                                    <div data-repeater-list="group-route">
                                        <div data-repeater-item class="mt-repeater-item">
                                            <div class="form-group">
                                                <label class="control-label col-md-3">Ke*</label>
                                                <div class="col-md-3">
                                                <select class="form-control select2 select2-allow-clear"  style="width: 100%" name="to" data-placeholder="Tujuannya?" required>
                                                    <option value=""></option>
                                                    @foreach($balkondes as $balkon)
                                                    <option value="{{ $balkon->id_balkondes }}">{{ $balkon->name }}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                                <label class="control-label col-md-1">Naik*</label>
                                                <div class="col-md-3">
                                                <select class="form-control select2 select2-allow-clear"  style="width: 100%" name="by" data-placeholder="Naik apa?" required>
                                                    <option value=""></option>
                                                    @foreach($vehicles as $vehicle)
                                                    <option value="{{ $vehicle->id_vehicle_type }}">{{ $vehicle->vehicle_type }}</option>
                                                    @endforeach
                                                </select>
                                                </div>
                                                <div class="col-md-2">
                                                    <button data-repeater-delete class="btn btn-danger" data-select2-open="single-append-text" type="button">
                                                        <i class="fa fa-close"></i>
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <div class="col-md-offset-3 col-md-3">
                                        <button data-repeater-create class="btn green-jungle" type="button"><i class="fa fa-plus"></i> Tambah Rute</button>
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="control-label col-md-3">Kendaraan Pulang</label>
                                    <div class="col-md-3">
                                        <select class="form-control select2 select2-allow-clear"  style="width: 100%" name="last_ride" data-placeholder="Pulangnya naik apa?" required>
                                            <option value=""></option>
                                            @foreach($vehicles as $vehicle)
                                            <option value="{{ $vehicle->id_vehicle_type }}">{{ $vehicle->vehicle_type }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div> 
                            </div>
                            <div class="form-actions">
                                <div class="pull-right">
                                    <button type="submit" class="btn green"> Konfirmasi <i class="fa fa-check"></i></button> 
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
@endsection
    