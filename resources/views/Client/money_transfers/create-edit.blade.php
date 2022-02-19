
@extends('Client.layouts.app')

@section('content')


    {{-- Start path --}}
    <div class="d-flex align-items-center justify-content-between mb-3">

        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb mb-0" style="background-color: transparent">
                <li class="breadcrumb-item"> 
                    <h4 class="mb-0">
                        <a class="text-decoration-none" href="{{ url('client/money-transfers') }}">حوالات مالية</a> 
                    </h4>
                </li>
                <li class="breadcrumb-item active text-truncate col pr-0 text-right" aria-current="page">
                    <h4 class="mr-1 mb-0 d-inline-block">{{ empty($transfer) ? 'حوالة جديدة' : $transfer->id }}</h4>
                </li>
            </ol>
        </nav>

    </div>
    {{-- End path --}}



<!--    Start header of Trip   -->
<form class="formSendAjaxRequest card card-shadow was-validated" id="form-transfer" focus-on="#form-transfer"
    refresh-seconds="1" upload-files="true" action="{{ url('client/money-transfers',(empty($transfer) ? '' : 'edit')) }}" method="POST">

    @csrf

    {{--   Start input fields  --}}
    <div class="card-header bg-white text-right">
        
        <div class="formResult my-3 text-center"></div>

        @isset($transfer->id)

            <div class="alert alert-warning text-right">الملف اتركه فارغ إذا لاتريد تغيره</div>

            <input type="hidden" name="id" value="{{ $transfer->id }}" />

        @endisset


        {{-- Start Country/City --}}
        <div class="row">

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputCountry" class="col-sm-auto w-125px col-form-label">البلد</label>
                    <div class="col-sm pr-md-0">
                        <select id="inputCountry" name="country" class="form-control" required>
                            <option value="" selected>...</option>
                            @foreach($countries as $country) 
                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputCity" class="col-sm-auto w-125px col-form-label">المدينة</label>
                    <div class="col-sm pr-md-0">
                        <select id="inputCity" name="city" class="form-control" required>
                            <option value="" selected>...</option>
                            @foreach($cities as $city) 
                                <option value="{{ $city->id }}" data-country="{{ $city->country_id }}">{{ $city->name }}</option>
                            @endforeach 
                        </select>
                    </div>
                </div>
            </div>

        </div>
        {{-- End Country/City --}}

        <hr/>

        {{-- Start Recipient info --}}
        <div class="row">

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputRecipient" class="col-sm-auto w-125px col-form-label">اسم المستلم</label>
                    <div class="col-sm pr-md-0">
                        <input id="inputRecipient" type="text" name="recipient" pattern="\s*([^\s]\s*){9,32}" class="form-control" required>
                        <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'الاسم','min'=> 9 ,'max'=>32])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputPhone" class="col-sm-auto w-125px pl-0 col-form-label">رقم الهاتف</label>
                    <div class="col-sm pr-md-0">
                        <input type="text" name="phone" id="inputPhone" class="form-control text-right" dir='ltr' placeholder="رقم هاتف المستلم" pattern="\s*([0-9\-\+]\s*){3,14}" required>
                        <div class="invalid-feedback text-center">@lang('validation.digits_between',['attribute'=>'رقم الهاتف','min'=> 3 ,'max'=>14])</div>
                    </div>
                </div> 
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputPhone2" class="col-sm-auto w-125px pl-0 col-form-label">رقم الهاتف2</label>
                    <div class="col-sm pr-md-0">
                        <input type="text" name="phone2" id="inputPhone2" class="form-control text-right" dir='ltr' placeholder="+XXX-XXXXXXXXX" pattern="\s*([0-9\-\+]\s*){3,14}">
                        <div class="invalid-feedback text-center">@lang('validation.digits_between',['attribute'=>'رقم الهاتف','min'=> 3 ,'max'=>14])</div>
                    </div>
                </div> 
            </div>

        </div>
        {{-- End Recipient info --}}

        <hr/>

        {{-- Start Recipient Type/File info --}}
        <div class="row">

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputRecipientType" class="col-sm-auto w-125px col-form-label">نوع المستلم</label>
                    <div class="col-sm pr-md-0">
                        <select id="inputRecipientType" name="recipient_type" class="form-control" required>
                            <option value="">...</option>
                            @foreach(trans('moneyTransfer.recipient_types') as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputCustomFile" class="col-sm-auto pl-0 w-125px col-form-label">إرفاق ملف</label>
                    <div class="col-sm pr-md-0">
                        <div class="custom-file">
                            <input type="file" name="file" class="custom-file-input" id="inputCustomFile" accept=".png,.jpg,.jpeg,.gif,.pdf,.xls" />
                            <label class="custom-file-label" for="inputCustomFile">اختر ملف</label>
                        </div>
                        <div class="invalid-feedback text-center">@lang("validation.mimes",[ "attribute"=>"","values" => "png,jpg,jpeg,gif,pdf,xls"])</div>        
                    </div>
                </div>
            </div>

        </div>
        {{-- End Recipient Type/File info --}}

        <hr/>

        {{-- Start data about money --}}
        <div class="row">

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputFeeOnRecipient" class="col-sm-auto w-125px col-form-label">العمولة على</label>
                    <div class="col-sm pr-md-0">
                        <select id="inputFeeOnRecipient" name="fee_on_recipient" class="form-control" required>
                            <option value="" selected>...</option>
                            @foreach(trans('moneyTransfer.fee_on') as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputCurrency" class="col-sm-auto w-125px col-form-label">العملة</label>
                    <div class="col-sm pr-md-0">
                        <select id="inputCurrency" name="currency" class="form-control" required>
                            <option value="" selected>...</option>
                            @foreach($currencies as $currency) 
                                <option value="{{ $currency->id }}" data-sign="{{ $currency->sign }}">{{ $currency->name }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            
            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputAmount" class="col-sm-auto w-125px col-form-label">المبلغ</label>
                    <div class="col-sm pr-md-0">
                        <input type="number" min="1" step="any" name="amount" id="inputAmount" class="form-control" required>
                        <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'المبلغ','min'=> 1])</div>
                    </div>
                </div>
            </div>

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputReceivingMethod" class="col-sm-auto pl-0 w-125px col-form-label">طريقة الاستلام</label>
                    <div class="col-sm pr-md-0">
                        <select id="inputReceivingMethod" name="receiving_method" class="form-control" required>
                            <option value="">...</option>
                            @foreach(trans('moneyTransfer.receiving_methods') as $key => $value)
                                <option value="{{ $key }}">{{ $value }}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

        </div>
        {{-- End data about money --}}

        <hr/>
        
        {{--    Start Account number --}}
        <div class="row">

            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputAccountNumber" class="col-sm-auto w-125px col-form-label">رقم الحساب</label>
                    <div class="col-sm pr-md-0">
                        <input id="inputAccountNumber" name="account_number" type="text" pattern="\s*([^\s]\s*){3,32}" class="form-control" required>
                        <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'رقم الحساب','min'=> 3 ,'max'=>32])</div>
                    </div>
                </div>
            </div>
    
            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                    <label for="inputAccountNumber2" class="col-sm-auto w-125px col-form-label">رقم الحساب 2</label>
                    <div class="col-sm pr-md-0">
                        <input id="inputAccountNumber2" name="account_number2" type="text" pattern="\s*([^\s]\s*){3,32}" class="form-control" />
                        <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'رقم الحساب','min'=> 3 ,'max'=>32])</div>
                    </div>
                </div>
            </div>
    
            <div class="col-md-6 col-lg-4">
                <div class="form-group row">
                        <label for="inputAccountNumber3" class="col-sm-auto pl-0 w-125px col-form-label">رقم الحساب 3</label>
                        <div class="col-sm pr-md-0">
                        <input id="inputAccountNumber3" name="account_number3" type="text" pattern="\s*([^\s]\s*){3,32}" class="form-control" />
                        <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'رقم الحساب','min'=> 3 ,'max'=>32])</div>
                    </div>
                </div>
            </div>

        </div>
        {{--    End Account number --}}

    </div>
    {{--  End input fields  --}}
 

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


@section('extra-js')

    <script>
        
        {{-- /* Start country events */ --}}
        $('#inputCountry').change(function () {
            /* When user change country show only cities that exist in current country */
            $('#inputCity').val('');
            if ($(this).val()) {
                $('#inputCity').find('option').hide().filter('[data-country="' + $(this).val() + '"] ,[value=""]').show();
            } else {
                $('#inputCity').find('option').hide().filter('[value=""]').show();
            }
        });
        $('#inputCountry').change(); /* to show only related citites for selected country */
        {{-- /* End country events */ --}}

        
        {{-- /* Start events to controll in Receiving Method */ --}}
        $('#inputReceivingMethod').change(function () {
            $('input[name^=account_number]').prop('disabled', $(this).val() != 2); {{-- /*  check if receiving method is on bank */ --}}
        });
        {{-- /* End events to controll in Receiving Method */ --}}


        {{-- /* Set data if this form works as edit  */ --}}
        @isset($transfer)

            $('#inputCountry').val("{{ $transfer->country_id }}").change();
            $('#inputCity').val("{{ $transfer->city_id }}");
            $('#inputRecipient').val({!! json_encode($transfer->recipient) !!});
            $('#inputPhone').val({!! json_encode($transfer->phone) !!});
            $('#inputPhone2').val({!! json_encode($transfer->phone2) !!});
            $('#inputRecipientType').val("{{ $transfer->recipient_type }}");
            $('#inputFeeOnRecipient').val("{{ $transfer->fee_on_recipient }}");
            $('#inputReceivingMethod').val("{{ $transfer->receiving_method }}").change();
            $('#inputCurrency').val("{{ $transfer->currency_type_id }}");
            $('#inputAmount').val("{{ $transfer->amount }}");
            $('#inputAccountNumber').val({!! json_encode($transfer->account_number) !!});
            $('#inputAccountNumber2').val({!! json_encode($transfer->account_number2) !!});
            $('#inputAccountNumber3').val({!! json_encode($transfer->account_number3) !!});

        @endisset

    </script>

@endsection