
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
                <h4 class="mr-1 mb-0 d-inline-block">{{ $order->id }}</h4>
            </li>
        </ol>
    </nav>
    
</div>
<!--  End path  -->



<!--    Start header of Order   -->
<form class="formSendAjaxRequest card card-shadow was-validated" id="form-order" focus-on="#form-order"
     refresh-seconds="1" action="{{ url('client/purchase-orders/edit') }}" method="POST">

    @csrf

    <input type="hidden" name="id" value="{{ $order->id }}" />

    {{--   Start header data of Order  --}}
    <div class="card-header bg-white">
        
        <div class="formResult my-3 text-center"></div>

        <div class="row"> 

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label class="col-auto w-125px col-form-label text-right">رقم الطلب</label>
                    <div class="col pr-md-0">
                        <input type="text" value="{{ $order->id }}" class="form-control" readonly>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label class="col-auto w-125px col-form-label text-right">الحالة</label>
                    <div class="col pr-md-0">
                        <input type="text" value="{{ $order->getState() }}" class="form-control" readonly>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label class="col-auto w-125px col-form-label text-right">تاريخ الطلب</label>
                    <div class="col pr-md-0">
                        <input type="text" value="{{ $order->created_at() }}" dir="ltr" class="form-control text-right" readonly>
                    </div>
                </div>
            </div>

        </div>

    </div>
    {{--  End header data of Order  --}}


    {{--  Start Items of Order  --}}
    <div class="card-body px-0"> 

        <table class="table table-striped text-center">
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

        @foreach($order->items as $item)
            addRowInput(
                "{{ $item->link }}",
                "{{ $item->count }}",
                "{{ $item->color }}",
                {!! json_encode($item->desc) !!},
                "{{ $item->id }}"
            );
        @endforeach

        $(form).on('change', 'input:not([type=hidden]) , textarea', function () {
            var tr = $(this).closest('tr');
            var state = $(tr).find('[name="items[row_state][]"]');
            if (state.val() === 'default') {
                {{-- /* if state of row is default ,so it means old data from Database and I have to change state to updated */ --}}
                $(state).val('updated');
            }
        });

    </script>
@endsection