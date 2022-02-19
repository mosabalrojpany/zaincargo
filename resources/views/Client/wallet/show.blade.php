
@extends('Client.layouts.app')

@section('content')
    <!--  Start path  -->
    <div class="d-flex align-items-center bg-white mb-3 d-print-none">

        <nav class="col pr-0" aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb bg-white mb-0">
                <li class="breadcrumb-item">
                    <a href="">محفظة</a>
                </li>
                <li class="breadcrumb-item active text-truncate col pr-0 text-right" aria-current="page">
                    <span class="mr-1"></span>
                </li>
            </ol>
        </nav>
    </div>
    <!--  End path  -->
    <div class="card card-shadow">
        @include('CP.elerts.errors')
        @include('CP.elerts.success')
        {{--  Start header of Order  --}}
        <div class="card-header text-right bg-white pt-4">
            <div class="row">
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">اسم الزبون</label>
                        <div class="col text-secondary">
                            <a >{{$data->customer->name}}</a>
                        </div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">رقم العضوية</label>
                        <div class="col text-secondary"><bdi>{{ $data->customer->code }}</bdi></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">الفرع</label>
                    <div class="col text-secondary"><bdi><label class="col-auto w-125px">{{$data->customer->branches->city}}</label></bdi></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>
            </div>
        </div>
        {{--  End header of Order  --}}
        {{--  جدول يعرض كم عند الزبون   --}}
                <div class="card-body">
                    <table class="table table-center table-bordered text-center">
                        <thead>
                            <tr>
                                
                                <th>LY طرابلس</th>
                                <th>$ طرابلس</th>
                                <th>LY بنغازي</th>
                                <th>$ بنغازي</th>
                                <th>LY مصراته</th>
                                <th>$ مصراته</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr> 
                                <td>{{$data->money_denar_t}}</td>
                                <td>{{$data->money_dolar_t}}</td>
                                <td>{{$data->money_denar_b}}</td>
                                <td>{{$data->money_dolar_b}}</td>
                                <td>{{$data->money_denar_m}}</td>
                                <td>{{$data->money_dolar_m}}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
                {{--  End  --}}
                {{--  Start items of Order  --}}
                <div class="card-body">
                    <table class="table table-center table-bordered text-center">
                        <thead>
                            <tr>
                                <th>#</th>
                                <th>النوع</th>
                                <th>القيمة</th>
                                <th>العملة</th>
                                <th>التاريخ</th>
                                <th>الفرع</th>
                                <th class="">ملاحظة</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($data->business as $change)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{$change->depositytypee()}}</td>
                                <td>{{$change->price}}</td>
                                <td>{{$change->currencytype->name}}</td>
                                <td>{{$change->created_at}}</td>
                                <td>{{$change->branchess->city}}</td>
                                <td>{{$change->note}}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                {{--  End items of Order  --}}
{{--  pagination  --}}
    </div>
@endsection
