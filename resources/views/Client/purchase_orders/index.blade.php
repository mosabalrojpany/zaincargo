@extends('Client.layouts.app')


@section('content')


    {{--  Start header  --}}
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="font-weight-bold mb-0">طلبات الشراء {{ $orders->total() }}</h4>
        <a class="btn btn-primary w-100px" href="{{ url('client/purchase-orders/create') }}">
            <i class="fas fa-plus mx-1"></i>أضف
        </a>
    </div>
    {{--  End header  --}}



    {{--  Start box orders  --}}
    <div class="card card-shadow my-4 text-center">

        <!-- Start search  -->
        <div class="card-header bg-primary text-white">
            <form class="row justify-content-between" action="{{ Request::url() }}" method="get">

                <input type="hidden" name="search" value="1">

                <div class="form-inline col-auto d-none d-lg-flex">
                    <div class="form-group">
                        <label for="inputShowSearch">عرض</label>
                        <input type="number" id="inputShowSearch" name="show" min="10" max="500" class="form-control mx-sm-2" value="{{ Request::has('show') ? Request::get('show') : 25 }}" />
                    </div>
                </div>

                <div class="form-inline">
                    <span class="mx-2"><i class="fa fa-filter"></i></span>
                    <div class="form-group mb-0">
                        <label class="d-none" for="inputIdSearch">رقم الطلب</label>
                        <input type="number" name="id" min="1" value="{{ Request::get('id') }}" placeholder="رقم الطلب" id="inputIdSearch" class="form-control mx-sm-2">
                    </div>
                    <div class="form-group d-none d-sm-flex">
                        <label class="d-none" for="inputStateSearch">الحالة</label>
                        <select id="inputStateSearch" class="form-control mx-sm-2 setValue" style="min-width: 180px;" name="state" value="{{ Request::get('state') }}">
                            <option value="">كل الحالات</option>
                            @foreach(trans('purchaseOrdersStatus.purchase_order_status') as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>

                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                </div>

            </form>
        </div>
        <!-- End search  -->

        <!--    Start show orders   -->
        <div class="card-body p-0">
            <table class="table table-center table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="d-none d-md-table-cell">#</th>
                        <th scope="col">رقم الطلب</th>
                        <th scope="col">الحالة</th>
                        <th scope="col" class="d-none d-lg-table-cell">عمولة الشراء</th>
                        <th scope="col" class="d-none d-md-table-cell">إجمالي التكلفة</th>
                        <th scope="col" class="d-none d-sm-table-cell">تاريخ الطلب</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- Start print orders -->
                    @foreach($orders as $order)

                        <tr>
                            <th scope="row" class="d-none d-md-table-cell">{{ $loop->iteration }}</th>
                            <td><a href="{{ url('client/purchase-orders',$order->id) }}">{{ $order->id }}</a></td>
                            <td>{{ $order->getState() }}</td>
                            <td class="d-none d-lg-table-cell">{{ $order->getFee() }}</td>
                            <td class="d-none d-md-table-cell">{{ $order->getTotalCostByCurrency() }}</td>
                            <td class="d-none d-sm-table-cell"><bdi>{{ $order->created_at() }}</bdi></td>
                        </tr>

                    @endforeach
                    <!-- End print orders -->

                </tbody>
            </table>
        </div>
        <!--    End show orders   -->

    </div>
    {{--  End box orders  --}}



    {{--  pagination  --}}
    <div class="pagination-center">{{ $orders->links() }}</div>



@endsection
