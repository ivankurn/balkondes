<div class="page-header navbar navbar-static-top">
	<div class="page-header-inner container">
		<div class="page-logo">
			<a href="{{url('/')}}">
				<img src="{{asset('assets/images/logo-web.png')}}" alt="logo"  class="logo-default" style="margin:8px !important">
			</a>
			<div class="menu-toggler sidebar-toggler"><span></span></div>
		</div>
		<a href="javascript:;" class="menu-toggler responsive-toggler" data-toggle="collapse" data-target=".navbar-collapse">
			<span></span>
		</a>
		
		<div class="page-top">
			<div class="top-menu">
				<ul class="nav navbar-nav pull-right">
					@include('headers.user')
				</ul>
			</div>
		</div>
	</div>
</div>
<div class="clearfix"></div>
