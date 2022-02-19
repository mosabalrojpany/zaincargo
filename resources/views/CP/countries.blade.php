@extends('CP.layouts.header-footer')
@section('content')



<div class="container my-5">

    <!--    Start header    -->
    <div class="d-flex justify-content-between">
        <h4 class="font-weight-bold">البلدان {{ count($countries) }}</h4>
        <button class="btn btn-primary btnAdd w-100px" data-toggle="modal" data-active="0" data-target="#Modal">
            <i class="fas fa-plus mx-1"></i>أضف
        </button>
    </div>
    <!--    End header    -->





    <!--    Start show countries   -->
    <table class="table text-center mt-4 bg-white">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">العلم</th>
                <th scope="col">الاسم</th>
                <th scope="col">معلومات إضافية</th>
                <th scope="col">تعديل</th>
            </tr>
        </thead>
        <tbody>

            <!-- Start print countries -->
            @foreach($countries as $country)
            <tr data-id='{{ $country->id }}' data-active='{{ $country->active }}' class="<?= ($country->active)? '':'table-danger' ?>">
                <th scope="row">{{ $loop->iteration}}</th>
                <th class="p-2"><img class="country-img-avatar" src="{{ $country->getAvatarLogo() }}" /></th>
                <td data="name">{{ $country->name }}</td> 
                <td data="extra">{{ $country->extra }}</td> 
                <td><button type="button" class="btn btn-primary btn-sm btnEdit" data-toggle="modal" data-target="#Modal"><i class="fas fa-pen"></i></button></td>
            </tr> 
            @endforeach
            <!-- End print countries -->

        </tbody>
    </table>
    <!--    End show countries   -->

</div>


<!--    Start Modal  -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">تعديل بلد</h5>
                <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class='formSendAjaxRequest was-validated' upload-files="true" refresh-seconds='2' action="{{ url('/cp/countries') }}" method="post">
                <div class="modal-body px-sm-5">
                    <div class="formResult text-center"></div>
                    {{ csrf_field() }}
                    <input type="hidden" name="id" />
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-auto w-75px col-form-label text-right">الاسم</label>
                        <div class="col-sm">
                            <input type="text" name="name" class="form-control" id="inputName" placeholder="البلد" pattern="\s*([^\s]\s*){3,32}" required>
                            <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'الاسم','min'=> 3 ,'max'=>32])</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-auto w-75px col-form-label text-right">العلم</label>
                        <div class="col-sm">
                            <div class="custom-file">
                                <input type="file" name="logo" class="custom-file-input" id="customFileInputImg" accept=".jpeg, .png, .jpg, .gif">
                                <label class="custom-file-label" for="customFileInputImg">اختر صورة</label>
                                <div class="invalid-feedback text-center">@lang('validation.mimes',[ 'attribute'=>'العلم','values' => 'jpeg,png,jpg,gif,pdf'])</div>
                            </div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputExtra" class="col-sm-auto w-75px col-form-label text-right">أخرى</label>
                        <div class="col-sm">
                            <textarea name="extra" rows="3" class="form-control" id="inputExtra" placeholder="معلومات أخرى" maxlength="150"></textarea>
                            <div class="invalid-feedback text-center">@lang('validation.max.string',['attribute'=>'المعلومات الأخرى','max'=>150])</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputActive" class="col-sm-auto w-75px col-form-label text-right">الحالة</label>
                        <div class="col-sm">
                            <select id="inputActive" name="active" class="form-control" required>
                                <option value="1" selected>تفعيل</option> 
                                <option value="0">عدم التفعيل</option> 
                            </select>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">تحديث</button>
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
            var addAction = "{{ url('/cp/countries') }}";
            var editAction = "{{ url('/cp/countries/edit') }}";
            var form = $('#Modal form')[0];
            
            $('.btnAdd').click(function() {
                form.reset();
                $(form).attr('action',addAction);
                $('#ModalLabel').html('إضافة بلد');
                $(form).find('.formResult').html('');
            });

            $('.btnEdit').click(function() {
                /* var tr = $(this).parent().parent(); */
                var tr = $(this).closest('tr');
                $(form).attr('action',editAction);
                $('#ModalLabel').html('تعديل بلد');
                $(form).find('.formResult').html('');
                $(form).find('input[name="id"]').val(tr.data('id'));
                $(form).find('select[name="active"]').val(tr.data('active'));
                $(form).find('input[name="name"]').val(tr.find('td[data="name"]').html());
                $(form).find('textarea[name="extra"]').val(tr.find('td[data="extra"]').html());
            });
    </script>
@endsection