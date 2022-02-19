@extends('main.layouts.header-footer')

@section('content')



    <!--  hero area start  -->
    <div class="hero-area hero-signup-bg-bg home-3">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-10">

                    <div class="quote-form-section" style="position: relative; z-index: 1;" id="fouctPoint">
                        <h2 class="subtitle text-white">إنشاء حساب</h2>
                            
                        <form class='formSendAjaxRequest' method="POST" refresh-seconds='false' upload-files="true" action="{{ url('/client/register') }}" 
                            hideOnSuccess="true" focus-on="#fouctPoint" msgSuccess="تم التسجيل بنجاح , سيتم مراجعة بياناتك وإرسال رسالة التفعيل على البريد الإلكتروني">
                            

                            @csrf
                            <div class="formResult"></div>

                            <div class="row text-white">

                                <div class="col-md-6">
                                    <div class="form-element">
                                        <label>الاسم</label>
                                        <input type="text" name="name" pattern="\s*([^\s]\s*){9,32}" required title="@lang('validation.between.string',['attribute'=>'الاسم','min'=> 9 ,'max'=>32])">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-element">
                                        <label>رقم الهاتف</label>
                                        <input type="text" name="phone" class="text-right" dir='ltr' pattern="\s*([0-9\-\+]\s*){3,14}" placeholder="XXX-XXXXXXX" required
                                            title="@lang('validation.digits_between',['attribute'=>'رقم الهاتف','min'=> 3 ,'max'=>14])">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-element">
                                        <label>العنوان</label>
                                        <input type="text" name="address" pattern="\s*([^\s]\s*){12,64}" title="@lang('validation.between.string',['attribute'=>'العنوان','min'=> 12 ,'max'=>64])" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-element">
                                        <label>استلام في</label>
                                        <select name="receive_in" required>
                                            <option value="" disabled selected>اختر مكان استلام شحناتك...</option>
                                            @foreach($receivingPlaces as $place)
                                                <option value="{{ $place->id }}">{{ $place->name }}</option>
                                            @endforeach 
                                        </select>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-element">
                                        <label>البريد الإلكتروني</label>
                                        <input type="email" name="email" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-element">
                                        <label>ملف التحقق</label>
                                        <div class="custom-file">
                                            <input type="file" name="verification_file" class="custom-file-input" id="customFileInput" accept=".jpeg, .png, .jpg, .gif, .pdf" required
                                                title="@lang('validation.mimes',[ 'attribute'=>'ملف التحقق','values' => 'jpeg,png,jpg,gif,pdf'])">
                                            <label class="custom-file-label" for="customFileInput">صورة من بطاقة الهوية او جواز السفر</label>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-element">
                                        <label>كلمة المرور</label>
                                        <input id="inputPassword" type="password" minlength="6" maxlength="32" name="password" placeholder="كلمة المرور الجديدة" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-element">
                                        <label>تأكيد كلمة المرور</label>
                                        <input id="inputPasswordConfirmation" type="password" minlength="6" maxlength="32" placeholder="تأكيد كلمة المرور الجديدة" name="password_confirmation" required
                                            title="يجب أن تكون كلمات المرور متساوية">
                                    </div>
                                </div>
                                <div class="col-lg-12">
                                    <div class="custom-control custom-checkbox text-right p-0 my-3 mr-4">
                                        <input type="checkbox" value="1" class="custom-control-input" id="customControlValidationAgree" name="confirm" required>
                                        <label class="custom-control-label" for="customControlValidationAgree">
                                            لقد قرأت <a href="{{ url('terms') }}" target="_blank" class="link">الشروط والسياسات</a> وأنا موافق على ذلك
                                        </label>
                                    </div>
                                </div>

                            </div>

                            <div class="row align-items-center mt-3">
                                
                                <div class="col-sm-auto">
                                    <div class="form-element mb-0">
                                        <button type="submit" class="boxed-btn">
                                            <span>تسجيل</span>
                                        </button>
                                    </div>
                                </div>

                                <div class="col-sm mt-3 m-sm-0">
                                    هل لديك حساب ؟ <a href="#" class="link" data-toggle="modal" data-target="#loginModal">قم بالدخول</a>
                                </div>
                            
                            </div>

                        </form>
                    </div>

                </div>
            </div>
        </div>
        <div class="hero-overlay"></div>
    </div>
    <!--  hero area end  -->

    

@endsection


@section('extra-js')

    <script>    
        $('.custom-file-input').on('change', function (e) {
            $(this).next('.custom-file-label').html(e.target.files.length == 0 ? 'اختر ملف' : e.target.files[0].name);
        })
        
        $('#inputPassword ,#inputPasswordConfirmation').keyup(function () {
            $('#inputPasswordConfirmation').attr('pattern', $('#inputPassword').val());
        });
    </script>

@endsection