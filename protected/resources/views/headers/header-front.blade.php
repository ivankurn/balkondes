<div class="page-header navbar-fixed-top">
	<!-- BEGIN HEADER INNER -->
	<div class="clearfix">
		<!-- BEGIN BURGER TRIGGER -->
		<div class="burger-trigger">
			<button class="menu-trigger">
				<img src="{{ URL::to('assets/layouts/layout7/img/m_toggler.png') }}" alt=""> </button>
			<div class="menu-overlay menu-overlay-bg-transparent">
				<div class="menu-overlay-content">
					<ul class="menu-overlay-nav text-uppercase">
						<li>
						   <a href="{{URL::to('/')}}">Pemesanan</a>
						</li>
						<li>
						   <a href="{{URL::to('login')}}">Login</a>
						</li>
					</ul>
				</div>
			</div>
			<div class="menu-bg-overlay">
				<button class="menu-close">&times;</button>
			</div>
			<!-- the overlay element -->
		</div>
		<!-- END NAV TRIGGER -->
		<!-- BEGIN LOGO -->
		<div class="page-logo">
			<a href="{{ URL::to('/')}}">
				<img src="{{ URL::to('assets/layouts/layout7/img/logo-big-green.png') }}" alt="" style="height: 50px !important;"></a>
		</div>
		<!-- END LOGO -->
		<!-- BEGIN TOP NAVIGATION MENU -->
		<div class="top-menu">
		</div>
		<!-- END TOP NAVIGATION MENU -->
	</div>
	<!-- END HEADER INNER -->
</div>