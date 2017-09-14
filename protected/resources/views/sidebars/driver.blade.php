<?php
	use App\Lib\MyHelper;

	$menu_active = Session::get('data')['menu_active'];
?>
<div class="page-sidebar-wrapper">
  <div class="page-sidebar navbar-collapse collapse">
      <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-compact" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
		<li class="nav-item {{($menu_active == 'baru') ? 'active open' : ''}}">
            <a href="{{url('driver')}}/{{Session::get('name')}}" class="nav-link">
                <i class="fa fa-home"></i>
                <span class="title">Pesanan Baru</span>
            </a>
        </li>
		<li class="nav-item {{($menu_active == 'selesai') ? 'active open' : ''}}">
            <a href="{{url('driver')}}/{{Session::get('name')}}/selesai" class="nav-link">
                <i class="fa fa-home"></i>
                <span class="title">Pesanan Selesai</span>
            </a>
        </li>
</div>
