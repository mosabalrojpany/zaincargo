
@extends('CP.layouts.header-footer')

@section('content')



    <!--  Start path  -->
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item">
                <a href="{{ url('cp/shipping-invoices') }}">الشحنات</a>
            </li>
            <li class="breadcrumb-item active text-truncate col pr-0 text-right" aria-current="page">
                <span class="mr-1">{{ empty($invoice) ? 'شحنة جديدة' : $invoice->id }}</span>
            </li>
        </ol>
    </nav>
    <!--  End path  -->




<!--    Start header of Invoice   -->
<form class="card card-shadow was-validated" id="form-invoice" action="{{ url('cp/shipping-invoices',(empty($invoice) ? '' : 'edit')) }}" >
    @csrf
    @isset($invoice->id)

        <input type="hidden" name="id" value="{{ $invoice->id }}" />

    @endisset

    {{--   Start header data of Invoice  --}}
    <div class="card-header bg-white">

        <div class="formResult my-3 text-center"></div>


        <div class="row">

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputCode" class="col-auto w-125px col-form-label text-right">رقم العضوية</label>
                    <div class="col pr-md-0">
                        <input id="inputCode" type="number" min="1" class="form-control" name="code" required>
                        <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'رقم العضوية','min'=> 1])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputTrackNumber" class="col-auto w-125px col-form-label text-right">رقم التتبع</label>
                    <div class="col pr-md-0">
                        <input id="inputTrackNumber" type="text" pattern="\s*([^\s]\s*){3,64}" class="form-control" name="tracking_number" required>
                        <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'رقم التتبع','min'=> 3 ,'max'=>64])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputShipmentCode" class="col-auto w-125px col-form-label text-right">رمز الشحنة</label>
                    <div class="col pr-md-0">
                        <input id="inputShipmentCode" type="text" pattern="\s*([^\s]\s*){3,32}" class="form-control" name="shipment_code" required>
                        <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'رمز الشحنة','min'=> 3 ,'max'=>32])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputAddress" class="col-auto w-125px col-form-label text-right">العنوان</label>
                    <div class="col pr-md-0">
                        <select id="inputAddress" name="address" class="form-control setValue" required>
                            <option value="">...</option>
                            @foreach($addresses as $address)
                                <option value="{{ $address->id }}">{{ $address->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputRecevingPlace" class="col-auto w-125px col-form-label text-right">تسليم في</label>
                    <div class="col pr-md-0">
                        <select id="inputRecevingPlace" name="receving_place" class="form-control setValue" required>
                            <option value="">...</option>
                            @foreach($receivingPlaces as $place)
                                <option value="{{ $place->id }}">{{ $place->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4"></div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputLength" class="col-auto w-125px col-form-label text-right">الطول</label>
                    <div class="col pr-md-0">
                        <div class="input-group mb-3">
                            <input type="number" min="0.1" value="1" step="any" name="length" id="inputLength" class="form-control" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'الطول','min'=> 0.1])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputWidth" class="col-auto w-125px col-form-label text-right">العرض</label>
                    <div class="col pr-md-0">
                        <div class="input-group mb-3">
                            <input type="number" min="0.1" value="1" step="any" name="width" id="inputWidth" class="form-control" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'العرض','min'=> 0.1])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputHeight" class="col-auto w-125px col-form-label text-right">الارتفاع</label>
                    <div class="col pr-md-0">
                        <div class="input-group mb-3">
                            <input type="number" min="0.1" value="1" step="any" name="height" id="inputHeight" class="form-control" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text">cm</span>
                            </div>
                        </div>
                        <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'الارتفاع','min'=> 0.1])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label class="col-auto w-125px col-form-label text-right">الحجم</label>
                    <div class="col pr-md-0">
                        <div class="input-group mb-3">
                            <input type="text" id="inputCubicMeter" class="form-control" readonly>
                            <div class="input-group-prepend">
                                <span class="input-group-text">CBM</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label class="col-auto w-125px col-form-label text-right">الوزن الحجمي</label>
                    <div class="col pr-md-0">
                        <div class="input-group mb-3">
                            <input type="text" id="inputVolumetricWeight" class="form-control" readonly>
                            <div class="input-group-prepend">
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputWeight" class="col-auto w-125px col-form-label text-right">الوزن</label>
                    <div class="col pr-md-0">
                        <div class="input-group mb-3">
                            <input type="number" min="0.001" step="any" name="weight" id="inputWeight" class="form-control" required>
                            <div class="input-group-prepend">
                                <span class="input-group-text">kg</span>
                            </div>
                        </div>
                        <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'الوزن','min'=> 0.001])</div>
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
                        <input type="number" min="0.000001" max="999999.00" step="any" value="0" name="exchange_rate" id="inputExchangeRate" class="form-control" required>
                        <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'سعر الصرف','min'=> 0.0001])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputAdditionalCost" class="col-auto w-125px pl-0 col-form-label text-right">تكاليف إضافية</label>
                    <div class="col pr-md-0">
                        <input type="number" min="0" value="0" step="any" name="additional_cost" id="inputAdditionalCost" class="form-control" required>
                        <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'التكاليف الإضافية','min'=> 0])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputCost" class="col-auto w-125px col-form-label text-right">التكلفة</label>
                    <div class="col pr-md-0">
                        <div class="input-group">
                            <input type="number" min="0" step="any" name="cost" id="inputCost" class="form-control" required>
                            <div class="input-group-append">
                                <button class="btn btn-primary" id="buttonCost" type="button"><i class="fa fa-calculator"></i></button>
                            </div>
                        </div>
                        <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'التكلفة','min'=> 0])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputInsurance" class="col-auto w-125px col-form-label text-right">قيمة الشحنة</label>
                    <div class="col pr-md-0">
                        <input type="number" min="0" id="inputInsurance" value="0" step="any" name="Insurance" class="form-control" required>
                    </div>
                    <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'قيمة الشحنة','min'=> 0])</div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label class="col-auto w-125px col-form-label text-right">الإجمالي</label>
                    <div class="col pr-md-0">
                        <input type="text" id="inputSumTotal" readonly class="form-control">
                    </div>
                </div>
            </div>


            @if(isset($invoice) && $invoice->trip_id && $invoice->trip->state == 3)

                <div class="col-md-6 col-lg-4"></div>

                <div class="col-md-6 col-lg-4">
                    <div class="form-group row">
                        <label for="inputPaymentCurrency" class="col-auto w-125px col-form-label text-right">عملة الدفع</label>
                        <div class="col pr-md-0">
                            <select id="inputPaymentCurrency" name="payment_curreny" class="form-control setValue" required>
                                <option value="" selected>...</option>
                                @foreach($currencies as $currency)
                                    <option value="{{ $currency->id }}" data-value="{{ $currency->value }}">{{ $currency->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="form-group row">
                        <label for="inputPaidExchangeRate" class="col-auto w-125px pl-0 col-form-label text-right">سعر الصرف</label>
                        <div class="col pr-md-0">
                            <input type="number" min="0.000001" max="999999.00" step="any" value="0" name="paid_exchange_rate" id="inputPaidExchangeRate" class="form-control" required>
                            <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'سعر الصرف','min'=> 0])</div>
                        </div>
                    </div>
                </div>

                <div class="col-md-6 col-lg-4">
                    <div class="form-group row">
                        <label for="inputPaidUp" class="col-auto w-125px pl-0 col-form-label text-right">المدفوع</label>
                        <div class="col pr-md-0">
                            <input type="number" min="0" value="0" step="any" name="paid_up" id="inputPaidUp" class="form-control" required>
                            <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'المدفوع','min'=> 0])</div>
                        </div>
                    </div>
                </div>

            @endif

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputArrivedAt" class="col-auto w-125px col-form-label text-right">تاريخ الاستلام</label>
                    <div class="col pr-md-0">
                        <input type="date" max="{{ date('Y-m-d') }}" name="arrived_at" id="inputArrivedAt" class="form-control checkDate" checkDateTarget="#inputReceivedAt" required>
                        <div class="invalid-feedback text-center">@lang('validation.before_or_equal',['attribute'=>'تاريخ الاستلام','date'=> date('d/m/Y')])</div>
                    </div>
                </div>
            </div>

            {{-- if shipment is not related to trip , so user can not insert received at date --}}
            <div class="col-md-6 col-lg-4">
                @if(isset($invoice) && $invoice->trip_id && $invoice->trip->state == 3)
                    <div class="form-group row">
                        <label for="inputReceivedAt" class="col-auto w-125px col-form-label text-right">تاريخ التسليم</label>
                        <div class="col pr-md-0">
                            <input type="date" max="{{ date('Y-m-d') }}" min={{ $invoice->arrived_at() }} name="received_at" id="inputReceivedAt" class="form-control">
                            <div class="invalid-feedback text-center">@lang('validation.before_or_equal',['attribute'=>'تاريخ التسليم','date'=> 'الاستلام'])</div>
                        </div>
                    </div>
                @endif
            </div>

            <div class="col-md-6 col-lg-4"></div>

            <div class="col-6">
                <div class="form-group row">
                    <label for="inputNote" class="col-auto w-125px col-form-label text-right">ملاحظة</label>
                    <div class="col pr-md-0">
                        <textarea name="note" id="inputNote" maxlength="150" rows="4" class="form-control" placeholder="ملاحظة لزبون"></textarea>
                        <div class="invalid-feedback text-center">@lang('validation.max.string',['attribute'=>'ملاحظة','max'=>150])</div>
                    </div>
                </div>
            </div>

            <div class="col-6">
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
    {{--  End header data of Invoice  --}}


    {{--  Start Items of Invoice  --}}
    <div class="card-body p-0">

        <h4 class="text-center bg-primary text-white p-2 mt-0 mb-4">صور الشحنات</h4>

        <div class="container">

            <div class="row" id="imgs-container">

                <div class="col-auto mb-4">
                    <div class="image-upload" change-default-image="no">
                        <label class="m-0 img-box avatar-invoice-item">
                            <img src="{{ url('images/upload-img.png') }}" default-img="{{ url('images/upload-img.png') }}" class="img-thumbnail w-100 h-100">
                        </label>
                        <input class="form-control img-input" id="main-img-uploder" type="file" multiple accept=".png,.jpg,.gif">
                    </div>
                </div>

            </div>

        </div>

    </div>
    {{--  End Items of Invoice  --}}



    <!--    Start footer    -->
    <div class="card-footer d-flex align-items-center justify-content-between">
        {{-- <div class="form-group mb-0 pr-4">
            <div class="custom-control custom-checkbox">
                <input type="checkbox" class="custom-control-input" id="customControlIamSure" required>
                <label class="custom-control-label" for="customControlIamSure">أنا متأكد من الفاتورة</label>
            </div>
        </div>  --}}

        @isset($invoice)
            <div>
                <span><i class="fa fa-user ml-1"></i> {{ $invoice->user->name }}</span>
                <span class="mr-3" title="{{ $invoice->created_at->format('Y-m-d g:ia') }}"><i class="far fa-clock ml-1"></i>{{ $invoice->created_at->diffForHumans() }}</span>
            </div>
        @endisset

        <button type="submit" class="btn btn-primary w-125px mr-auto">حفظ</button>
    </div>
    <!--    End footer    -->


</form>
<!--    End header of Invoice   -->



@endsection


@section('extra-js')


@include('CP.shipping_invoices.create-edit-js')

    <script>

        var main_currency = {{ app_settings()->currency_type_id }}

        {{-- /* Set default value of exchange_rate depends on selected currency for cost */ --}}
        $('#inputCurrency').change(function(){
            var selected_currency = $(this).find('option:selected');
            var exchange_rate_input =  $('#inputExchangeRate');
            if(main_currency == selected_currency.val()){
                exchange_rate_input.val(1).prop("readonly", true);
            }
            else
            {
                exchange_rate_input.val(selected_currency.data('value')).prop("readonly", false);
            }
        })

        {{-- /* Set default value of exchange_rate depends on selected currency for payment */ --}}
        $('#inputPaymentCurrency').change(function(){
            var selected_currency = $(this).find('option:selected');
            var exchange_rate_input =  $('#inputPaidExchangeRate');
            if(main_currency == selected_currency.val()){
                exchange_rate_input.val(1).prop("readonly", true);
            }
            else
            {
                exchange_rate_input.val(selected_currency.data('value')).prop("readonly", false);
            }
        })

        {{-- /* Disable/enable payments inputs depends on received_at date */ --}}
        $('#inputReceivedAt').change(function(){
            var requried = !$(this).val();
            $('#inputPaymentCurrency ,#inputPaidUp ,#inputPaidExchangeRate').attr('disabled',requried);
        });

        {{-- /* to know if this view works as Add or Edit , I will need it in Add operation becuase I will refresh page and not go to show invoice like edit */ --}}
        var worksAsAdd = {{ isset($invoice->id) ? 'false' : 'true' }};

        {{-- /* Calculate Total cost */ --}}
        $('#inputCost, #inputAdditionalCost, #inputInsurance').change(function(){
            var cost = Number($('#inputCost').val());
            var additional_cost = Number($('#inputAdditionalCost').val());
            $('#inputSumTotal').val(number_format(cost + additional_cost));
        });


        {{-- /* Calculate Volumetric Weight and Cubic Meter */ --}}
        $('#inputLength, #inputWidth, #inputHeight').change(function(){
            var length = Number($('#inputLength').val());
            var width = Number($('#inputWidth').val());
            var height = Number($('#inputHeight').val());

            var cubic_centimeter = length * width * height;

            $('#inputVolumetricWeight').val(number_format(cubic_centimeter / 5000,3))
            $('#inputCubicMeter').val(number_format(cubic_centimeter / 1000000,2));
        });


        {{-- /* Set data if this form works as edit  */ --}}
        @isset($invoice)

            @foreach($invoice->items as $item)

                addImage(getRandomId(), "{{ $item->getImageAvatar() }}", {{ $item->id }})

            @endforeach

            $('#inputCode').val(strip_tags("{{ str_replace(get_customer_code_starts_with(), '', $invoice->customer->code) }}"));
            $('#inputTrackNumber').val(strip_tags("{{ $invoice->tracking_number }}"));
            $('#inputShipmentCode').val(strip_tags("{{ $invoice->shipment_code }}"));

            $('#inputAddress').val("{{ $invoice->address_id }}").change();
            $('#inputRecevingPlace').val("{{ $invoice->receive_in }}").change();

            $('#inputCurrency').val("{{ $invoice->currency_type_id }}").change();
            $('#inputPaymentCurrency').val("{{ $invoice->payment_currency_type_id }}").change();

            $('#inputLength').val("{{ $invoice->length }}");
            $('#inputWidth').val("{{ $invoice->width }}");
            $('#inputHeight').val("{{ $invoice->height }}").change();
            $('#inputWeight').val("{{ $invoice->weight }}");
            $('#inputAdditionalCost').val("{{ $invoice->additional_cost }}");
            $('#inputCost').val("{{ $invoice->cost }}").change();
            $('#inputInsurance').val("{{ $invoice->Insurance }}");
            $('#inputExchangeRate').val("{{ $invoice->exchange_rate }}");
            $('#inputPaidExchangeRate').val("{{ $invoice->paid_exchange_rate }}");
            $('#inputPaidUp').val("{{ $invoice->paid_up }}");
            $('#inputArrivedAt').val("{{ $invoice->arrived_at() }}");
            $('#inputReceivedAt').val("{{ $invoice->received_at() }}").change();
            $('#inputNote').val({!! json_encode($invoice->note) !!});
            $('#inputExtra').val({!! json_encode($invoice->extra) !!});

        @endisset


        {{-- /* Start get estimated cost for shipment */  --}}
        var inputAddress = $('#inputAddress')[0];
        var inputCurrency = $('#inputCurrency')[0];
        var inputLength = $('#inputLength')[0];
        var inputWidth = $('#inputWidth')[0];
        var inputHeight = $('#inputHeight')[0];
        var inputWeight = $('#inputWeight')[0];
        var inputInsurance = $('#inputInsurance')[0];

        {{-- /* When user click to estimate cost */  --}}
        $('#buttonCost').click(function(){

            if (!inputAddress.reportValidity() || !inputCurrency.reportValidity() || !inputLength.reportValidity() || !inputWidth.reportValidity() || !inputHeight.reportValidity() || !inputWeight.reportValidity() || !inputInsurance.reportValidity()) {
                return false;
            }

            var formResult = $(this).closest('form').find('.formResult');
            formResult.html('<div class="loader"><label class="loader-shape mb-3"></label></div>');

            var btnCost = this;
            $(btnCost).attr('disabled', 'disabled');

            var paramters = {
                address: inputAddress.value,
                currency: inputCurrency.value,
                length: inputLength.value,
                width: inputWidth.value,
                height: inputHeight.value,
                weight: inputWeight.value,
                Insurance: inputInsurance.value,
            };

            $.ajax({
                url: "{{ url('api/calculate-shipping-cost') }}",
                dataType: 'json',
                data : paramters,
                method: 'GET',
            })
            .done(function (result) { /* Form seneded success without any error */

                formResult.html('');
                $('#inputCost').val(result.cost).change();

            })
            .fail(function (result) { /* There is error in send form or in server-side */

                try {
                    var errorString = '<div class="alert alert-danger alert-dismissible text-right fade show role="alert"><ul class="mb-0">';
                    var response = JSON.parse(result.responseText);
                    if (response.errors) {
                        $.each(response.errors, function (key, value) {
                            $.each(value, function (k, v) {
                                errorString += '<li>' + v + '</li>';
                            });
                        });
                    }
                    else {
                        errorString += '<li>حدث خطأ</li>';
                        console.error(response.message);
                    }
                } catch (e) {
                    errorString += '<li>حدث خطأ يرجى التأكد من اتصالك بالإنترنت وإعادة المحاولة</li>';
                } finally {
                    errorString += '</ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                    formResult.html(errorString);
                }

            })
            .always(function () {

                $(btnCost).removeAttr('disabled');

            });

        });
        {{-- /* End get estimated cost for shipment */  --}}

    </script>

@endsection
