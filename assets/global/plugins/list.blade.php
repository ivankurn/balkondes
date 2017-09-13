@extends('body')

@section('page-scripts')
  <script type="text/javascript">
    $(document).ready(function(){
      $('[data-toggle="tooltip"]').tooltip();
    });
  </script>
@endsection

@section('content')
  <h1 class="page-title"> {{Session::get('data')['title']}}
  </h1>
  <div class="page-bar">
      <ul class="page-breadcrumb">
          <li>
              <i class="fa fa-home"></i>
              <a href="{{url('/home')}}">Home</a>
              <i class="fa fa-angle-right"></i>
          </li>
          <li>
              <i class="fa fa-diamond"></i>
              <span>Products</span>
              <i class="fa fa-angle-right"></i>
          </li>
          <li>
              <i class="fa fa-diamond"></i>
              <span>Products</span>
              <i class="fa fa-angle-right"></i>
          </li>
          <li>
              <i class="fa fa-list"></i>
              <span>List</span>
          </li>

      </ul>
  </div>

<div class="portlet light">
  <div class="portlet-body">

    <div class="mt-element-overlay">
        <div class="row">
          @for($i = 0 ; $i <= 5 ; $i++)
            <div class="col-md-4" style="margin-bottom:20px;">
                <div class="mt-overlay-3 mt-overlay-3-icons">
                    <img src="{{asset('assets/pages/img/page_general_search/05.jpg')}}">
                    <div class="mt-overlay">
                        <h2>Overlay Title</h2>
                        <ul class="mt-info">
                            <li>
                                <a class="btn default " href="javascript:;" data-toggle="tooltip" title="View">
                                    <i class="fa fa-search"></i>
                                </a>
                            </li>
                            <li>
                                <a class="btn default blue" href="javascript:;" data-toggle="tooltip" title="Edit">
                                    <i class="fa fa-edit"></i>
                                </a>
                            </li>
                            <li>
                                <a class="btn default dark" href="javascript:;" data-toggle="tooltip" title="Deactivate">
                                    <i class="fa fa-eye-slash"></i>
                                </a>
                            </li>
                            <li>
                                <a class="btn default red" href="javascript:;" data-toggle="tooltip" title="Remove">
                                    <i class="fa fa-trash"></i>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
          @endfor
        </div>
    </div>
  </div>
</div>

@endsection
