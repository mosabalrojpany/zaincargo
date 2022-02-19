
@extends('Client.layouts.app')

@section('content')


<!--  Start path  -->
<div class="d-flex align-items-center justify-content-between mb-3">

    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb mb-0" style="background-color: transparent">
            <li class="breadcrumb-item"> 
                <h4 class="mb-0">
                    <a class="text-decoration-none" href="{{ url('client/purchase-orders') }}">طلبات الشراء</a> 
                </h4> 
            </li>
            <li class="breadcrumb-item active text-truncate col pr-0 text-right" aria-current="page">
                <h4 class="mr-1 mb-0 d-inline-block">طلب جديد</h4>
            </li>
        </ol>
    </nav>
    
</div>
<!--  End path  -->


<!--    Start header of Order   -->
<form class="formSendAjaxRequest card card-shadow was-validated" id="form-order" focus-on="#form-order"
     refresh-seconds="1" msgClasses="my-3" action="{{ url('client/purchase-orders') }}" method="POST">

    @csrf

    <div class="card-header bg-primary text-white rounded-top">
        <h5 class="text-center my-1">محتويات الطلب</h5>
    </div>
    
    <div class="formResult text-center"></div>

    {{--  Start Items of Order  --}}
    <div class="card-body p-0"> 

        <table class="table text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>الوصف</th>
                    <th>الرابط</th>
                    <th class="w-150px">العدد</th>
                    <th class="w-150px">اللون</th>
                    <th>خيارات</th>
                </tr>
            </thead>
            <tbody>

                {{--  I will add rows using js  --}}

            </tbody>
        </table>
    
    </div>
    {{--  End Items of Order  --}}    
    

    <!--    Start footer    -->
    <div class="card-footer d-flex align-items-center justify-content-between">
        <div class="form-group mb-0 pr-5">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="customControlIamSure" required>
                <label class="custom-control-label" for="customControlIamSure">أنا متأكد</label>
            </div>
        </div> 
        <button type="submit" class="btn btn-primary w-125px">حفظ</button>
    </div>
    <!--    End footer    -->


</form>
<!--    End header of Order   -->



@endsection


{{--   this line will get value using laravl  --}}
@section('extra-js')

    @include('Client.purchase_orders.create-edit-js')

    <script> 

            {{--  /*  Add row as default row to allow to user add items */  --}}
            addRowInputEmptyWithStatusAdded();

    </script>

@endsection