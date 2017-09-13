<?php
	use App\Lib\MyHelper;

	$menu_active = Session::get('data')['menu_active'];
?>
<div class="page-sidebar-wrapper">
  <div class="page-sidebar navbar-collapse collapse">
      <ul class="page-sidebar-menu  page-header-fixed page-sidebar-menu-compact" data-keep-expanded="false" data-auto-scroll="true" data-slide-speed="200">
		<li class="nav-item {{($menu_active == 'kasir') ? 'active open' : ''}}">
            <a href="{{url('kasir')}}" class="nav-link">
                <i class="fa fa-home"></i>
                <span class="title">Kasir</span>
            </a>
        </li>
		<li class="nav-item {{($menu_active == 'heru') ? 'active open' : ''}}">
            <a href="{{url('driver/heru')}}" class="nav-link">
                <i class="fa fa-home"></i>
                <span class="title">Driver Heru</span>
            </a>
        </li>
		<li class="nav-item {{($menu_active == 'andi') ? 'active open' : ''}}">
            <a href="{{url('driver/andi')}}" class="nav-link">
                <i class="fa fa-home"></i>
                <span class="title">Driver Andi</span>
            </a>
        </li>
		<li class="nav-item {{($menu_active == 'ivan') ? 'active open' : ''}}">
            <a href="{{url('driver/ivan')}}" class="nav-link">
                <i class="fa fa-home"></i>
                <span class="title">Driver Ivan</span>
            </a>
        </li>
</div>
