@extends('CP.layouts.header-footer')
@section('content')



<div class="container my-5">

    <!--    Start header    -->
    <div class="d-flex justify-content-between">
        <h4 class="font-weight-bold">أنواع العملات {{ count($types) }}</h4>
        <button class="btn btn-primary btnAdd w-100px" data-toggle="modal" data-active="0" data-target="#Modal">
            <i class="fas fa-plus mx-1"></i>أضف
        </button>
    </div>
    <!--    End header    -->





    <!--    Start show types   -->
    <table class="table text-center mt-4 bg-white">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">الاسم</th>
                <th scope="col">العلامة(اختصار)</th>
                <th scope="col">القيمة</th>
                <th scope="col">معلومات إضافية</th>
                <th scope="col">أضيفه في</th>
                <th scope="col">أخر تحديث</th>
                <th scope="col">تعديل</th>
            </tr>
        </thead>
        <tbody>

            <!-- Start print types -->
            @foreach($types as $type)
                <tr data-id='{{ $type->id }}' data-active='{{ $type->active }}' class="<?= ($type->active)? '':'table-danger' ?>">
                    <th scope="row">{{ $loop->iteration}}</th>
                    <td data="name">{{ $type->name }}</td>
                    <td data="sign">{{ $type->sign }}</td>
                    <td data="value">{{ $type->value }}</td>
                    <td data="extra">{{ $type->extra }}</td>
                    <td><bdi>{{ $type->createdAt() }}</bdi></td>
                    <td><bdi>{{ $type->updatedAt() }}</bdi></td>
                    <td>
                        <button type="button" class="btn btn-primary btn-sm btnEdit" data-toggle="modal" data-target="#Modal">
                            <i class="fas fa-pen"></i>
                        </button>
                    </td>
                </tr>
            @endforeach
            <!-- End print types -->

        </tbody>
    </table>
    <!--    End show types   -->

</div>


<!--    Start Modal  -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">تعديل نوع</h5>
                <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class='formSendAjaxRequest was-validated' refresh-seconds='2' action="{{ url('/cp/currency-types') }}" method="post">
                <div class="modal-body px-sm-5">

                    <div class="formResult text-center"></div>

                    {{ csrf_field() }}
                    <input type="hidden" name="id" />

                    <div class="form-group row">
                        <label for="inputName" class="col-sm-auto w-75px col-form-label text-right">الاسم</label>
                        <div class="col-sm">
                            <input type="text" name="name" class="form-control" id="inputName" placeholder="نوع العملة" pattern="\s*([^\s]\s*){3,32}" required>
                            <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'الاسم','min'=> 3 ,'max'=>32])</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputSign" class="col-sm-auto w-75px col-form-label text-right">العلامة</label>
                        <div class="col-sm">
                            <input type="text" name="sign" class="form-control" id="inputSign" placeholder="اختصار العملة مثل ($-€- د.ل)" pattern="\s*([^\s]\s*){1,3}" required>
                            <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'العلامة','min'=> 1 ,'max'=>3])</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputValue" class="col-sm-auto w-75px col-form-label text-right">القيمة</label>
                        <div class="col-sm">
                            <input type="number" name="value" class="form-control" id="inputValue" placeholder="قيمة التحويل" min="0.000001" max="999999.00" step="any" required>
                            <div class="invalid-feedback text-center">@lang('validation.digits_between',['attribute'=>'القيمة','min'=> 1 ,'max'=>6])</div>
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
            var addAction = "{{ url('/cp/currency-types') }}";
            var editAction = "{{ url('/cp/currency-types/edit') }}";
            var form = $('#Modal form')[0];

            $('.btnAdd').click(function() {
                form.reset();
                $(form).attr('action',addAction);
                $('#ModalLabel').html('إضافة نوع');
                $(form).find('.formResult').html('');
            });

            $('.btnEdit').click(function() {
                var tr = $(this).parent().parent();
                $(form).attr('action',editAction);
                $('#ModalLabel').html('تعديل نوع');
                $(form).find('.formResult').html('');
                $(form).find('input[name="id"]').val(tr.data('id'));
                $(form).find('select[name="active"]').val(tr.data('active'));
                $(form).find('input[name="name"]').val(tr.find('td[data="name"]').html());
                $(form).find('input[name="sign"]').val(tr.find('td[data="sign"]').html());
                $(form).find('input[name="value"]').val(tr.find('td[data="value"]').html());
                $(form).find('textarea[name="extra"]').val(tr.find('td[data="extra"]').html());
            });
    </script>
@endsection
