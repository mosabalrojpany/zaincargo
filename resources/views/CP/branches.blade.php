@extends('CP.layouts.header-footer')
@section('content')


    <!--    Start header    -->
    <div class="d-flex justify-content-between">
        <h4 class="font-weight-bold">الفروع {{ count($branches) }}</h4>
        <button class="btn btn-primary btnAdd w-100px" data-toggle="modal" data-active="0" data-target="#Modal">
            <i class="fas fa-plus mx-1"></i>أضف
        </button>
    </div>
    <!--    End header    -->



    <!--    Start show map branches    -->
    <div class="card border-0 mt-4">

        <div class="card-header bg-primary text-white py-3 d-flex justify-content-between" role="tab" id="mapItems">
            <h5 class="mb-0">الفروع على الخريطة</h5>
            <a data-toggle="collapse" class="text-white" href="#collapseMapItems" aria-expanded="true" aria-controls="collapseMapItems">
                <i class="fa fa-chevron-down"></i>
            </a>
        </div>

        <div id="collapseMapItems" class="collapse show" role="tabpanel" aria-labelledby="mapItems">
            <div class="card-body p-0">

                <form class="formSendAjaxRequest was-validated" action="{{ url('/cp/branches/update/location') }}" focus-on='#collapseMapItems' btnSuccess='hide' msgClasses='my-2' 
                    method="post">

                    {{ csrf_field() }} 
                    
                    @foreach($branches as $b)
                        <input type="hidden" name="branches[{{ $b->id }}][longitude]" id="location_lng{{ $b->id }}">
                        <input type="hidden" name="branches[{{ $b->id }}][latitude]" id="location_lat{{ $b->id }}">                    
                    @endforeach
                    
                    <div class="row mx-3">
                        <div class="col" style="min-height: 0">
                            <div class="formResult text-center"></div>
                        </div>
                        <div class="col-auto" style="min-height: 0">
                            <button type="submit" id="butSaveMap" class="btn btn-primary my-2 d-none">تحديث</button>
                        </div>
                    </div>

                </form>

                <div style="height: 600px">
                    {!! Mapper::render(0) !!}
                </div>

            </div>
        </div>
    </div>
    <!--    End show map branches      -->
    
    



    <!--    Start show branches   -->
    <table class="table text-center mt-4 mb-5 bg-white">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">المدينة</th>
                <th scope="col">العنوان</th>
                <th scope="col">رقم الهاتف</th>
                <th scope="col">2رقم الهاتف</th>
                <th scope="col">البريد الإلكتروني</th>
                <th scope="col">تعديل</th>
            </tr>
        </thead>
        <tbody>

            <!-- Start print branches -->
            @foreach($branches as $b)
                
                <tr data-id='{{ $b->id }}' data-active='{{ $b->active }}'  class="<?= ($b->active)? '':'table-danger' ?>">
                    <th scope="row">{{1+$loop->iteration}}</th>
                    <td data="city">{{ $b->city }}</td> 
                    <td data="address">{{ $b->address }}</td> 
                    <td data="phone">{{ $b->phone }}</td> 
                    <td data="phone2">{{ $b->phone2 }}</td> 
                    <td data="email">{{ $b->email }}</td> 
                    <td>
                        <button type="button" class="btn btn-primary btn-sm btnEdit" data-toggle="modal" data-target="#Modal">
                            <i class="fas fa-pen"></i>
                        </button>
                    </td>
                </tr> 
            
            @endforeach
            <!-- End print branches -->

        </tbody>
    </table>
    <!--    End show branches   -->




    

    <!--    Start Modal  -->
    <div class="modal fade text-right" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">تعديل فرع</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class='formSendAjaxRequest was-validated' refresh-seconds='2' action="{{ url('/cp/branches') }}" method="post">
                    <div class="modal-body px-sm-5">
                        
                        <div class="formResult text-center"></div>
                        {{ csrf_field() }}

                        <input type="hidden" name="id" />
                    
                        <input id="location_lng" name="longitude" type="hidden" value="20.086566000">
                        <input id="location_lat" name="latitude" type="hidden" value="32.118840000">
                        
                        <div class="row">

                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputCity" class="col-sm-auto w-125px col-form-label">المدينة</label>
                                    <div class="col-sm pr-0">
                                        <input type="text" name="city" class="form-control" id="inputCity" placeholder="المدينة" pattern="\s*([^\s]\s*){3,32}" required>
                                        <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'المدينة','min'=> 3 ,'max'=>32])</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputEmail" class="col-sm-auto w-125px pl-0 col-form-label">البريد الإلكتروني</label>
                                    <div class="col-sm pr-0">
                                        <input type="email" id="inputEmail" name="email" class="form-control" placeholder="xxxxxxx@domain.xxx" required>
                                        <div class="invalid-feedback text-center">@lang('validation.email',['attribute'=> 'البريد الإلكتروني'])</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputPhone" class="col-sm-auto w-125px pl-0 col-form-label">رقم الهاتف</label>
                                    <div class="col-sm pr-0">
                                        <input type="text" id="inputPhone" name="phone" class="form-control text-right" dir="ltr" pattern="\s*[0-9\(\)\-+]{3,24}\s*" title="يرجى إدخال رقم أو الحروف  (+-)" placeholder="+218-9X-XXXXXXX التنسيق المفضل" required>
                                        <div class="invalid-feedback text-center">@lang('validation.digits_between',['attribute'=> 'رقم الهاتف','min'=>3,'max'=>24])</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputPhone2" class="col-sm-auto w-125px pl-0 col-form-label">رقم الهاتف 2</label>
                                    <div class="col-sm pr-0">
                                        <input type="text" id="inputPhone2" name="phone2" class="form-control text-right" dir="ltr" pattern="\s*[0-9\(\)\-+]{3,24}\s*" title="يرجى إدخال رقم أو الحروف  (+-)" placeholder="+218-9X-XXXXXXX التنسيق المفضل">
                                        <div class="invalid-feedback text-center">@lang('validation.digits_between',['attribute'=> 'رقم الهاتف','min'=>3,'max'=>24])</div>
                                    </div>
                                </div>
                            </div>

                            <div class="col-lg-6">
                                <div class="form-group row">
                                    <label for="inputActive" class="col-sm-auto w-125px col-form-label">الحالة</label>
                                    <div class="col-sm pr-0">
                                        <select id="inputActive" name="active" class="form-control" required>
                                            <option value="1" selected>تفعيل</option> 
                                            <option value="0">عدم التفعيل</option> 
                                        </select>
                                    </div>
                                </div>
                            </div>
                                    
                        </div>
                        
                        <div class="form-group row">
                            <label for="inputAddress" class="col-sm-auto w-125px pl-0 col-form-label">العنوان</label>
                            <div class="col-sm pr-0">
                                <textarea class="form-control" rows="2" name="address" id="inputAddress" minlength="10" maxlength="100" placeholder="الموقع الجغرافي" required></textarea>
                                <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'العنوان','min'=> 10 ,'max'=>100])</div>
                            </div>
                        </div>

                        <div class="card" id="modal-map">
                            <div class="card-header bg-primary text-white">
                                <h5 class="text-center mb-0">الموقع على الخريطة</h5>
                            </div>
                            <div style="width: auto; height: 400px;">
                                {!! Mapper::render(1) !!}
                            </div>
                        </div>
                    
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary w-100px">تحديث</button>
                        <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--    End Modal  -->
    

@endsection


@section('extra-js')
    <script> 
            var addAction = "{{ url('/cp/branches') }}";
            var editAction = "{{ url('/cp/branches/edit') }}";
            var form = $('#Modal form')[0];
            
            $('.btnAdd').click(function() {
                form.reset();
                $(form).find('#modal-map').show();
                $(form).attr('action',addAction);
                $('#ModalLabel').html('إضافة فرع');
                $(form).find('.formResult').html('');
            });

            $('.btnEdit').click(function() {
                var tr = $(this).parent().parent();

                $(form).find('#modal-map').hide();
                $(form).attr('action',editAction);
                
                $('#ModalLabel').html('تعديل فرع');
                $(form).find('.formResult').html('');
                
                $(form).find('input[name="id"]').val(tr.data('id'));
                $(form).find('input[name="city"]').val(tr.find('td[data="city"]').html());
                $(form).find('input[name="email"]').val(tr.find('td[data="email"]').html());
                $(form).find('input[name="phone"]').val(tr.find('td[data="phone"]').html());
                $(form).find('input[name="phone2"]').val(tr.find('td[data="phone2"]').html());
                $(form).find('select[name="active"]').val(tr.data('active'));
                $(form).find('textarea[name="address"]').val(tr.find('td[data="address"]').html());
            });
    </script>
@endsection


