@extends('Client.layouts.app')


@section('content')


{{--  Start header  --}}
<h4 class="font-weight-bold">الشحنات {{ $invoices->total() }}</h4>
{{--  End header  --}}



{{--  Start box invoices  --}}
<div class="card shadow border-0 my-4 text-center">

    <!-- Start search  -->
    <div class="card-header bg-primary text-white">
        <form class="row justify-content-between" action="{{ Request::url() }}" method="get">

            <input type="hidden" name="search" value="1">

            <div class="form-inline col-auto d-none d-xl-flex">
                <div class="form-group">
                    <label for="inputShowSearch">عرض</label>
                    <input type="number" id="inputShowSearch" name="show" min="10" max="500" class="form-control mx-sm-2" value="{{ Request::has('show') ? Request::get('show') : 25 }}" />
                </div>
            </div>

            <div class="form-inline">
                <span class="mx-2"><i class="fa fa-filter"></i></span>
                <div class="form-group mb-0">
                    <label class="d-none" for="inputIdSearch">رقم الفاتورة</label>
                    <input type="number" name="id" min="1" value="{{ Request::get('id') }}" placeholder="رقم الفاتورة" id="inputIdSearch" class="form-control mx-sm-2">
                </div>
                <div class="form-group d-none d-lg-flex">
                    <label class="d-none" for="inputTrackingNumberSearch">رقم التتبع</label>
                    <input type="search" maxlength="32" name="tracking_number" value="{{ Request::get('tracking_number') }}" placeholder="رقم التتبع" id="inputTrackingNumberSearch" class="form-control mx-sm-2">
                </div>
                <div class="form-group d-none d-sm-flex">
                    <label class="d-none" for="inputShipmentCodeSearch">رمز الشحنة</label>
                    <input type="search" maxlength="32" name="shipment_code" value="{{ Request::get('shipment_code') }}" placeholder="رمز الشحنة" id="inputShipmentCodeSearch" class="form-control mx-sm-2">
                </div>
                <div class="form-group">
                    <label class="d-none" for="inputStateSearch">الحالة</label>
                    <select id="inputStateSearch" class="form-control mx-sm-2 setValue" style="width: 220px;" name="state" value="{{ Request::get('state') }}">
                        <option value="">كل الحالات</option>
                        @foreach(__('shipmentStatus.shipment_status') as $k=>$v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                </div>

                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </div>

        </form>
    </div>
    <!-- End search  -->

    <!--    Start show invoices   -->
    <div class="card-body p-0">
        <table class="table table-center table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col" class="d-none d-md-table-cell">#</th>
                    <th scope="col">رقم الفاتورة</th>
                    <th scope="col" class="d-none d-md-table-cell">رقم الرحلة</th>
                    <th scope="col" class="d-none d-sm-table-cell">الحالة</th>
                    <th scope="col" class="d-none d-lg-table-cell">رقم التتبع</th>
                    <th scope="col">رمز الشحنة</th>
                    <th scope="col" class="d-none d-lg-table-cell">تاريخ الاستلام</th>
                </tr>
            </thead>
            <tbody>

                <!-- Start print invoices -->
                @foreach($invoices as $invoice)
                    <tr>
                        <th scope="row" class="d-none d-md-table-cell">{{ $loop->iteration }}</th>
                        <td>
                            <a href="{{ url('client/shipping-invoices',$invoice->id) }}">{{ $invoice->id }}</a>
                        </td>
                        <td class="d-none d-md-table-cell">{{ $invoice->trip_number() }}</td>
                        <td class="d-none d-sm-table-cell">{{ $invoice->getState() }}</td>
                        <td class="d-none d-lg-table-cell">{{ $invoice->tracking_number }}</td>
                        <td>{{ $invoice->shipment_code }}</td>
                        <td class="d-none d-lg-table-cell">
                            <bdi>{{ $invoice->arrived_at() }}</bdi>
                        </td>
                    </tr>
                @endforeach
                <!-- End print invoices -->

            </tbody>
        </table>
    </div>
    <!--    End show invoices   -->

</div>
{{--  End box invoices  --}}



{{--  pagination  --}}
<div class="pagination-center">{{ $invoices->links() }}</div>



@endsection
