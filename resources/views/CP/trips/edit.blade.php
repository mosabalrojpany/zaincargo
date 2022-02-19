
@extends('CP.layouts.header-footer')

@section('content')


<!--  Start path  -->
<nav aria-label="breadcrumb" role="navigation">
    <ol class="breadcrumb bg-white">
        <li class="breadcrumb-item">
            <a href="{{ url('cp/trips') }}">الرحلات</a>
        </li>
        <li class="breadcrumb-item active text-truncate col pr-0 text-right" aria-current="page">
            <span class="mr-1">{{ $trip->id }}</span>
        </li>
    </ol>
</nav>
<!--  End path  -->



<!--    Start header of Trip   -->
<form class="formSendAjaxRequest card card-shadow was-validated" id="form-invoice" focus-on="#form-invoice"
    refresh-seconds="1" action="{{ url('cp/trips/edit') }}" method="POST">

    @csrf

    <input type="hidden" name="id" value="{{ $trip->id }}" />

    {{--   Start header data of Trip  --}}
    <div class="card-header bg-white">

        <div class="formResult my-3 text-center"></div>


        <div class="row">

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputTripNumber" class="col-auto w-125px col-form-label text-right">رقم الرحلة</label>
                    <div class="col pr-md-0">
                        <input id="inputTripNumber" type="text" value="{{ $trip->trip_number }}" pattern="\s*([^\s]\s*){1,32}" class="form-control" name="trip_number" required>
                        <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'رقم الرحلة','min'=> 1 ,'max'=>32])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputTrackNumber" class="col-auto w-125px col-form-label text-right">رقم التتبع</label>
                    <div class="col pr-md-0">
                        <input id="inputTrackNumber" type="text" value="{{ $trip->tracking_number }}" pattern="\s*([^\s]\s*){3,32}" class="form-control" name="tracking_number" required>
                        <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'رقم التتبع','min'=> 3 ,'max'=>32])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputState" class="col-auto w-125px col-form-label text-right">الحالة</label>
                    <div class="col pr-md-0">
                        <select id="inputState" name="state" value="{{ $trip->state }}" class="form-control setValue" required>
                            <option value="">...</option>
                            @foreach($status as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputExitAt" class="col-auto w-125px col-form-label text-right">تاريخ الخروج</label>
                    <div class="col pr-md-0">
                        <input type="date" max="{{ date('Y-m-d') }}" value="{{ $trip->exit_at() }}" name="exit_at" id="inputExitAt" class="form-control checkDate" checkDateTarget="#inputArrivedAt , #inputEstimatedArriveAt" required>
                        <div class="invalid-feedback text-center">@lang('validation.before_or_equal',['attribute'=>'تاريخ الخروج','date'=> date('d/m/Y')])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputEstimatedArriveAt" class="col-auto w-125px col-form-label text-right">تاريخ الوصول المتوقع</label>
                    <div class="col pr-md-0">
                        <input type="date" name="estimated_arrive_at" value="{{ $trip->estimated_arrive_at() }}" id="inputEstimatedArriveAt" class="form-control">
                        <div class="invalid-feedback text-center">@lang('validation.after_or_equal',['attribute'=>'تاريخ الوصول','date'=> 'الخروج'])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputArrivedAt" class="col-auto w-125px col-form-label text-right">تاريخ الوصول الفعلي</label>
                    <div class="col pr-md-0">
                        <input type="date" name="arrived_at" value="{{ $trip->arrived_at() }}" id="inputArrivedAt" class="form-control">
                        <div class="invalid-feedback text-center">@lang('validation.after_or_equal',['attribute'=>'تاريخ الوصول','date'=> 'الخروج'])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputCurrency" class="col-auto w-125px col-form-label text-right">العملة</label>
                    <div class="col pr-md-0">
                        <select id="inputCurrency" name="currency" value="{{ $trip->currency_type_id }}"  class="form-control setValue" required>
                            <option value="" selected disabled>...</option>
                            @foreach($currencies as $currency)
                                <option value="{{ $currency->id }}" data-value="{{ $currency->value }}">{{ $currency->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputExchangeRate" class="col-auto w-125px pl-0 col-form-label text-right">سعر الصرف</label>
                    <div class="col pr-md-0">
                        <input type="number" min="0.000001" max="999999.00" step="any" value="{{ $trip->exchange_rate }}"  name="exchange_rate" id="inputExchangeRate" class="form-control" required>
                        <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'سعر الصرف','min'=> 0.0001])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputCost" class="col-auto w-125px col-form-label text-right">التكلفة</label>
                    <div class="col pr-md-0">
                        <input type="number" min="0" step="any" value="{{ $trip->cost }}" name="cost" id="inputCost" class="form-control" required>
                        <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'التكلفة','min'=> 0])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputWeight" class="col-auto w-125px col-form-label text-right">الوزن الكلي</label>
                    <div class="col pr-md-0">
                        <input id="inputWeight" type="text" value="{{ $trip->weight }}" pattern="\s*([^\s]\s*){3,32}" class="form-control" name="weight" required>
                        <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'الوزن','min'=> 3 ,'max'=>32])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputCompany" class="col-auto w-125px col-form-label text-right">الشركة</label>
                    <div class="col pr-md-0">
                        <select id="inputCompany" name="company" value="{{ $trip->company_id }}" class="form-control setValue" required>
                            <option value="">...</option>
                            @foreach($companies as $company)
                                <option value="{{ $company->id }}">{{ $company->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputAddress" class="col-auto w-125px col-form-label text-right">العنوان</label>
                    <div class="col pr-md-0">
                        <div class="input-group">
                            <select id="inputAddress" name="address" value="{{ $trip->address_id }}" class="custom-select setValue" required>
                                <option value="">...</option>
                                @foreach($addresses as $address)
                                    <option value="{{ $address->id }}">{{ $address->name }}</option>
                                @endforeach
                            </select>
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="buttonAddress" type="button"><i class="fa fa-search"></i></button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>


            <div class="col-md-6 col-lg-8"></div>

            <div class="col-lg-6">
                <div class="form-group row">
                    <label for="inputStateDesc" class="col-auto w-125px col-form-label text-right">وصف الحالة</label>
                    <div class="col pr-md-0">
                        <textarea name="state_desc" id="inputStateDesc" maxlength="150" rows="4" class="form-control" placeholder="وصف حالة الرحلة">{{ $trip->state_desc }}</textarea>
                        <div class="invalid-feedback text-center">@lang('validation.max.string',['attribute'=>'الوصف','max'=>150])</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group row">
                    <label for="inputExtra" class="col-auto w-125px col-form-label text-right">أخرى</label>
                    <div class="col pr-md-0">
                        <textarea name="extra" id="inputExtra" maxlength="150" rows="4" class="form-control" placeholder="معلومات إضافية خاصة بالنظام">{{ $trip->extra }}</textarea>
                        <div class="invalid-feedback text-center">@lang('validation.max.string',['attribute'=>'معلومات أخرى','max'=>150])</div>
                    </div>
                </div>
            </div>

        </div>

    </div>
    {{--  End header data of Trip  --}}


    {{--  Start Items of Trip  --}}
    <div class="card-body">

        <table class="table text-center" id="tableInvoices">
            <thead>
                <tr>
                    <th>#</th>
                    <th>
                        <div class="form-group mb-0 pr-4">
                            <div class="custom-control custom-checkbox">
                                <input type="checkbox" class="custom-control-input" id="checkBoxSelectAll">
                                <label class="custom-control-label text-dark" for="checkBoxSelectAll">رقم الفاتورة</label>
                            </div>
                        </div>
                    </th>
                    <th>رقم التتبع</th>
                    <th>رمز الشحنة</th>
                    <th>رقم العضوية</th>
                    <th>تاربخ الإضافة</th>
                    <th>تاربخ الاستلام</th>
                    <th>عرض الفاتورة</th>
                </tr>
            </thead>
            <tbody>

                @foreach($trip->shortInvoices as $invoice)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>
                            <div class="form-group mb-0 pr-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="invoices[]" value="{{ $invoice->id }}" checked class="custom-control-input" id="customControInvoiceOld{{ $loop->iteration }}">
                                    <label class="custom-control-label" for="customControInvoiceOld{{ $loop->iteration }}">{{ $invoice->id }}</label>
                                </div>
                            </div>
                        </td>
                        <td>{{ $invoice->tracking_number }}</td>
                        <td>{{ $invoice->shipment_code }}</td>
                        <td>
                            <a target="_blank" href="{{ url('cp/customers',$invoice->customer_id) }}">
                                {{ $invoice->customer_code }}
                            </a>
                        </td>
                        <td><bdi>{{ $invoice->created_at() }}</bdi></td>
                        <td><bdi>{{ $invoice->arrived_at() }}</bdi></td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" target="_blank" href="{{ url('cp/shipping-invoices',$invoice->id) }}">
                                <i class="fas fa-binoculars"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach

                <tr>
                    <td class="bg-secondary text-white" colspan="8">
                        الفواتير التي يمكن إضافتها
                    </td>
                </tr>

                @foreach($invoices as $invoice)
                    <tr>
                        <th>{{ $loop->iteration }}</th>
                        <td>
                            <div class="form-group mb-0 pr-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="invoices[]" value="{{ $invoice->id }}" class="custom-control-input" id="customControInvoiceNew{{ $loop->iteration }}">
                                    <label class="custom-control-label" for="customControInvoiceNew{{ $loop->iteration }}">{{ $invoice->id }}</label>
                                </div>
                            </div>
                        </td>
                        <td>{{ $invoice->tracking_number }}</td>
                        <td>{{ $invoice->shipment_code }}</td>
                        <td>
                            <a target="_blank" href="{{ url('cp/customers',$invoice->customer_id) }}">
                                {{ $invoice->customer_code }}
                            </a>
                        </td>
                        <td><bdi>{{ $invoice->created_at() }}</bdi></td>
                        <td><bdi>{{ $invoice->arrived_at() }}</bdi></td>
                        <td>
                            <a class="btn btn-sm btn-outline-primary" target="_blank" href="{{ url('cp/shipping-invoices',$invoice->id) }}">
                                <i class="fas fa-binoculars"></i>
                            </a>
                        </td>
                    </tr>
                @endforeach

            </tbody>
        </table>

    </div>
    {{--  End Items of Trip  --}}



    <!--    Start footer    -->
    <div class="card-footer d-flex align-items-center justify-content-between">
        <div class="form-group mb-0 pr-4">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="customControlIamSure" required>
                <label class="custom-control-label" for="customControlIamSure">أنا متأكد</label>
            </div>
        </div>
        <button type="submit" class="btn btn-primary w-125px">حفظ</button>
    </div>
    <!--    End footer    -->


</form>
<!--    End header of Trip   -->



@endsection


{{--   this line will get value using laravl  --}}
@include('CP.trips.create-edit-js')
