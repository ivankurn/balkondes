@if($errors->any())
  <div class="alert alert-danger">
   <strong>Error!</strong> <br/>
   @foreach($errors->all() as $e)
    - {{$e}} <br/>
   @endforeach
 </div>

@endif

@if(Session::has('success'))
  <div class="alert alert-success">
   <strong>Success!</strong><br/>

   @foreach(Session::get('success') as $s)
     - {{$s}} <br/>
   @endforeach
 </div>
 <?php Session::forget('success'); ?>
@endif

@if(Session::has('warning'))
  <div class="alert alert-warning">
    <strong>Warning!</strong> <br/>
    @foreach(Session::get('warning') as $w)
        - {{$w}} <br/>
    @endforeach

 </div>
 <?php Session::forget('warning'); ?>
@endif
