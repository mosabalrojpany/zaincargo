@extends('CP.layouts.header-footer')
@section('content')



    <!--    Start header    -->
    <div class="d-flex text-right">
        <h4 class="font-weight-bold">الإعدادات</h4>
    </div>
    <!--    End header    -->



    <!--    Start Settings  -->
    <div class="card shadow mt-4">

        <h4 class="card-header py-3 bg-white text-center" id="fouctPoint">إعدادت الموقع</h4>

        <form class='formSendAjaxRequest was-validated' focus-on="#fouctPoint" refresh-seconds='false' action="{{ url('/cp/settings') }}" method="post">

            <div class="card-body px-sm-5 text-right">

                <div class="formResult text-center"></div>
                {{ csrf_field() }}

                <input type="hidden" name="latitude" id="location_lat" value="{{ app_settings()->latitude }}" />
                <input type="hidden" name="longitude" id="location_lng" value="{{ app_settings()->longitude }}" />

                <div class="card mb-3">
                    <h5 class="card-header bg-secondary text-white text-center">الموقع على الخريطة</h5>
                    <div style="height: 500px">
                        {!! Mapper::render() !!}
                    </div>
                </div>


                <div class="row text-right">

                    <div class="col-lg-12">
                        <div class="form-group row">
                            <label for="inputAddress" class="col-sm-auto w-125px pl-0 col-form-label">العنوان</label>
                            <div class="col-sm">
                                <input type="text" value="{{ app_settings()->address }}" name="address" class="form-control" id="inputAddress" placeholder="الموقع الجغرافي" pattern="\s*([^\s]\s*){10,100}" required>
                                <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'العنوان','min'=> 10 ,'max'=>100])</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="inputCity" class="col-sm-auto w-125px pl-0 col-form-label">المدينة</label>
                            <div class="col-sm">
                                <input type="text" value="{{ app_settings()->city }}" name="city" class="form-control" id="inputCity" placeholder="المدينة للمكان الرئيسي" pattern="\s*([^\s]\s*){3,32}" required>
                                <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'المدينة','min'=> 3 ,'max'=>32])</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="inputEmail" class="col-sm-auto w-125px pl-0 col-form-label">البريد الإلكتروني</label>
                            <div class="col-sm">
                                <input type="email" value="{{ app_settings()->email }}" id="inputEmail" name="email" class="form-control" placeholder="xxxxxxx@domain.xxx" required>
                                <div class="invalid-feedback text-center">@lang('validation.email',['attribute'=> 'البريد الإلكتروني'])</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="inputPhone" class="col-sm-auto w-125px pl-0 col-form-label">رقم الهاتف</label>
                            <div class="col-sm">
                                <input type="text" value="{{ app_settings()->phone }}" id="inputPhone" name="phone" class="form-control text-right" dir="ltr" pattern="\s*[0-9\(\)\-+]{3,24}\s*" title="يرجى إدخال رقم أو الحروف  (+-)" placeholder="+218-9X-XXXXXXX التنسيق المفضل" required>
                                <div class="invalid-feedback text-center">@lang('validation.digits_between',['attribute'=> 'رقم الهاتف','min'=>3,'max'=>24])</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="inputPhone2" class="col-sm-auto w-125px pl-0 col-form-label">رقم الهاتف 2</label>
                            <div class="col-sm">
                                <input type="text" value="{{ app_settings()->phone2 }}" id="inputPhone2" name="phone2" class="form-control text-right" dir="ltr" pattern="\s*[0-9\(\)\-+]{3,24}\s*" title="يرجى إدخال رقم أو الحروف  (+-)" placeholder="+218-9X-XXXXXXX التنسيق المفضل">
                                <div class="invalid-feedback text-center">@lang('validation.digits_between',['attribute'=> 'رقم الهاتف','min'=>3,'max'=>24])</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="inputFacebook" class="col-sm-auto w-125px pl-0 col-form-label">رابط Facebook</label>
                            <div class="col-sm">
                                <input type="url" dir="ltr" value="{{ app_settings()->facebook }}" name="facebook" class="form-control" id="inputFacebook" placeholder="رابط صفحة الفيسبوك">
                                <div class="invalid-feedback text-center">@lang('validation.url',['attribute'=>'رابط الفيس'])</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="inputInstagram" class="col-sm-auto w-125px pl-0 col-form-label">رابط Instagram</label>
                            <div class="col-sm">
                                <input type="url" dir="ltr" value="{{ app_settings()->intagram }}" name="instagram" class="form-control" id="inputInstagram" placeholder="رابط حساب الانستقرام">
                                <div class="invalid-feedback text-center">@lang('validation.url',['attribute'=>'رابط الفيس'])</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="inputTwitter" class="col-sm-auto w-125px pl-0 col-form-label">رابط Twitter</label>
                            <div class="col-sm">
                                <input type="url" dir="ltr" value="{{ app_settings()->twitter }}" name="twitter" class="form-control" id="inputTwitter" placeholder="رابط حساب التويتر">
                                <div class="invalid-feedback text-center">@lang('validation.url',['attribute'=>'رابط التويتر'])</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="inputYoutube" class="col-sm-auto w-125px pl-0 col-form-label">رابط Youtube</label>
                            <div class="col-sm">
                                <input type="url" dir="ltr" value="{{ app_settings()->youtube }}" name="youtube" class="form-control" id="inputYoutube" placeholder="رابط قناة اليوتيوب">
                                <div class="invalid-feedback text-center">@lang('validation.url',['attribute'=>'رابط اليوتيوب'])</div>
                            </div>
                        </div>
                    </div>


                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="inputCurrency" class="col-sm-auto w-125px pl-0 col-form-label">العملة الرئيسية</label>
                            <div class="col-sm">
                                <input readonly value="{{ app_settings()->currency->name }}" class="form-control">
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="inputActive" class="col-sm-auto w-125px pl-0 col-form-label">الحالة</label>
                            <div class="col-sm">
                                <select class="form-control setValue" value="{{ app_settings()->active }}" id="inputActive" name="active" required>
                                    <option value="1">تفعيل</option>
                                    <option value="0">إيقاف(وضع الصيانة)</option>
                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group row">
                            <label for="inputMaintenance" class="col-sm-auto w-125px pl-0 col-form-label">رسالة الصيانة</label>
                            <div class="col-sm">
                                <textarea name="maintenance_msg" rows="3" class="form-control" id="inputMaintenance" placeholder="رسالة تظهر للزوار أثناء وضع الصيانة" minlength="10" maxlength="250" required>{{ app_settings()->maintenance_msg }}</textarea>
                                <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'رسالة الصيانة', 'min'=>10 ,'max'=>250])</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group row">
                            <label for="inputDesc" class="col-sm-auto w-125px pl-0 col-form-label">وصف الموقع</label>
                            <div class="col-sm">
                                <textarea name="desc" rows="3" class="form-control" id="inputDesc" placeholder="شرح مختصر عن الموقع يظهر في نهاية الموقع" minlength="32" maxlength="250" required>{{ app_settings()->desc }}</textarea>
                                <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'وصف الموقع', 'min'=>32 ,'max'=>250])</div>
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12">
                        <div class="form-group row">
                            <label for="inputKeywords" class="col-sm-auto w-125px pl-0 col-form-label">الكلمات الدليلية</label>
                            <div class="col-sm">
                                <textarea name="keywords" rows="3" class="form-control" id="inputKeywords"
                                placeholder="كلمات دليلية تساعد محركات البحث لمعرفة موقعك , يرجي وضع فاصلة بين كل وصف , مثلا :  شركات ليبيا , خدمات لوجستية , شركة شحن"
                                minlength="32" maxlength="250" required>{{ app_settings()->keywords }}</textarea>
                                <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'الكلمات الدليلية', 'min'=>32 ,'max'=>250])</div>
                            </div>
                        </div>
                    </div>
                </div>

                <hr/>

                <div class="row">
                    <div class="col-lg-6">
                        <div class="form-group row">
                            <label for="inputPassword" class="col-sm-auto w-125px pl-0 col-form-label">كلمة المرور</label>
                            <div class="col-sm">
                                <input type="password" name="password" class="form-control" id="inputPassword" placeholder="كلمة المرور الخاصة بك" pattern="\s*([^\s]\s*){6,32}" required>
                                <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'كلمة المرور','min'=> 6 ,'max'=>32])</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>

            <div class="card-footer bg-white">
                <button type="submit" class="w-150px btn btn-primary">تحديث</button>
            </div>
        </form>

    </div>
    <!--    End Settings  -->



@endsection
