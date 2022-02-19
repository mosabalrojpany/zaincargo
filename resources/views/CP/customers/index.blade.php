@extends('CP.layouts.header-footer')
@section('content')
    


    
    <!--    show errors if there is error    -->
    @include('layouts.errors')



    
    <!--    Start header    -->
    <div class="d-flex justify-content-between">
        <h4 class="font-weight-bold">الزبائن {{ $customers->total() }}</h4>

        @if(hasRole('customers_add'))
            <button class="btn btn-primary w-100px" data-toggle="modal" data-active="0" data-target="#addModal">
                <i class="fas fa-plus mx-1"></i>أضف
            </button>
        @endif
        
    </div>
    <!--    End header    -->





    <div class="row pt-4 mb-5 text-right">


        <!--    Start search box     -->
        <aside class="col-lg-4 col-xl-3 mb-5">
            <form action="{{ Request::url() }}">
                <input type="hidden" name="search" value="1" /> 
                <div class="form-group">
                    <label>رقم العضوية</label>
                    <input type="number" value="{{ Request::get('code') }}" min="1" name="code" class="form-control" />
                </div>
                <div class="form-group">
                    <label>الاسم</label>
                    <input type="search" value="{{ Request::get('name') }}" name="name" maxlength="32" class="form-control" />
                </div>
                <div class="form-group">
                    <label>رقم الهاتف</label>
                    <input type="search" value="{{ Request::get('phone') }}" name="phone" maxlength="32" class="form-control" />
                </div>
                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="search" value="{{ Request::get('email') }}" name="email" maxlength="32" class="form-control" />
                </div>
                <div class="form-group">
                    <label>العنوان</label>
                    <input type="search" value="{{ Request::get('address') }}" name="address" maxlength="32" class="form-control" />
                </div>
                <div class="form-group">
                    <label>استلام في</label>
                    <select name="receive_in" id="inputReceiveInSearch" class="form-control setValue" value="{{ Request::get('receive_in') }}">
                        {{--  I will copy them using JS to skip make multi loops for the same purpose --}}
                    </select>
                </div> 
                <div class="form-group">
                    <label>الحالة</label>
                    <select name="state" class="form-control setValue" value="{{ Request::get('state') }}">
                        <option value="0" selected>الكل</option>  
                        @foreach($STATE as $key_DB => $value) 
                        <option value="{{ $key_DB }}" >{{ $value }}</option>  
                        @endforeach
                    </select>
                </div>   
                <div class="form-group">
                    <label>معلومات أخرى</label>
                    <input type="search" value="{{ Request::get('extra') }}" name="extra" maxlength="32" class="form-control" />
                </div> 
                <div class="form-group">
                    <label>سجل من</label>
                    <input type="date" value="{{ Request::get('from') }}" max="{{ date('Y-m-d') }}" name="from" class="form-control" />
                </div>
                <div class="form-group">
                    <label>سجل إلى</label>
                    <input type="date" value="{{ Request::get('to') }}" max="{{ date('Y-m-d') }}" name="to" class="form-control" />
                </div> 
                <div class="form-group">
                    <label>فعل من</label>
                    <input type="date" value="{{ Request::get('activated_from') }}" max="{{ date('Y-m-d') }}" name="activated_from" class="form-control" />
                </div>
                <div class="form-group">
                    <label>فعل إلى</label>
                    <input type="date" value="{{ Request::get('activated_to') }}" max="{{ date('Y-m-d') }}" name="activated_to" class="form-control" />
                </div> 
                <button type="submit" class="btn btn-primary btn-block mt-2">بحث</button>
            </form>
        </aside>
        <!--    End search box     -->



        <!--    Start show data  -->
        <section class="col-lg-8 col-xl-9">

            <div class="row">

                @if(count($customers) > 0)
                    <!-- Start print customers -->
                    @foreach($customers as $customer)
                    
                        <div class="col-md-6 col-lg-4 mb-5"> 
                            <div class="card customer-card {{ $customer->getStateColor() }}">
                                <div class="flip-card">
                                    <div class="flip-card-inner">
                                        <div class="flip-card-front"> 
                                            <img src="{{ $customer->getImageAvatar() }}" class="customer-img">
                                        </div>
                                        <div class="flip-card-back">
                                            <ul class="list-with-icon p-3">
                                                <li>
                                                    <span class="item-icon text-secondary">
                                                        <i class="fa fa-phone"></i>
                                                    </span>
                                                    <bdi>{{ $customer->phone }}</bdi>
                                                </li>
                                                <li>
                                                    <span class="item-icon text-secondary">
                                                        <i class="fa fa-envelope"></i>
                                                    </span>
                                                    <bdi>{{ $customer->email }}</bdi>
                                                </li>
                                                <li>
                                                    <span class="item-icon text-secondary">
                                                        <i class="fa fa-map-marker-alt"></i>
                                                    </span>
                                                    <bdi>{{ $customer->address }}</bdi>
                                                </li>
                                                <li title="{{ $customer->created_at->format('Y-m-d g:ia') }}">
                                                    <span class="item-icon text-secondary">
                                                        <i class="far fa-calendar-alt"></i>
                                                    </span>
                                                    <bdi>{{$customer->created_at->diffForHumans()}}</bdi>
                                                </li>
                                                @if($customer->last_access)
                                                    <li title="{{ $customer->last_access->format('Y-m-d g:ia') }}">
                                                        <span class="item-icon text-secondary">
                                                            <i class="far fa-clock"></i>
                                                        </span>
                                                        <bdi>{{ $customer->last_access->diffForHumans() }}</bdi>
                                                    </li>
                                                @endif
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body text-center">
                                    <h4 class="mb-1">
                                        <a href="{{ url('cp/customers',$customer->id) }}"><bdi>{{ $customer->code }}</bdi></a>
                                    </h4> 
                                    <a class="d-block text-dark" href="{{ url('cp/customers',$customer->id) }}">
                                        <bdi>{{ $customer->name }}</bdi>
                                    </a> 
                                </div>
                            </div>  
                        </div> 
                    @endforeach
                    <!-- End print customers --> 
                @else
                    <h1 class="text-secondary py-5 my-5 text-center w-100">لايوجد نتائج</h1>
                @endif 
            </div>
             <div class="pagination-center mt-2"> {{ $customers->links() }}</div>  
        </section>
        <!--    End show data  -->


    </div>



       
    @if(hasRole('customers_add')) 
        
        <!--    Start Modal addModal -->
        <div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-xl" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="addModalLabel">إضافة زبون</h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form class='formSendAjaxRequest was-validated' refresh-seconds='2' upload-files='true' focus-on='#addModalLabel' action="{{ Request::url() }}" enctype="multipart/form-data" method="post">
                        <div class="modal-body px-5">

                            <div class="formResult text-center"></div>

                            <div class="row"> 
                                {{ csrf_field() }}
                                <div class="col-lg-6 text-center pb-2">
                                    <div class="image-upload">
                                        <label class="m-0 img-box avatar-customer">
                                            <img src="{{ url('images/no-image-user.svg') }}" default-img="{{ url('images/no-image-user.svg') }}" class="w-100 h-100 rounded-circle">
                                        </label>
                                        <input class="form-control img-input" type="file" name="img" accept=".png,.jpg,.jpeg,.gif">
                                        <div class="invalid-feedback text-center">@lang("validation.mimes",[ "attribute"=>"","values" => "png,jpg,jpeg,gif"])</div>        
                                    </div>
                                </div>
                                <div class="col-lg-6 pt-3">
                                    <div class="form-group row">
                                        <label for="inputName" class="col-auto w-150px col-form-label text-right">الاسم</label>
                                        <div class="col pr-md-0">
                                            <input type="text" name="name" id="inputName" class="form-control" pattern="\s*([^\s]\s*){3,32}" required>
                                            <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'الاسم','min'=> 3 ,'max'=>32])</div>
                                        </div>
                                    </div>
                                    <div class="form-group row">
                                        <label for="inputPhone" class="col-auto w-150px col-form-label text-right">رقم الهاتف</label>
                                        <div class="col pr-md-0">
                                            <input type="text" name="phone" id="inputPhone" class="form-control text-right" dir='ltr' pattern="\s*([0-9\-\+]\s*){3,14}" placeholder="XXX-XXXXXXX" required>
                                            <div class="invalid-feedback text-center">@lang('validation.digits_between',['attribute'=>'رقم الهاتف','min'=> 3 ,'max'=>14])</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label for="inputAddress" class="col-auto w-150px col-form-label text-right">العنوان</label>
                                        <div class="col pr-md-0">
                                            <input type="text" name="address" id="inputAddress" class="form-control" pattern="\s*([^\s]\s*){3,64}" required>
                                            <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'العنوان','min'=> 3 ,'max'=>64])</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label for="inputReceiveIn" class="col-auto w-150px col-form-label text-right">استلام في</label>
                                        <div class="col pr-md-0">
                                            <select id="inputReceiveIn" class="form-control" name="receive_in" required>
                                                <option value="">...</option>
                                                @foreach($receivingPlaces as $place)
                                                    <option value="{{ $place->id }}">{{ $place->name }}</option>
                                                @endforeach 
                                            </select>
                                            <div class="invalid-feedback text-center">@lang('validation.required',['attribute'=>'المكان'])</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label for="inputEmail" class="col-auto w-150px col-form-label text-right">البريد الإلكتروني</label>
                                        <div class="col pr-md-0">
                                            <input id="inputEmail" type="email" class="form-control" name="email" required>
                                            <div class="invalid-feedback text-center">@lang('validation.required',['attribute'=>'البريد الإلكتروني'])</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label for="inputState" class="col-auto w-150px col-form-label text-right">الحالة</label>
                                        <div class="col pr-md-0">
                                            <select id="inputState" name="state" class="form-control setValue" required>
                                                <option value="3">تفعيل</option>
                                                <option value="2">إيقاف</option>
                                            </select>
                                            <div class="invalid-feedback text-center">يجب تحديد الحالة</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label for="inputPassword" class="col-auto w-150px col-form-label text-right">كلمة المرور</label>
                                        <div class="col pr-md-0">
                                            <input id="inputPassword" type="password" minlength="6" maxlength="32" class="form-control" name="password" placeholder="كلمة المرور الجديدة" required>
                                            <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'كلمة المرور','min'=> 6 ,'max'=>32])</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label for="inputPasswordConfirmation" class="col-auto w-150px col-form-label text-right">تأكيد كلمة المرور</label>
                                        <div class="col pr-md-0">
                                            <input id="inputPasswordConfirmation" type="password" minlength="6" maxlength="32" class="form-control" placeholder="تأكيد كلمة المرور الجديدة" name="password_confirmation"
                                                required>
                                            <div class="invalid-feedback text-center">يجب أن تكون كلمات المرور متساوية</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-lg-6">
                                    <div class="form-group row">
                                        <label class="col-auto w-150px col-form-label text-right">ملف التحقق</label>
                                        <div class="col pr-md-0">
                                            <div class="custom-file">
                                                <input type="file" name="verification_file" class="custom-file-input" id="customFileInput" accept=".jpeg, .png, .jpg, .gif, .pdf" required>
                                                <label class="custom-file-label" for="customFileInput">اختر ملف</label>
                                                <div class="invalid-feedback text-center">@lang('validation.mimes',[ 'attribute'=>'ملف التحقق','values' => 'jpeg,png,jpg,gif,pdf'])</div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <div class="form-group row">
                                        <label for="inputExtra" class="col-auto w-150px col-form-label text-right">أخرى</label>
                                        <div class="col pr-md-0">
                                            <textarea name="extra" id="inputExtra" maxlength="500" rows="4" class="form-control"></textarea>
                                            <div class="invalid-feedback text-center">@lang('validation.max.string',['attribute'=>'معلومات أخرى','max'=>500])</div>
                                        </div>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">حفظ</button>
                            <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--    End Modal addModal -->
    
    @endif



@endsection



@section('extra-js')
    <script> 

            /* {{-- Copy Receiving Places from input to search form --}} */
            var inputReceiveInSearch = $('#inputReceiveInSearch');
            $(inputReceiveInSearch).html($('#inputReceiveIn').html());
            $(inputReceiveInSearch).val($(inputReceiveInSearch).attr('value'));
            $(inputReceiveInSearch).find('option[value=""]').html('الكل');

    </script>
@endsection