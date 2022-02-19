
@extends('CP.layouts.header-footer')

@section('content')


<!--  Start path  -->
<nav aria-label="breadcrumb" role="navigation">
    <ol class="breadcrumb bg-white">
        <li class="breadcrumb-item">
            <a href="{{ url('cp/trips') }}">الرحلات</a>
        </li>
        <li class="breadcrumb-item active text-truncate col pr-0 text-right" aria-current="page">
            <span class="mr-1">رحلة جديدة</span>
        </li>
    </ol>
</nav>
<!--  End path  -->



<!--    Start header of Trip   -->
<form class="formSendAjaxRequest card card-shadow was-validated" id="form-invoice" focus-on="#form-invoice"
    refresh-seconds="1" action="{{ url('cp/trips') }}" method="POST">

    @csrf

    {{--   Start header data of Trip  --}}
    <div class="card-header bg-white">

        <div class="formResult my-3 text-center"></div>


        <div class="row">

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputTripNumber" class="col-auto w-125px col-form-label text-right">رقم الرحلة</label>
                    <div class="col pr-md-0">
                        <input id="inputTripNumber" type="text" pattern="\s*([^\s]\s*){1,32}" class="form-control" name="trip_number" required>
                        <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'رقم الرحلة','min'=> 1 ,'max'=>32])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputTrackNumber" class="col-auto w-125px col-form-label text-right">رقم التتبع</label>
                    <div class="col pr-md-0">
                        <input id="inputTrackNumber" type="text" pattern="\s*([^\s]\s*){3,32}" class="form-control" name="tracking_number" required>
                        <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'رقم التتبع','min'=> 3 ,'max'=>32])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputState" class="col-auto w-125px col-form-label text-right">الحالة</label>
                    <div class="col pr-md-0">
                        <select id="inputState" name="state" class="form-control" required>
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
                        <input type="date" max="{{ date('Y-m-d') }}" name="exit_at" id="inputExitAt" class="form-control checkDate" checkDateTarget="#inputArrivedAt , #inputEstimatedArriveAt" required>
                        <div class="invalid-feedback text-center">@lang('validation.before_or_equal',['attribute'=>'تاريخ الخروج','date'=> date('d/m/Y')])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputEstimatedArriveAt" class="col-auto w-125px col-form-label text-right">تاريخ الوصول المتوقع</label>
                    <div class="col pr-md-0">
                        <input type="date" name="estimated_arrive_at" id="inputEstimatedArriveAt" class="form-control">
                        <div class="invalid-feedback text-center">@lang('validation.after_or_equal',['attribute'=>'تاريخ الوصول','date'=> 'الخروج'])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputArrivedAt" class="col-auto w-125px col-form-label text-right">تاريخ الوصول الفعلي</label>
                    <div class="col pr-md-0">
                        <input type="date" name="arrived_at" id="inputArrivedAt" class="form-control">
                        <div class="invalid-feedback text-center">@lang('validation.after_or_equal',['attribute'=>'تاريخ الوصول','date'=> 'الخروج'])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputCurrency" class="col-auto w-125px col-form-label text-right">العملة</label>
                    <div class="col pr-md-0">
                        <select id="inputCurrency" name="currency" class="form-control setValue" required>
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
                        <input type="number" min="0.000001" max="999999.00" step="any" name="exchange_rate" id="inputExchangeRate" class="form-control" required>
                        <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'سعر الصرف','min'=> 0.0001])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputCost" class="col-auto w-125px col-form-label text-right">التكلفة</label>
                    <div class="col pr-md-0">
                        <input type="number" min="0" step="any" name="cost" id="inputCost" class="form-control" required>
                        <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'التكلفة','min'=> 0])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputWeight" class="col-auto w-125px col-form-label text-right">الوزن الكلي</label>
                    <div class="col pr-md-0">
                        <input id="inputWeight" type="text" pattern="\s*([^\s]\s*){3,32}" class="form-control" name="weight" required>
                        <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'الوزن','min'=> 3 ,'max'=>32])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputCompany" class="col-auto w-125px col-form-label text-right">الشركة</label>
                    <div class="col pr-md-0">
                        <select id="inputCompany" name="company" class="form-control" required>
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
                            <select id="inputAddress" name="address" class="custom-select" required>
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
                        <textarea name="state_desc" id="inputStateDesc" maxlength="150" rows="4" class="form-control" placeholder="وصف حالة الرحلة"></textarea>
                        <div class="invalid-feedback text-center">@lang('validation.max.string',['attribute'=>'الوصف','max'=>150])</div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="form-group row">
                    <label for="inputExtra" class="col-auto w-125px col-form-label text-right">أخرى</label>
                    <div class="col pr-md-0">
                        <textarea name="extra" id="inputExtra" maxlength="150" rows="4" class="form-control" placeholder="معلومات إضافية خاصة بالنظام"></textarea>
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

                {{--  I will add first row using js to skip repate loop types(Items Types)  --}}

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
