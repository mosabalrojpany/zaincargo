@if (Session::has('success'))
<div class="alert alert-primary" role="alert" style="margin-top: 10PX;text-align: center;">
  {{(Session::get('success'))}}  
  </div>
@endif