@extends('CP.layouts.header-footer')
@section('content')



<div class="container my-5">

    <!--    Start header    -->
    <div class="d-flex justify-content-between">
        <h4 class="font-weight-bold">العناوين {{ $addresses->total() }}</h4>

        @if(hasRole('addresses_add'))
            <button class="btn btn-primary btnAdd w-100px" data-toggle="modal" data-active="0" data-target="#Modal">
                <i class="fas fa-plus mx-1"></i>أضف
            </button>
        @endif

    </div>
    <!--    End header    -->

    

    <div class="row mt-5">

        

        <!--    Start search box     -->
        <aside class="col-lg-4 col-xl-3 mb-5 text-right">
            <form action="{{ Request::url() }}">
                <input type="hidden" name="search" value="1" />   
                <div class="form-group">
                    <label>الاسم بالكامل</label>
                    <input type="search" value="{{ Request::get('fullname') }}" name="fullname" maxlength="32" class="form-control" />
                </div> 
                <div class="form-group">
                    <label>البلد</label>
                    <select name="country" id="inputCountrySearch" class="form-control setValue" value="{{ Request::get('country') }}">
                        <option value="" selected>الكل</option>
                        {{-- I will set options using js --}}
                    </select>
                </div> 
                <div class="form-group">
                    <label>المدينة</label>
                    <select name="city" id="inputCitySearch" class="form-control setValue" value="{{ Request::get('city') }}">
                        <option value="" selected>الكل</option>
                        {{-- I will set options using js --}}
                    </select>
                </div> 
                <div class="form-group">
                    <label>النوع</label>
                    <select name="type" class="form-control setValue" value="{{ Request::get('type') }}">
                        <option value="" selected>الكل</option>  
                        <option value="1">جوي</option>  
                        <option value="2">بحري</option>  
                    </select>
                </div> 
                <div class="form-group">
                    <label>الحالة</label>
                    <select name="state" class="form-control setValue" value="{{ Request::get('state') }}">
                        <option value="" selected>الكل</option>  
                        <option value="1">فعال</option>  
                        <option value="0">غير فعال</option>  
                    </select>
                </div>   
                <div class="form-group">
                    <label>ملاحظة</label>
                    <input type="search" value="{{ Request::get('note') }}" name="note" maxlength="32" class="form-control" />
                </div>    
                <div class="form-group">
                    <label>معلومات أخرى</label>
                    <input type="search" value="{{ Request::get('extra') }}" name="extra" maxlength="32" class="form-control" />
                </div> 
                <div class="form-group">
                    <label>أضيف من</label>
                    <input type="date" value="{{ Request::get('from') }}" max="{{ date('Y-m-d') }}" name="from" class="form-control" />
                </div>
                <div class="form-group">
                    <label>أضيف إلى</label>
                    <input type="date" value="{{ Request::get('to') }}" max="{{ date('Y-m-d') }}" name="to" class="form-control" />
                </div> 
                <button type="submit" class="btn btn-primary btn-block mt-2">بحث</button>
            </form>
        </aside>
        <!--    End search box     -->


        
        @php
            $canEdit =  hasRole('addresses_edit')        
        @endphp

        <!--    Start show data  -->
        <section class="col-lg-8 col-xl-9">

            <!-- Start print addresses -->
            @foreach($addresses as $address)

                <div class="mb-3">
    
                    <div class="card border-0 {{ $address->active ? 'border-state-active' : 'border-state-disable' }}">
                        
                        {{--  Start header address  --}}
                        <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center" role="tab" id="heading{{ $address->id }}">
                            <h5 class="mb-0">
                                <span class="address-type-icon">
                                    <img src="{{ $address->getTypeIcon() }}" style="height: 40px" class="ml-1">
                                </span>
                                <img src="{{ $address->country->getAvatarLogo() }}" class="ml-1">
                                <bdi>{{ $address->country->name }}</bdi> / <bdi>{{ $address->city->name }}</bdi>
                            </h5>
                            <a data-toggle="collapse" class="text-dark" href="#collapse{{ $address->id }}" aria-expanded="false" aria-controls="collapse{{ $address->id }}">
                                <i class="fa fa-chevron-down"></i>
                            </a>
                        </div>
                        {{--  End header address  --}}

                        {{--  Start body address  --}}
                        <div id="collapse{{ $address->id }}" class="collapsing" role="tabpanel" aria-labelledby="heading{{ $address->id }}">

                            <div class="card-body text-right">

                                <div class="d-flex justify-content-between pb-3">
                                    <ul class="nav nav-pills nav-fill pr-0" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="addressInfo{{ $address->id }}-tab" data-toggle="tab" href="#addressInfo{{ $address->id }}" role="tab" aria-controls="addressInfo{{ $address->id }}" aria-selected="true">العنوان</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" id="prices{{ $address->id }}-tab" data-toggle="tab" href="#prices{{ $address->id }}" role="tab" aria-controls="prices{{ $address->id }}" aria-selected="false">الأسعار</a>
                                        </li>
                                    </ul>

                                    @if(hasRole('addresses_edit'))
                                        <button type="button" class="btn btn-primary btnEdit" data-toggle="modal" data-target="#Modal">
                                            <i class="fas fa-pen"></i>
                                        </button>
                                    @endif

                                </div>


                                <div class="tab-content">
                                    
                                    {{--  Start address info  --}}
                                    <div class="tab-pane fade show active" id="addressInfo{{ $address->id }}" role="tabpanel" aria-labelledby="addressInfo{{ $address->id }}-tab">
                                        <table class="table table-address-info table-info-data">
                                            <tbody data-id="{{ $address->id }}" data-country="{{ $address->country_id }}" data-city="{{ $address->city_id }}" data-active="{{ $address->active }}" data-type="{{ $address->type }}">
                                                <tr>
                                                    <td>البلد</td>
                                                    <td><bdi>{{ $address->country->name }}</bdi></td>
                                                    <td>Country</td>
                                                </tr>
                                                <tr>
                                                    <td>اسم العنوان</td>
                                                    <td><bdi data="name">{{ $address->name }}</bdi></td>
                                                    <td>Address Name</td>
                                                </tr>
                                                <tr>
                                                    <td>الاسم بالكامل</td>
                                                    <td><bdi data="fullname">{{ $address->fullname }}</bdi></td>
                                                    <td>FullName</td>
                                                </tr>
                                                <tr>
                                                    <td>العنوان</td>
                                                    <td><bdi data="address1">{{ $address->address1 }}</bdi></td>
                                                    <td>Address Line 1</td>
                                                </tr>
                                                <tr>
                                                    <td>العنوان 2</td>
                                                    <td><bdi data="address2">{{ $address->address2 }}</bdi></td>
                                                    <td>Address Line 2</td>
                                                </tr>
                                                <tr>
                                                    <td>المدينة</td>
                                                    <td><bdi>{{ $address->city->name }}</bdi></td>
                                                    <td>City</td>
                                                </tr>
                                                <tr>
                                                    <td>الولاية</td>
                                                    <td data="state">{{ $address->state }}</td>
                                                    <td>State/Region</td>
                                                </tr>
                                                <tr>
                                                    <td>الرمز البريدي</td> 
                                                    <td><bdi data="zip">{{ $address->zip }}</bdi></td>
                                                    <td>PostCode/Zip</td>
                                                </tr>
                                                <tr>
                                                    <td>رقم الهاتف</td>
                                                    <td><bdi data="phone">{{ $address->phone }}</bdi></td>
                                                    <td>Phone 1</td>
                                                </tr>
                                                <tr>
                                                    <td>رقم الهاتف 2</td> 
                                                    <td><bdi data="phone2">{{ $address->phone2 }}</bdi></td>
                                                    <td>Phone 2</td>
                                                </tr>
                                                <tr>
                                                    <td>رقم الهاتف 3</td> 
                                                    <td><bdi data="phone3">{{ $address->phone3 }}</bdi></td>
                                                    <td>Phone 3</td>
                                                </tr>
                                                <tr>
                                                    <td>ملاحظة</td> 
                                                    <td colspan="2" data="note">{{ $address->note }}</td>
                                                </tr>
                                                <tr>
                                                    <td>معلومات أخرى</td> 
                                                    <td colspan="2" data="extra">{{ $address->extra }}</td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </div>
                                    {{--  End address info  --}}

                                    {{--  Start prices  --}}
                                    <div class="tab-pane fade" id="prices{{ $address->id }}" role="tabpanel" aria-labelledby="prices{{ $address->id }}-tab">
                                        <table class="table table-bordered table-prices-data text-center">
                                            <thead>
                                                <tr>
                                                    <th>من</th>
                                                    <th>إلى</th>
                                                    <th>السعر</th>
                                                    <th>الوصف</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @foreach($address->prices as $price)
                                                    <tr data-id="{{ $price->id }}">
                                                        <td data="from">{{ $price->from }}</td>
                                                        <td data="to">{{ $price->to }}</td>
                                                        <td data="price">{{ $price->price }}</td>
                                                        <td data="desc">{{ $price->description }}</td>
                                                    </tr> 
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </div>
                                    {{--  End prices  --}}

                                </div>
                            </div>
                        </div>
                        {{--  End body address  --}}

                        
                    </div>

                </div>

            @endforeach
            <!-- End print addresses -->

             <div class="pagination-center mt-2">{{ $addresses->links() }}</div>  

        </section>
        <!--    End show data  -->


    </div>
    

</div>


@if(hasRole(['addresses_add','addresses_edit']))
    
    <!--    Start Modal  -->
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-xl" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">تعديل عنوان</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class='formSendAjaxRequest was-validated' id="addressForm" refresh-seconds='2' action="{{ url('/cp/addresses') }}" method="post">
                    
                    {{--  Start input fildes  --}}
                    <div class="modal-body px-sm-5">

                        <div class="formResult text-center"></div>
                        {{ csrf_field() }}
                        <input type="hidden" name="id" />

                        <nav class="pb-3">
                            <div class="nav nav-tabs nav-fill" role="tablist">
                                <a class="nav-item nav-link active" id="nav-inputAddress-tab" data-toggle="tab" href="#nav-inputAddress" role="tab" aria-controls="nav-inputAddress" aria-selected="true">العنوان</a>
                                <a class="nav-item nav-link" id="nav-inputPrices-tab" data-toggle="tab" href="#nav-inputPrices" role="tab" aria-controls="nav-inputPrices" aria-selected="false">الأسعار</a>
                            </div>
                        </nav>

                        <div class="tab-content">
                        
                            {{--  Start input address  --}}
                            <div class="tab-pane fade show active" id="nav-inputAddress" role="tabpanel" aria-labelledby="nav-inputAddress-tab">
                                <div class="row">

                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label for="inputName" class="col-sm-auto w-125px col-form-label text-right">الاسم</label>
                                            <div class="col-sm">
                                                <input type="text" name="name" class="form-control" id="inputName" placeholder="اسم فريد لتميز العنوان" pattern="\s*([^\s]\s*){3,32}" required>
                                                <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'الاسم','min'=> 3 ,'max'=>32])</div>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label for="inputFullName" class="col-sm-auto w-125px col-form-label text-right">الاسم بالكامل</label>
                                            <div class="col-sm">
                                                <input type="text" name="fullname" class="form-control" id="inputFullName" placeholder="رقم عضويتكم ليتم بعدها إضافة عضوية الزبون" pattern="\s*([^\s]\s*){3,32}" required>
                                                <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'الاسم','min'=> 3 ,'max'=>32])</div>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label for="inputCountry" class="col-sm-auto w-125px col-form-label text-right">البلد</label>
                                            <div class="col-sm">
                                                <select id="inputCountry" name="country" class="form-control" required>
                                                    <option value="" selected>...</option>
                                                    @foreach($countries as $country) 
                                                        <option value="{{ $country->id }}">{{ $country->name }}</option>
                                                    @endforeach 
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label for="inputCity" class="col-sm-auto w-125px col-form-label text-right">المدينة</label>
                                            <div class="col-sm">
                                                <select id="inputCity" name="city" class="form-control" required>
                                                    <option value="" selected>...</option>
                                                    @foreach($cities as $city) 
                                                        <option value="{{ $city->id }}" data-country="{{ $city->country_id }}">{{ $city->name }}</option>
                                                    @endforeach 
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label for="inputState" class="col-sm-auto w-125px col-form-label text-right">الولاية</label>
                                            <div class="col-sm">
                                                <input type="text" name="state" class="form-control" id="inputState" placeholder="State" pattern="\s*([^\s]\s*){3,32}">
                                                <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'الولاية','min'=> 3 ,'max'=>32])</div>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label for="inputAddress1" class="col-sm-auto w-125px pl-0 col-form-label text-right">العنوان1</label>
                                            <div class="col-sm">
                                                <input type="text" name="address1" class="form-control" id="inputAddress1" placeholder="Address Line 1" pattern="\s*([^\s]\s*){3,32}">
                                                <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'العنوان','min'=> 3 ,'max'=>32])</div>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label for="inputAddress2" class="col-sm-auto w-125px pl-0 col-form-label text-right">العنوان2</label>
                                            <div class="col-sm">
                                                <input type="text" name="address2" class="form-control" id="inputAddress2" placeholder="Address Line 2" pattern="\s*([^\s]\s*){3,32}">
                                                <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'العنوان','min'=> 3 ,'max'=>32])</div>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label for="inputPhone" class="col-sm-auto w-125px pl-0 col-form-label text-right">رقم الهاتف1</label>
                                            <div class="col-sm">
                                                <input type="text" name="phone" id="inputPhone" class="form-control text-right" dir='ltr' placeholder="Phone Number" pattern="\s*([0-9\-\+]\s*){3,14}">
                                                <div class="invalid-feedback text-center">@lang('validation.digits_between',['attribute'=>'رقم الهاتف','min'=> 3 ,'max'=>14])</div>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label for="inputPhone2" class="col-sm-auto w-125px pl-0 col-form-label text-right">رقم الهاتف2</label>
                                            <div class="col-sm">
                                                <input type="text" name="phone2" id="inputPhone2" class="form-control text-right" dir='ltr' placeholder="Phone Number" pattern="\s*([0-9\-\+]\s*){3,14}">
                                                <div class="invalid-feedback text-center">@lang('validation.digits_between',['attribute'=>'رقم الهاتف','min'=> 3 ,'max'=>14])</div>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label for="inputPhone3" class="col-sm-auto w-125px pl-0 col-form-label text-right">رقم الهاتف3</label>
                                            <div class="col-sm">
                                                <input type="text" name="phone3" id="inputPhone3" class="form-control text-right" dir='ltr' placeholder="Phone Number" pattern="\s*([0-9\-\+]\s*){3,14}">
                                                <div class="invalid-feedback text-center">@lang('validation.digits_between',['attribute'=>'رقم الهاتف','min'=> 3 ,'max'=>14])</div>
                                            </div>
                                        </div> 
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label for="inputZip" class="col-sm-auto w-125px pl-0 col-form-label text-right">الرمز البريدي</label>
                                            <div class="col-sm">
                                                <input type="text" name="zip" class="form-control" id="inputZip" placeholder="PostCode/Zip" pattern="\s*([^\s]\s*){3,10}">
                                                <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'الرمز البريدي','min'=> 3 ,'max'=>10])</div>
                                            </div>
                                        </div> 
                                    </div>
                                    
                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label for="inputActive" class="col-sm-auto w-125px col-form-label text-right">الحالة</label>
                                            <div class="col-sm">
                                                <select id="inputActive" name="active" class="form-control" required>
                                                    <option value="1" selected>تفعيل</option> 
                                                    <option value="0">عدم التفعيل</option> 
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label for="inputType" class="col-sm-auto w-125px col-form-label text-right">النوع</label>
                                            <div class="col-sm">
                                                <select id="inputType" name="type" class="form-control" required>
                                                    <option value="" selected>...</option> 
                                                    <option value="1">جوي</option> 
                                                    <option value="2">بحري</option> 
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6"></div>

                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label for="inputNote" class="col-sm-auto w-125px col-form-label text-right">ملاحظة</label>
                                            <div class="col-sm">
                                                <textarea name="note" rows="3" class="form-control" id="inputNote" placeholder="ملاحظة للزبائن" maxlength="150"></textarea>
                                                <div class="invalid-feedback text-center">@lang('validation.max.string',['attribute'=>'الملاحظة','max'=>150])</div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-lg-6">
                                        <div class="form-group row">
                                            <label for="inputExtra" class="col-sm-auto w-125px col-form-label text-right">أخرى</label>
                                            <div class="col-sm">
                                                <textarea name="extra" rows="3" class="form-control" id="inputExtra" placeholder="معلومات أخرى خاصة" maxlength="150"></textarea>
                                                <div class="invalid-feedback text-center">@lang('validation.max.string',['attribute'=>'المعلومات الأخرى','max'=>150])</div>
                                            </div>
                                        </div>
                                    </div>

                                </div>
                            </div>
                            {{--  End input address  --}}

                            {{--  Start input prices  --}}                    
                            <div class="tab-pane fade" id="nav-inputPrices" role="tabpanel" aria-labelledby="nav-inputPrices-tab">
                            
                                <table class="table text-center">
                                    <thead>
                                        <tr>
                                            <th>من</th>
                                            <th>إلى</th>
                                            <th>السعر</th>
                                            <th>الوصف</th>
                                        </tr>
                                    </thead>
                                    <tbody> 
                                    {{--   I will add rows like this below using JS as I need with data
                                        <tr>
                                            <input type="hidden" name="prices[row_state][]" />
                                            <td>
                                                <input type="number" name="prices[from][]" class="form-control" step="any" min="0.001" required />    
                                            </td>
                                            <td>
                                                <input type="number" name="prices[to]" class="form-control" step="any" min="0.001" required />    
                                            </td>
                                            <td>
                                                <input type="number" name="prices[price][]" class="form-control" step="any" min="0" required />    
                                            </td>
                                            <td>
                                                <input type="text" name="prices[desc][]" class="form-control w-300px" placeholder="الوصف" pattern="\s*([^\s]\s*){3,32}" required>
                                                <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'الوصف','min'=> 3 ,'max'=>32])</div>
                                            </td>
                                            <td>
                                                <div class="d-flex mt-1">
                                                    <button type="button" class="btn btn-danger btn-sm btnDeleteRow ml-1"><i class="fa fa-trash"></i></button>
                                                    <button type="button" class="btn btn-primary btn-sm btnAddRow"><i class="fa fa-plus"></i></button>
                                                </div>
                                            </td>
                                        </tr>   
                                        --}} 
                                    </tbody>
                                </table>

                            </div>
                            {{--  End input prices  --}}                    

                        </div>

                    

                    </div>
                    {{--  End input fildes  --}}

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">تحديث</button>
                        <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--    End Modal  -->

@endif


@endsection


@section('extra-js')
    <script> 

            /* {{-- 
                Start config select(country and city) --
                Copy Countries and cites from input form to search form 
            --}} */
            var inputCitySearch = $('#inputCitySearch');
            $(inputCitySearch).html($('#inputCity').html());
            $(inputCitySearch).val($(inputCitySearch).attr('value'));
            $(inputCitySearch).find('option[value=""]').html('الكل');

            var inputCountrySearch = $('#inputCountrySearch');
            $(inputCountrySearch).html($('#inputCountry').html());
            $(inputCountrySearch).val($(inputCountrySearch).attr('value'))
            $(inputCountrySearch).find('option[value=""]').html('الكل');;

            $(inputCountrySearch).change(function () {
                /* When user change country show only cities that exsit in current country */
                $(inputCitySearch).val('');
                if ($(this).val()) {
                    $(inputCitySearch).find('option').hide().filter('[data-country="' + $(this).val() + '"] ,[value=""]').show();
                } else {
                    $(inputCitySearch).find('option').show();
                }
            });
            $(inputCountrySearch).change(); /* to show only related citites for selected country */
            /*  End config select(country and city) */


            var addAction = "{{ url('/cp/addresses') }}";
            var editAction = "{{ url('/cp/addresses/edit') }}";
            var form = $('#Modal form')[0];
            
            /* Start event for click add new address  */
            $('.btnAdd').click(function() {
                form.reset();
                $(form).find('input[name="id"]').val('');

                removeAllRowsInputPrice();
                addRowInputPrice();

                $(form).attr('action',addAction);
                $('#ModalLabel').html('إضافة عنوان');
                $(form).find('.formResult').html('');
            });
            /* End event for click add new address  */

            /* Start event for click edit address  */
            $('.btnEdit').click(function() {
                var addressData = $(this).closest('.card-body').find('.table-info-data tbody');
                var pricesData = $(this).closest('.card-body').find('.table-prices-data tbody');

                removeAllRowsInputPrice();
                
                $(form).attr('action',editAction);
                $('#ModalLabel').html('تعديل عنوان');
                $(form).find('.formResult').html('');
                $(form).find('input[name="id"]').val(addressData.data('id'));
                $(form).find('select[name="country"]').val(addressData.data('country')).change();/* to trigger event change , then will show only related cities */
                $(form).find('select[name="city"]').val(addressData.data('city'));
                $(form).find('select[name="active"]').val(addressData.data('active'));
                $(form).find('select[name="type"]').val(addressData.data('type'));
                $(form).find('input[name="name"]').val(addressData.find('*[data="name"]').html());
                $(form).find('input[name="fullname"]').val(addressData.find('*[data="fullname"]').html());
                $(form).find('input[name="address1"]').val(addressData.find('*[data="address1"]').html());
                $(form).find('input[name="address2"]').val(addressData.find('*[data="address2"]').html());
                $(form).find('input[name="phone"]').val(addressData.find('*[data="phone"]').html());
                $(form).find('input[name="phone2"]').val(addressData.find('*[data="phone2"]').html());
                $(form).find('input[name="phone3"]').val(addressData.find('*[data="phone3"]').html());
                $(form).find('input[name="state"]').val(addressData.find('*[data="state"]').html());
                $(form).find('input[name="zip"]').val(addressData.find('*[data="zip"]').html());
                $(form).find('textarea[name="note"]').val(addressData.find('td[data="note"]').html());
                $(form).find('textarea[name="extra"]').val(addressData.find('td[data="extra"]').html());

                var pricesRows = pricesData.find('tr');
                if(pricesRows.length > 0){
                    $.each(pricesRows, function () {
                        addRowInputPrice(
                            $(this).find('td[data="from"]').html(),
                            $(this).find('td[data="to"]').html(),
                            $(this).find('td[data="price"]').html(),
                            $(this).find('td[data="desc"]').html(),
                            $(this).data('id')
                            );
                    });
                }
                else
                {/* if address doesn't have prices , so add new row to allow to user add new prices */
                    addRowInputPrice('','','','','','added');
                }
            });
            /* End event for click edit address  */


            /******** Start helper functions ********/

            /**
             *  Add row with input fildes to form(form for Add/Edit Addresses) 
             * @param from {float} from value
             * @param to {float} to value
             * @param price {float} price value
             * @param desc {string} desc value
             * @param id {integer} id value
             * @param state {string} state of row , must be (added|updated|default)
             */
            function addRowInputPrice(from = '', to = '', price = '', desc = '', id = '',state= 'default') {

                $('#nav-inputPrices tbody').append(   
                                  '<tr>'
                                + ((id)? '<input type="hidden" name="prices[id][]" value="'+id+'" />' : '')
                                + '    <input type="hidden" name="prices[row_state][]" value="'+state+'" />'
                                + '    <td><input type="number" name="prices[from][]" value="' + from + '" class="form-control" step="any" min="0.001" required /></td>'
                                + '    <td><input type="number" name="prices[to][]" value="' + to + '" class="form-control" step="any" min="'+(from? from : 0.001)+'" required /></td>'
                                + '    <td><input type="number" name="prices[price][]" value="' + price + '" class="form-control" step="any" min="0" required /></td>'
                                + '    <td>'
                                + '        <input type="text" name="prices[desc][]" value="' + desc + '" class="form-control w-300px" placeholder="الوصف" pattern="\s*([^\s]\s*){3,32}" required>'
                                + '        <div class="invalid-feedback text-center">@lang("validation.between.string",["attribute"=>"الوصف","min"=> 3 ,"max"=>32])</div>' /*  this line will get value using laravl */
                                + '    </td>'
                                + '    <td>'
                                + '        <div class="d-flex mt-1">'
                                + '            <button type="button" class="btn btn-danger btn-sm btnDeleteRow ml-1"><i class="fa fa-trash"></i></button>'
                                + '            <button type="button" class="btn btn-primary btn-sm btnAddRow"><i class="fa fa-plus"></i></button>'
                                + '        </div>'
                                + '    </td>'
                                + '</tr>'
                            );
            }
            

            /**
             * Remove all input rows (input prices) from form and set it empty  
             */
            function removeAllRowsInputPrice(){
                $('#nav-inputPrices tbody tr').remove();
                $(form).find('[name="deleted_prices[]"]').remove();
            }

            /******** End helper functions ********/


            /*  Start events to control in add/delete rows from form    */

            /* on user click on add button , add new row in form */
            $('#nav-inputPrices').on('click', '.btnAddRow', function () {
                addRowInputPrice('', '', '', '', '', 'added');
            });

            /* on user click on delete button , delete current row from form */
            $('#nav-inputPrices').on('click', '.btnDeleteRow', function () {
                var tr = $(this).closest('tr');
                var id = $(tr).find('[name="prices[id][]"]').val();
                if (id) {/* if id exsits that means user edit data and remove current row, so I have to save it as deleted valued */
                    $(form).append('<input type="hidden" name="deleted_prices[]" value="' + id + '" />');
                }
                tr.remove();
            });

            /*  End events to control in add/delete rows from form    */


            $('#nav-inputPrices').on('change', 'input:not([type=hidden])', function () {
                var tr = $(this).closest('tr');
                var state = $(tr).find('[name="prices[row_state][]"]');
                if (state.val() === 'default') {/* if state of row is default ,so it means old data from Database and I have to change state to updated */
                    $(state).val('updated');
                }
                if ($(this).attr('name') == 'prices[from][]') {/* to make validate that (to) must be greater than or eqult (From) filde */
                    $(tr).find('[name="prices[to][]"]').attr('min', $(this).val());
                }
            });

            /* When user change country show only cities that exsit in current country */
            $('#inputCountry').change(function () {
                $('#inputCity').val('');
                if ($(this).val()) {
                    $('#inputCity option').hide().filter('[data-country="' + $(this).val() + '"] ,[value=""]').show();
                } else {
                    $('#inputCity option').hide();
                }
            });


            /**
            * when user click on submit , check if inputAddress-tab have invalid fild(input) then focue on this tab
            * if inputAddress-tab inputs valid , then check inputPrices-tab inputs
            */
            $('#addressForm :submit').click(function () {

                var continueCheckPrices = true;

                $('#nav-inputAddress input:not([type=hidden]),#nav-inputAddress select,#nav-inputAddress textarea').each(function () {
                    if (!$(this)[0].checkValidity()) {
                        $('#nav-inputAddress-tab').tab('show');
                        continueCheckPrices = false;
                        return false;
                    }
                });

                if (continueCheckPrices) {
                    $('#nav-inputPrices input:not([type=hidden])').each(function () {
                        if (!$(this)[0].checkValidity()) {
                            $('#nav-inputPrices-tab').tab('show');
                            return false;
                        }
                    });
                }
            });

    </script>
@endsection