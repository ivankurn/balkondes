<!DOCTYPE html>
<html>
	@include('head-front')
	<body class="page-container-bg-solid page-md">
		<input id="root-url" type="text" name="" value="{{url('')}}" hidden>
		@include('headers.header-front')
		<div class="clearfix"> </div>
			<div class="page-container page-content-inner page-container-bg-solid">
				@yield('content')
			</div>
		</div>
		<div class="page-footer">
			<div class="go2top">
				<i class="icon-arrow-up"></i>
			</div>
		</div>
		@include('scripts-front')
	</body>
</html>
