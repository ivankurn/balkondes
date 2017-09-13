<?php
	use App\Lib\MyHelper;
?>
@extends('body')
@section('page-plugin-styles')
	<link href="{{asset('assets/global/plugins/bootstrap-daterangepicker/daterangepicker.min.css')}}" rel="stylesheet" type="text/css" />
    <link href="{{asset('assets/global/plugins/morris/morris.css')}}" rel="stylesheet" type="text/css" />
@endsection


@section('page-plugin-js')

@endsection

@section('page-scripts')

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

Ini Kasir
@endsection
