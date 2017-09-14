<!DOCTYPE html>
<html>
  @include('head')
  <body class="page-sidebar-closed-hide-logo page-content-white page-boxed">
    <input id="root-url" type="text" name="" value="{{url('')}}" hidden>
    @include('headers.header')
    <div class="container">
      <div class="page-container">
        @include('sidebars.driver')
        <div class="page-content-wrapper">
          <div class="page-content" style="min-height: 1133px;">
            <input id="root-url" type="text" value="{{url('')}}" hidden>
            @yield('content')
          </div>
        </div>
      </div>

      <div class="page-footer">
          <div class="page-footer-inner"> 2017 &copy;
              <a target="_blank" href="http://balkondesborobudur.com/" target="_blank">PT Taman Wisata Candi Borobudur</a> &nbsp;&nbsp;
              <div class="scroll-to-top">
                  <i class="icon-arrow-up"></i>
              </div>
          </div>
          <!-- END FOOTER -->
      </div>
    </div>

    @include('scripts')
  </body>
</html>
