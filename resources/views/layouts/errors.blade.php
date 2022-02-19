@if(count($errors)> 0 ) 
<div class="alert alert-danger alert-dismissible text-right fade show" role="alert">
    <ul class="mb-0">
        @foreach($errors->all() as $e)
        <li>{{$e}}</li>
        @endforeach
    </ul>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
@endif