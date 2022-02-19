@extends('Client.layouts.app')


@section('content')


    {{--  Start header  --}}
    <div class="d-flex justify-content-between align-items-center">
        <h4 class="font-weight-bold mb-0">الحوالات المالية {{ $transfers->total() }}</h4>
        <a class="btn btn-primary w-100px" href="{{ url('client/money-transfers/create') }}">
            <i class="fas fa-plus mx-1"></i>أضف
        </a>
    </div>
    {{--  End header  --}}



    {{--  Start box Transfers  --}}
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
                        <label class="d-none" for="inputTransferIdSearch">رقم الحوالة</label>
                        <input type="number" min="1" name="id" value="{{ Request::get('id') }}" placeholder="رقم الحوالة" id="inputTransferIdSearch" class="form-control mx-sm-2">
                    </div>
                    <div class="form-group d-none d-sm-flex">
                        <label class="d-none" for="inputStateSearch">الحالة</label>
                        <select id="inputStateSearch" class="form-control mx-sm-2 setValue" style="min-width: 180px;" name="state" value="{{ Request::get('state') }}">
                            <option value="">كل الحالات</option>
                            @foreach(trans('moneyTransfer.status') as $k => $v)
                                <option value="{{ $k }}">{{ $v }}</option>
                            @endforeach
                        </select>
                    </div>
                    
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                </div>

            </form>  
        </div>
        <!-- End search  -->

        <!--    Start show Transfers   -->
        <div class="card-body p-0">
            <table class="table table-center table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col" class="d-none d-md-table-cell">#</th>
                        <th scope="col" class="no-wrap">رقم الحوالة</th>
                        <th scope="col" class="d-none d-lg-table-cell">اسم المستلم</th>
                        <th scope="col" class="d-none d-sm-table-cell">الحالة</th>
                        <th scope="col">المبلغ</th>
                        <th scope="col" class="d-none d-sm-table-cell">تاريخ الطلب</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- Start print Transfers -->
                    @foreach($transfers as $transfer)
                        <tr>
                            <th scope="row" class="d-none d-md-table-cell">{{ $loop->iteration }}</th>
                            <td>
                                <a href="{{ url('client/money-transfers',$transfer->id) }}">{{ $transfer->id }}</a>
                            </td> 
                            <td class="d-none d-lg-table-cell"><bdi>{{ $transfer->recipient }}</bdi></td> 
                            <td class="no-wrap d-none d-sm-table-cell">{{ $transfer->getState() }}</td> 
                            <td class="no-wrap"><b>{{ $transfer->amount.$transfer->currency->sign }}</b></td> 
                            <td class="d-none d-sm-table-cell"><bdi>{{ $transfer->created_at() }}</bdi></td> 
                        </tr>
                    @endforeach
                    <!-- End print Transfers -->

                </tbody>
            </table>
        </div>
        <!--    End show Transfers   -->

    </div>
    {{--  End box Transfers  --}}



    {{--  pagination  --}}
    <div class="pagination-center">{{ $transfers->links() }}</div>  



@endsection