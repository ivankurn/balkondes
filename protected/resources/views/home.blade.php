<?php
	use App\Lib\MyHelper;
?>
@extends('body')
@section('page-plugin-styles')
	<link href="{{asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/plugins/morris/morris.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('page-plugin-js')
	<script src="{{asset('assets/global/plugins/moment.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/morris/morris.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/morris/raphael-min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/counterup/jquery.waypoints.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/counterup/jquery.counterup.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/amcharts/amcharts/amcharts.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/amcharts/amcharts/serial.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/amcharts/amcharts/pie.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/amcharts/amcharts/radar.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/amcharts/amcharts/themes/light.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/amcharts/amcharts/themes/patterns.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/amcharts/amcharts/themes/chalk.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/fullcalendar/fullcalendar.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/flot/jquery.flot.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/flot/jquery.flot.resize.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/flot/jquery.flot.categories.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/jquery-easypiechart/jquery.easypiechart.min.js')}}" type="text/javascript"></script>
	<script src="{{asset('assets/global/plugins/jquery.sparkline.min.js')}}" type="text/javascript"></script>
@endsection

@section('page-scripts')
	<script src="{{asset('assets/pages/scripts/dashboard.min.js')}}" type="text/javascript"></script> 
	<script>
	function gantiHome(){
		var bulane = document.getElementById('bulane').value;
		var tahune = document.getElementById('tahune').value;
		var lokasine = "{{URL::to('home')}}/"+tahune+"/"+bulane;
		window.location.href = lokasine;
	}
	</script>
@endsection

@section('content')
	<div class="page-bar">
		<ul class="page-breadcrumb">
			<li>
				<a href="url('home')">Home</a>
				<i class="fa fa-circle"></i>
			</li>
		</ul>
	</div>
	
	@include('notifications')
 <div class="row">
	<?php setlocale(LC_MONETARY, 'id_ID'); ?>
	<?php date_default_timezone_set("Asia/Jakarta"); 
	$thn = $year;
	$bln = $month;

	$m_start    = date('m', strtotime($bln));
	$date_start = $thn.'-'.$m_start.'-01';
	
	$m_end      = date('m-t', strtotime($bln));
	$date_end   = $thn.'-'.$m_end;

	$thnnow = date('Y');
	$thnnowminspuluh = $thnnow - 20;
	?>
	@if(App\Lib\MyHelper::hasAccess('53'))
		<h2 style="margin-left:15px">Stok Barang</h2>
	@endif
	@if(App\Lib\MyHelper::hasAccess('53'))
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="margin-top:20px">
		<div class="dashboard-stat purple">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number">
					<span data-counter="counterup" data-value="{{$statistic['barang']['all_count']}}">0</span> </div>
				<div class="desc"> Total Jenis Barang </div>
			</div>
			<a class="more" href="{{URL::to('penjualan')}}">Total Jenis Barang
				<i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	@endif
	
	@if(App\Lib\MyHelper::hasAccess('53'))
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="margin-top:20px">
		<div class="dashboard-stat purple">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number">
					<span data-counter="counterup" data-value="{{$statistic['barang']['kain_count']}}">0</span> </div>
				<div class="desc"> Total Jenis Barang Kain </div>
			</div>
			<a class="more" href="{{URL::to('penjualan')}}">Total Jenis Barang Kain
				<i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	@endif
	
	@if(App\Lib\MyHelper::hasAccess('53'))
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12" style="margin-top:20px">
		<div class="dashboard-stat purple">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number">
					<span data-counter="counterup" data-value="{{$statistic['barang']['barang_count']}}">0</span> </div>
				<div class="desc"> Total Jenis Barang Non Kain </div>
			</div>
			<a class="more" href="{{URL::to('penjualan')}}"> Total Jenis Barang Non Kain
				<i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	@endif
	
	@if(App\Lib\MyHelper::hasAccess('53'))
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="dashboard-stat purple">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number">
					<span data-counter="counterup" data-value="{{$statistic['barang']['total_pcs']}}">0</span> Pcs </div>
				<div class="desc"> Total Quantity Barang Non Kain </div>
			</div>
			<a class="more" href="{{URL::to('penjualan')}}">Total Quantity Barang Non Kain
				<i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	@endif
	
	@if(App\Lib\MyHelper::hasAccess('53'))
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="dashboard-stat purple">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number">
					<span data-counter="counterup" data-value="{{$statistic['barang']['total_roll']}}">0</span> Roll </div>
				<div class="desc"> Total Roll Kain </div>
			</div>
			<a class="more" href="{{URL::to('penjualan')}}">Total Roll Kain
				<i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	@endif
	
	@if(App\Lib\MyHelper::hasAccess('53'))
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="dashboard-stat purple">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number">
					<span data-counter="counterup" data-value="{{$statistic['barang']['total_kg']}}">0</span> Kg </div>
				<div class="desc"> Total Berat Kain </div>
			</div>
			<a class="more" href="{{URL::to('penjualan')}}">Total Berat Kain
				<i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	@endif
	
	@if(App\Lib\MyHelper::hasAccess('53'))
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="dashboard-stat purple">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number">
					Rp. <span data-counter="counterup" style="font-size:26px" data-value="{{number_format($statistic['barang']['total_nominal_kain'], 2, '.', ',')}}">0</span></div>
				<div class="desc"> Total Nilai Kain </div>
			</div>
			<a class="more" href="{{URL::to('penjualan')}}">Total Nilai Kain
				<i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	@endif
	
	@if(App\Lib\MyHelper::hasAccess('53'))
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="dashboard-stat purple">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number">
					Rp. <span data-counter="counterup" style="font-size:26px" data-value="{{number_format($statistic['barang']['total_nominal_nonkain'], 2, '.', ',')}}">0</span></div>
				<div class="desc"> Total Nilai Barang Non Kain </div>
			</div>
			<a class="more" href="{{URL::to('penjualan')}}">Total Nilai Barang Non Kain
				<i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	@endif
	
	@if(App\Lib\MyHelper::hasAccess('53'))
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="dashboard-stat purple">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number">
					<?php $sumnyaa = $statistic['barang']['total_nominal_kain'] + $statistic['barang']['total_nominal_nonkain'];
					?>
					Rp. <span data-counter="counterup" style="font-size:26px" data-value="{{number_format($sumnyaa, 2, '.', ',')}}">0</span></div>
				<div class="desc"> Total Nilai Seluruh Stok Barang </div>
			</div>
			<a class="more" href="{{URL::to('penjualan')}}">Total Nilai Seluruh Stok Barang
				<i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	@endif
	@if(App\Lib\MyHelper::hasAccess('51') || App\Lib\MyHelper::hasAccess('52'))
	<div class="col-lg-12" style="margin-top:10px">
		<h2 style="margin-left:15px">Penjualan Pembelian</h2>
	</div>
	
	@if($thn == 'alltime' || $thn == 'last30days')
		<div class="col-lg-3" style="margin-top:20px"></div>
	@else
		<div class="col-lg-2" style="margin-top:20px"></div>
	@endif
	<div class="col-lg-3" style="text-align:right;margin-top:20px">
		@if($thn == 'last30days')
			<a href="{{URL::to('home')}}/last30days" class="btn green btn-block">30 Hari Terakhir</a>
		@else
			<a href="{{URL::to('home')}}/last30days" class="btn grey btn-block">30 Hari Terakhir</a>
		@endif
	</div>
	<div class="col-lg-3" style="text-align:right;margin-top:20px">
		@if($thn == 'alltime')
			<a href="{{URL::to('home')}}/alltime" class="btn green btn-block">Sepanjang Waktu</a>
		@else
			<a href="{{URL::to('home')}}/alltime" class="btn grey btn-block">Sepanjang Waktu</a>
		@endif
	</div>
	@if($thn == 'alltime' || $thn == 'last30days')
		<div class="col-lg-3" style="text-align:right;margin-top:20px">
			<a href="{{URL::to('home')}}" class="btn grey btn-block">Bulan Ini</a>
		</div>
	@else
	<div class="col-lg-2" style="text-align:right;margin-top:20px">
		<select id="bulane" class="form-control" name="month" onChange="gantiHome();">
			<option value="1" @if($bln == '1') selected @endif>Januari</option>
			<option value="2" @if($bln == '2') selected @endif>Februari</option>
			<option value="3" @if($bln == '3') selected @endif>Maret</option>
			<option value="4" @if($bln == '4') selected @endif>April</option>
			<option value="5" @if($bln == '5') selected @endif>Mei</option>
			<option value="6" @if($bln == '6') selected @endif>Juni</option>
			<option value="7" @if($bln == '7') selected @endif>Juli</option>
			<option value="8" @if($bln == '8') selected @endif>Agustus</option>
			<option value="9" @if($bln == '9') selected @endif>September</option>
			<option value="10" @if($bln == '10') selected @endif>Oktober</option>
			<option value="11" @if($bln == '1') selected @endif>November</option>
			<option value="12" @if($bln == '12') selected @endif>Desember</option>
		</select>
	</div>
	<div class="col-lg-2" style="text-align:right;margin-top:20px">
	<select id="tahune" class="form-control" name="year" onChange="gantiHome();">
		@for($x = $thnnow; $x >= $thnnowminspuluh; $x-- )
		<option value="{{$x}}" @if($x == $thn) selected @endif>{{$x}}</option>
		@endfor
	</select>
	</div>
	@endif
	@endif
	<div class="col-lg-12" style="margin-bottom:30px"></div>

	@if(App\Lib\MyHelper::hasAccess('52'))
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="dashboard-stat green">
			<div class="visual">
				<i class="fa fa-check-circle"></i>
			</div>
			<div class="details">
				<div class="number">
					<span data-counter="counterup" data-value="{{$statistic['penjualan']['count']}}">0</span>
				</div>
				<div class="desc">Frekuensi Penjualan</div>
			</div>
			<a class="more" href="{{URL::to('penjualan')}}"> Lihat Transaksi Penjualan
				<i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	@endif

	@if(App\Lib\MyHelper::hasAccess('52'))
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="dashboard-stat green">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number">
					Rp. <span data-counter="counterup" data-value="{{number_format($statistic['penjualan']['sum'], 2, '.', ',')}}">0</span> </div>
				<div class="desc"> Omzet Penjualan </div>
			</div>
			<a class="more" href="{{URL::to('penjualan')}}">Lihat Transaksi Penjualan
				<i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	@endif
	@if(App\Lib\MyHelper::hasAccess('52'))
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<div class="dashboard-stat green">
			<div class="visual">
				<i class="fa fa-ellipsis-h"></i>
			</div>
			<div class="details">
				<div class="number">
					Rp. <span data-counter="counterup" data-value="{{number_format($statistic['penjualan']['avg'], 2, '.', ',')}}">0</span> </div>
				<div class="desc"> Rata-rata per Penjualan </div>
			</div>
			<a class="more" href="{{URL::to('penjualan')}}">Lihat Transaksi Penjualan
				<i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	@endif
	@if(App\Lib\MyHelper::hasAccess('51'))
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="dashboard-stat blue">
			<div class="visual">
				<i class="fa fa-check-circle"></i>
			</div>
			<div class="details">
				<div class="number">
					<span data-counter="counterup" data-value="{{$statistic['pembelian']['count']}}">0</span>
				</div>
				<div class="desc">Frekuensi Pembelian</div>
			</div>
			<a class="more" href="{{URL::to('pembelian')}}"> Lihat Transaksi Pembelian
				<i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	@endif
	@if(App\Lib\MyHelper::hasAccess('51'))
	<div class="col-lg-4 col-md-4 col-sm-6 col-xs-12">
		<div class="dashboard-stat blue">
			<div class="visual">
				<i class="fa fa-bar-chart-o"></i>
			</div>
			<div class="details">
				<div class="number">
					Rp. <span data-counter="counterup" data-value="{{number_format($statistic['pembelian']['sum'], 2, '.', ',')}}">0</span> </div>
				<div class="desc"> Total Pembelian </div>
			</div>
			<a class="more" href="{{URL::to('pembelian')}}">Lihat Transaksi Pembelian
				<i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	@endif
	@if(App\Lib\MyHelper::hasAccess('51'))
	<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12">
		<div class="dashboard-stat blue">
			<div class="visual">
				<i class="fa fa-ellipsis-h"></i>
			</div>
			<div class="details">
				<div class="number">
					Rp. <span data-counter="counterup" data-value="{{number_format($statistic['pembelian']['avg'], 2, '.', ',')}}">0</span> </div>
				<div class="desc"> Rata-rata per Pembelian </div>
			</div>
			<a class="more" href="{{URL::to('pembelian')}}">Lihat Transaksi Pembelian
				<i class="m-icon-swapright m-icon-white"></i>
			</a>
		</div>
	</div>
	@endif
	
</div>

 <div class="row">
	 @if(App\Lib\MyHelper::hasAccess('55') || App\Lib\MyHelper::hasAccess('54') || App\Lib\MyHelper::hasAccess('51') || App\Lib\MyHelper::hasAccess('52'))
	<div class="col-md-6 col-sm-6">
		<!-- BEGIN PORTLET-->
		<div class="portlet light bordered">
			<div class="portlet-title tabbable-line">
				<div class="caption">
					<i class="icon-globe font-green-sharp"></i>
					<span class="caption-subject font-green-sharp bold uppercase">Kesimpulan data lainnya</span>
				</div>
			</div>
			<div class="portlet-body">
				<!--BEGIN TABS-->
				<div class="tab-content">
					<div class="scroller" style="height: 339px;" data-always-visible="1" data-rail-visible="0">
						<ul class="feeds">
							@if(App\Lib\MyHelper::hasAccess('55'))
							@if($statistic['returpenjualan']['count'] > 0)
							<li>
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-danger">
												<i class="fa fa-mail-reply"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc"> 
												Terdapat <b>{{$statistic['returpenjualan']['count']}}</b> retur penjualan senilai total <b>{{'Rp. '.number_format($statistic['returpenjualan']['sum'], 2, '.', ',')}}</b> dengan rata-rata <br><b>{{'Rp. '.number_format($statistic['returpenjualan']['avg'], 2, '.', ',')}}</b> per transaksi
											</div>
										</div>
									</div>
								</div>
							</li>
							@endif
							@endif
							@if(App\Lib\MyHelper::hasAccess('54'))
							@if($statistic['returpembelian']['count'] > 0)
							<li>
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-warning">
												<i class="fa fa-mail-forward"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc"> 
												Terdapat <b>{{$statistic['returpembelian']['count']}}</b> retur pembelian senilai total <b>{{'Rp. '.number_format($statistic['returpembelian']['sum'], 2, '.', ',')}}</b> dengan rata-rata <br><b>{{'Rp. '.number_format($statistic['returpembelian']['avg'], 2, '.', ',')}}</b> per transaksi
											</div>
										</div>
									</div>
								</div>
							</li>
							@endif
							@endif
							@if(App\Lib\MyHelper::hasAccess('52'))
							@if($statistic['penjualanngutang']['count'] > 0)
							<li>
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-danger">
												<i class="fa fa-lightbulb-o"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc"> 
												Terdapat <b>{{$statistic['penjualanngutang']['count']}}</b> penjualan belum lunas senilai total <b>{{'Rp. '.number_format($statistic['penjualanngutang']['sum'], 2, '.', ',')}}</b> dengan rata-rata <b>{{'Rp. '.number_format($statistic['penjualanngutang']['avg'], 2, '.', ',')}}</b> per transaksi
											</div>
										</div>
									</div>
								</div>
							</li>
							@endif
							@endif
							@if(App\Lib\MyHelper::hasAccess('51'))
							@if($statistic['pembelianngutang']['count'] > 0)
							<li>
								<div class="col1">
									<div class="cont">
										<div class="cont-col1">
											<div class="label label-sm label-danger">
												<i class="fa fa-lightbulb-o"></i>
											</div>
										</div>
										<div class="cont-col2">
											<div class="desc"> 
												Terdapat <b>{{$statistic['pembelianngutang']['count']}}</b> pembelian belum lunas senilai total <b>{{'Rp. '.number_format($statistic['pembelianngutang']['sum'], 2, '.', ',')}}</b> dengan rata-rata <b>{{'Rp. '.number_format($statistic['pembelianngutang']['avg'], 2, '.', ',')}}</b> per transaksi
											</div>
										</div>
									</div>
								</div>
							</li>
							@endif
							@endif
						</ul>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6 col-sm-6">
	@else
	<div class="col-md-12 col-sm-12">
	@endif 
		<div class="portlet box green-turquoise ">
			<div class="portlet-title">
				<div class="caption">
					<i class="fa fa-user"></i> Pengantar
				</div>
				<div class="tools">
					<a href="javascript:;" class="collapse"> </a>
				</div>
			</div>
			<div class="portlet-body">
				<h2 class="page-title"> Selamat Datang, {{session('nama_user')}}</h2>
				Anda dapat mengelola berbagai data sesuai dengan akses yang Anda miliki yaitu:<br><br>
				<div class="scroller" style="height:300px" data-rail-visible="1" data-rail-color="yellow" data-handle-color="#a1b2bd">
				@if(MyHelper::hasAccess('1'))
				<h4>Mengatur Toko</h4>
				<ul>
					@if(MyHelper::hasAccess('1'))<li>Melihat list</li>@endif
					@if(MyHelper::hasAccess('2'))<li>Tambah</li>@endif
					@if(MyHelper::hasAccess('3'))<li>Ubah</li>@endif
					@if(MyHelper::hasAccess('4'))<li>Hapus</li>@endif
				</ul>
				@endif
				
				@if(MyHelper::hasAccess('5'))
				<h4>Mengatur Operator</h4>
				<ul>
					@if(MyHelper::hasAccess('5'))<li>Melihat list</li>@endif
					@if(MyHelper::hasAccess('6'))<li>Tambah</li>@endif
					@if(MyHelper::hasAccess('7'))<li>Ubah</li>@endif
					@if(MyHelper::hasAccess('8'))<li>Hapus</li>@endif
				</ul>
				@endif
				
				@if(MyHelper::hasAccess('9'))
				<h4>Mengatur Supplier</h4>
				<ul>
					@if(MyHelper::hasAccess('9'))<li>Melihat List</li>@endif
					@if(MyHelper::hasAccess('10'))<li>Tambah</li>@endif
					@if(MyHelper::hasAccess('11'))<li>Ubah</li>@endif
					@if(MyHelper::hasAccess('12'))<li>Hapus</li>@endif
				</ul>
				@endif
				
				@if(MyHelper::hasAccess('13'))
				<h4>Mengatur Customer</h4>
				<ul>
					@if(MyHelper::hasAccess('13'))<li>Melihat List</li>@endif
					@if(MyHelper::hasAccess('14'))<li>Tambah</li>@endif
					@if(MyHelper::hasAccess('15'))<li>Ubah</li>@endif
					@if(MyHelper::hasAccess('16'))<li>Hapus</li>@endif
				</ul>
				
				@endif
				@if(MyHelper::hasAccess('17'))
				<h4>Mengatur Kategori</h4>
				@endif
				
				@if(MyHelper::hasAccess('18'))
				<h4>Mengatur Barang</h4>
				<ul>
					@if(MyHelper::hasAccess('18'))<li>Melihat list</li>@endif
					@if(MyHelper::hasAccess('19'))<li>Tambah</li>@endif
					@if(MyHelper::hasAccess('20'))<li>Ubah</li>@endif
					@if(MyHelper::hasAccess('21'))<li>Hapus</li>@endif
				</ul>
				@endif
				
				@if(MyHelper::hasAccess('63'))
				<h4>Mengatur Harga Beli Barang</h4>
				<ul>
					@if(MyHelper::hasAccess('63'))<li>Melihat list</li>@endif
					@if(MyHelper::hasAccess('64'))<li>Ubah</li>@endif
				</ul>
				@endif
				
				@if(MyHelper::hasAccess('66'))
				<h4>Mengatur Harga Jual Barang</h4>
				<ul>
					@if(MyHelper::hasAccess('66'))<li>Melihat list</li>@endif
					@if(MyHelper::hasAccess('67'))<li>Tambah</li>@endif
					@if(MyHelper::hasAccess('68'))<li>Ubah</li>@endif
				</ul>
				@endif
				
				@if(MyHelper::hasAccess('22'))
				<h4>Melihat Log Aktivitas</h4>
				@endif
				
				@if(MyHelper::hasAccess('23'))
				<h4>Mengatur Dana Operasional Toko</h4>
				<ul>
					@if(MyHelper::hasAccess('23'))<li>Melihat list</li>@endif
					@if(MyHelper::hasAccess('24'))<li>Tambah</li>@endif
					@if(MyHelper::hasAccess('25'))<li>Ubah</li>@endif
					@if(MyHelper::hasAccess('26'))<li>Hapus</li>@endif
				</ul>
				@endif
				
				@if(MyHelper::hasAccess('27'))
				<h4>Mengatur Pembelian</h4>
				<ul>
					@if(MyHelper::hasAccess('27'))<li>Melihat list</li>@endif
					@if(MyHelper::hasAccess('28'))<li>Tambah</li>@endif
					@if(MyHelper::hasAccess('29'))<li>Ubah</li>@endif
					@if(MyHelper::hasAccess('30'))<li>Hapus</li>@endif
				</ul>
				@endif
				
				@if(MyHelper::hasAccess('31'))
				<h4>Mengatur Penjualan</h4>
				<ul>
					@if(MyHelper::hasAccess('31'))<li>Melihat list</li>@endif
					@if(MyHelper::hasAccess('32'))<li>Tambah</li>@endif
					@if(MyHelper::hasAccess('33'))<li>Ubah</li>@endif
					@if(MyHelper::hasAccess('34'))<li>Hapus</li>@endif
				</ul>
				@endif
				
				@if(MyHelper::hasAccess('35'))
				<h4>Mengatur Retur Pembelian</h4>
				<ul>
					@if(MyHelper::hasAccess('35'))<li>Melihat list</li>@endif
					@if(MyHelper::hasAccess('36'))<li>Tambah</li>@endif
					@if(MyHelper::hasAccess('37'))<li>Ubah</li>@endif
					@if(MyHelper::hasAccess('38'))<li>Hapus</li>@endif
				</ul>
				@endif
				
				@if(MyHelper::hasAccess('39'))
				<h4>Mengatur Retur Penjualan</h4>
				<ul>
					@if(MyHelper::hasAccess('39'))<li>Melihat list</li>@endif
					@if(MyHelper::hasAccess('40'))<li>Tambah</li>@endif
					@if(MyHelper::hasAccess('41'))<li>Ubah</li>@endif
					@if(MyHelper::hasAccess('42'))<li>Hapus</li>@endif
				</ul>
				@endif
				
				@if(MyHelper::hasAccess('43'))
				<h4>Mengatur Transfer Barang</h4>
				<ul>
					@if(MyHelper::hasAccess('43'))<li>Melihat list</li>@endif
					@if(MyHelper::hasAccess('44'))<li>Tambah</li>@endif
					@if(MyHelper::hasAccess('45'))<li>Ubah</li>@endif
					@if(MyHelper::hasAccess('46'))<li>Hapus</li>@endif
				</ul>
				@endif
				
				@if(MyHelper::hasAccess('47'))
				<h4>Mengatur Penyesuaian Stok</h4>
				<ul>
					@if(MyHelper::hasAccess('47'))<li>Melihat list</li>@endif
					@if(MyHelper::hasAccess('48'))<li>Tambah</li>@endif
					@if(MyHelper::hasAccess('49'))<li>Ubah</li>@endif
					@if(MyHelper::hasAccess('50'))<li>Hapus</li>@endif
				</ul>
				@endif
				
				@if(MyHelper::hasAccess('51'))
				<h4>Melihat Report</h4>
				<ul>
					@if(MyHelper::hasAccess('65'))<li>Global</li>@endif
					@if(MyHelper::hasAccess('53'))<li>Barang</li>@endif
					@if(MyHelper::hasAccess('52'))<li>Penjualan</li>@endif
					@if(MyHelper::hasAccess('51'))<li>Pembelian</li>@endif
					@if(MyHelper::hasAccess('55'))<li>Retur Penjualan</li>@endif
					@if(MyHelper::hasAccess('54'))<li>Retur Pembelian</li>@endif
					@if(MyHelper::hasAccess('53'))<li>Penyesuaian Stok</li>@endif
					@if(MyHelper::hasAccess('59'))<li>Transfer Barang</li>@endif
					@if(MyHelper::hasAccess('60'))<li>Dana Operasional</li>@endif
					@if(MyHelper::hasAccess('61'))<li>Laba Rugi</li>@endif
				</ul>
				@endif
				</div>
			</div>
		</div>
	</div>
</div>
@endsection
