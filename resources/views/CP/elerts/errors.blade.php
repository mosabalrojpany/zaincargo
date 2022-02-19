@if (Session::has('error'))
<div class="alert alert-danger" role="alert" style="margin-top: 10PX;text-align: center;">
  {{(Session::get('error'))}}  
  </div>
@endif