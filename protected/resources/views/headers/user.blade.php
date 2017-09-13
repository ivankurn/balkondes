<?php
	use App\Lib\MyHelper;
?>
<li class="dropdown dropdown-user dropdown-light">
    <a href="javascript:;" class="dropdown-toggle" data-toggle="dropdown" data-hover="dropdown" data-close-others="true">
        <img alt="" class="img-circle" src="{{asset('assets/images/user.png')}}">
        <span class="username username-hide-on-mobile"> {{Session::get('username')}} </span>
        <i class="fa fa-angle-down"></i>
    </a>
	<ul class="dropdown-menu dropdown-menu-default">
		<li>
            <a href="{{url('logout')}}">
                <i class="icon-key"></i> Log Out </a>
        </li>
    </ul>
</li>
