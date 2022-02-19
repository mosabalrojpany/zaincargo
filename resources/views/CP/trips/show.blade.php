
@extends('CP.layouts.header-footer')

@section('content')


<!--  Start path  -->
<div class="d-flex align-items-center bg-white mb-3 d-print-none">

    <nav class="col pr-0" aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-white mb-0">
            <li class="breadcrumb-item">
                <a href="{{ url('cp/trips') }}">الرحلات</a>
            </li>
            <li class="breadcrumb-item active text-truncate col pr-0 text-right" aria-current="page">
                <span class="mr-1">{{ $trip->id }}</span>
            </li>
        </ol>
    </nav>

    <div class="col-auto">

        @if(hasRole('trips_edit'))
            <a href="{{ url('cp/trips/edit',$trip->id) }}" class="btn btn-primary btn-sm">
                <i class="fas fa-pen"></i>
            </a>
        @endif

        @if(hasRole('trips_delete'))
            <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">
                <i class="fas fa-trash"></i>
            </button>
        @endif
    </div>

</div>
<!--  End path  -->



<div class="card card-shadow">

    {{--  Start header of trip  --}}
    <div class="card-header text-right bg-white pt-4">

        <div class="row">

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">رقم الرحلة</label>
                    <div class="col text-secondary"><bdi>{{ $trip->trip_number }}</div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">رقم التتبع</label>
                    <div class="col text-secondary"><bdi>{{ $trip->tracking_number }}</bdi></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">الحالة</label>
                    <div class="col text-secondary"><b>{{ $trip->getState() }}</b></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">الشركة</label>
                    <div class="col text-secondary"><bdi>{{ $trip->company->name }}</bdi></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">العنوان</label>
                    <div class="col text-secondary">{{ $trip->address->name }}</div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">تاريخ الإضافة</label>
                    <div class="col text-secondary"><bdi>{{ $trip->created_at() }}</bdi></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">تاريخ الخروج</label>
                    <div class="col text-secondary"><bdi>{{ $trip->exit_at() }}</bdi></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">تاريخ الوصول المتوقع</label>
                    <div class="col text-secondary"><bdi>{{ $trip->estimated_arrive_at() }}</bdi></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">تاريخ الوصول الفعلي</label>
                    <div class="col text-secondary"><bdi>{{ $trip->arrived_at() }}</bdi></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px pl-0">العملة</label>
                    <div class="col text-secondary"><b>{{ $trip->currency->name }}</b></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            @unless ($trip->isCurrencyEqualsMain())

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px pl-0">سعر الصرف</label>
                        <div class="col text-secondary"><b>{{ $trip->exchange_rate }}</b></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

            @endunless

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">التكلفة</label>
                    <div class="col"><b>{!! $trip->cost() !!}</b></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">الوزن الفعلي</label>
                    <div class="col text-secondary"><bdi>{{ $trip->weight }}</bdi></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            @unless ($trip->isCurrencyEqualsMain())
                <div class="col-md-6 col-lg-4 mb-3"></div>
            @endunless

            <div class="col-md-6 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">وصف الحالة</label>
                    <div class="col text-secondary"><b>{{ $trip->state_desc }}</b></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 mb-3">
                <div class="row">
                    <label class="col-auto w-125px pl-0">معلومات أخرى</label>
                    <div class="col text-secondary">{{ $trip->extra }}</div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

        </div>

        <hr/>

        <div class="row">

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px pl-0">إجمالي التكاليف</label>
                    <div class="col text-secondary"><bdi>{{ $trip->total_cost }}</bdi> {{ app_settings()->currency->sign }}</div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px pl-0">إجمالي التكاليف الإضافية</label>
                    <div class="col text-secondary"><bdi>{{ $trip->total_additional_cost }}</bdi> {{ app_settings()->currency->sign }}</div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px pl-0">إجمالي المدفوع</label>
                    <div class="col text-secondary"><bdi>{{ $trip->total_paid }}</bdi> {{ app_settings()->currency->sign }}</div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px pl-0">إجمالي الوزن</label>
                    <div class="col text-secondary">kg<bdi>{{ $trip->invoices->sum('weight') }}</bdi></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px pl-0">إجمالي الوزن الحجمي</label>
                    <div class="col text-secondary">kg<bdi>{{ $trip->invoices->sum('volumetric_weight') }}</bdi></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px pl-0">إجمالي الحجم (CBM)</label>
                    <div class="col text-secondary">CBM<bdi>{{ $trip->invoices->sum('cubic_meter') }}</bdi></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

        </div>

    </div>
    {{--  End header of trip  --}}


    {{--  Start items of trip  --}}
    <div class="card-body">


        {{-- Start print total cost grouped by currencies --}}
        <h4 class="p-3 bg-secondary text-white text-right mb-0 rounded-top">إجمالي التكلفة</h4>

        <table class="table table-center table-bordered text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>التكلفة</th>
                    <th>العملة</th>
                    <th>عدد الشحنات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data->total_cost_by_currencies as $cost)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $cost['amount'] }}</td>
                    <td>{{ $cost['currency'] }}</td>
                    <td>{{ $cost['count'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- Start print total cost grouped by currencies --}}


        {{-- Start print total paid up grouped by currencies --}}
        <h4 class="p-3 bg-secondary text-white text-right mb-0 rounded-top">المبلغ المستلم</h4>

        <table class="table table-center table-bordered text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>المدفوع</th>
                    <th>العملة</th>
                    <th>عدد الشحنات</th>
                </tr>
            </thead>
            <tbody>
                @foreach($data->total_paid_by_currencies as $paid)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $paid['amount'] }}</td>
                    <td>{{ $paid['currency'] }}</td>
                    <td>{{ $paid['count'] }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
        {{-- Start print total paid up grouped by currencies --}}



        @foreach ($data->receive_in as $place)

        <h4 class="p-3 bg-primary text-white text-right mb-0 rounded-top">مكان الاستلام : {{ $data->shipments[$place][0]->receivingPlace->name }}</h4>

        <table class="table table-center table-bordered text-center">
            <thead>
                <tr>
                    <th>#</th>
                    <th>رقم الفاتورة</th>
                    <th>رمز الشحنة</th>
                    <th>رقم العضوية</th>
                    <th>الوزن</th>
                    <th>الوزن الحجمي</th>
                    <th>الحجم(CBM)</th>
                    <th>تكلفة الشحن</th>
                    <th>المدفوع</th>
                    <th>الحالة</th>
                </tr>
            </thead>
            <tbody>

                {{-- Start print shipments depends on receive place --}}
                @foreach($data->shipments[$place] as $invoice)

                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td><a href="{{ url('cp/shipping-invoices',$invoice->id) }}" target="_blank">{{ $invoice->id }}</a></td>
                        <td><bdi>{{ $invoice->shipment_code }}</bdi></td>
                        <td>
                            <a target="_blank" href="{{ url('cp/customers',$invoice->customer_id) }}">
                                {{ $invoice->customer->code }}
                            </a>
                        </td>
                        <td>kg<bdi>{{ $invoice->weight }}</bdi></td>
                        <td>kg<bdi>{{ $invoice->volumetric_weight }}</bdi></td>
                        <td>CBM<bdi>{{ $invoice->cubic_meter }}</bdi></td>
                        <td>{!! $invoice->total_cost() !!}</td>
                        <td>{!! $invoice->paid() !!}</td>
                        <td><bdi>{{ $invoice->getState() }}</bdi></td>
                    </tr>

                @endforeach
                {{-- End print shipments depends on receive place --}}


                {{-- Start print total cost by currencies depends on receive place --}}
                @foreach($data->cost_by_currencies[$place] as $cost)
                    <tr>
                        <td colspan="3">
                            <h5 class="mb-0">التكلفة : <b>{{ $cost['amount'] }}</b></h5>
                        </td>
                        <td colspan="4">
                            <h5 class="mb-0">العملة : <b>{{ $cost['currency'] }}</b></h5>
                        </td>
                        <td colspan="3">
                            <h5 class="mb-0">عدد الشحنات : <b>{{ $cost['count'] }}</b></h5>
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="10">
                        <h5 class="mb-0">إجمالي التكلفة بالعملة الرئيسية : <b>{{ $data->cost[$place] }} <bdi>{{ app_settings()->currency->name }}</bdi></b></h5>
                    </td>
                </tr>
                {{-- End print total cost by currencies depends on receive place --}}


                {{-- Start print total paid by currencies depends on receive place  --}}
                @foreach($data->paid_by_currencies[$place] as $paid)
                    <tr>
                        <td colspan="3">
                            <h5 class="mb-0">المدفوع : <b>{{ $paid['amount'] }}</b></h5>
                        </td>
                        <td colspan="4">
                            <h5 class="mb-0">العملة : <b>{{ $paid['currency'] }}</b></h5>
                        </td>
                        <td colspan="3">
                            <h5 class="mb-0">عدد الشحنات : <b>{{ $paid['count'] }}</b></h5>
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td colspan="10">
                        <h5 class="mb-0">إجمالي المدفوع بالعملة الرئيسية : <b>{{ $data->paid[$place] }} <bdi>{{ app_settings()->currency->name }}</bdi></b></h5>
                    </td>
                </tr>
                {{-- End print total paid by currencies depends on receive place --}}


                </tbody>
            </table>
        @endforeach



    </div>
    {{--  End items of trip  --}}



</div>



    @if(hasRole('trips_delete'))

        <!--    Start Modal deleteModal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">حذف رحلة</h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form class='formSendAjaxRequest' redirect-to='{{ url('/cp/trips') }}' refresh-seconds='2' action="{{ url('/cp/trips') }}"
                        method="post">
                        <div class="modal-body text-right">
                            <div class="formResult text-center"></div>
                            @method('DELETE')
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $trip->id }}" />
                            هل أنت متأكد أنك تريد حذف الرحلة ؟
                            <br/>
                            <b>ملاحظة</b> سيتم إلغاء ربط الشحنات بالرحلة في حالة حذفها
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">حذف</button>
                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--    End Modal deleteModal -->

    @endif


@endsection
