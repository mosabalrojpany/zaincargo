@extends('CP.layouts.header-footer')
@section('content')



<div class="container mt-5">

    <!--    Start header    -->
    <div class="d-flex justify-content-between">
        <h4 class="font-weight-bold">أنواع الأخبار {{ count($tags) }}</h4>
        <button class="btn btn-primary w-100px" data-toggle="modal" data-active="0" data-target="#addModel">
            <i class="fas fa-plus mx-1"></i>أضف
        </button>
    </div>
    <!--    End header    -->



    
<!--    show errors if they exist   -->
@include('layouts.errors')




    <!--    Start show tags   -->
    <table class="table text-center mt-4 bg-white">
        <thead>
            <tr>
                <th scope="col">#</th>
                <th scope="col">الاسم</th>
                <th scope="col">الوصف</th>
                <th scope="col">تعديل</th>
            </tr>
        </thead>
        <tbody>

            <!-- Start print tags -->
            @foreach($tags as $tag)
            <tr data-id='{{ $tag->id }}' data-active='{{ $tag->active }}' class="<?= ($tag->active)? '':'table-danger' ?>">
                <th scope="row">{{1+$loop->index}}</th>
                <td data="name">{{ $tag->name }}</td> 
                <td data="desc">{{ $tag->desc }}</td> 
                <td><button type="button" class="btn btn-primary btn-sm btnEdit" data-toggle="modal" data-target="#editModel"><i class="fas fa-pen"></i></button></td>
            </tr> 
            @endforeach
            <!-- End print tags -->

        </tbody>
    </table>
    <!--    End show tags   -->

</div>



<!--    Start Modal addModel -->
<div class="modal fade" id="addModel" tabindex="-1" role="dialog" aria-labelledby="addModelLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addModelLabel">إضافة نوع حملة توعية</h5>
                <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>

            <form class='formSendAjaxRequest was-validated' refresh-seconds='2' action="{{ url('/cp/tags') }}" method="post" >
                <div class="modal-body px-sm-5">
                    <div class="formResult text-center"></div>
                    {{ csrf_field() }}
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-auto w-75px col-form-label text-right">الاسم</label>
                        <div class="col-sm">
                            <input type="text" name="name" class="form-control" id="inputName" placeholder="الاسم بالعربي"  pattern="\s*([0-9A-Za-z\u0621-\u064A]\s*){3,32}" title="@lang('messages.stringBetwen3And64')"
                                required>
                            <div class="invalid-feedback text-center">@lang('messages.stringBetwen3And64')</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputDesc" class="col-sm-auto w-75px col-form-label text-right">الوصف</label>
                        <div class="col-sm">
                            <textarea name="desc" rows="3" class="form-control" id="inputDesc" placeholder="وصف مختصر" maxlength="150"></textarea>
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
                    <button type="submit" class="btn btn-primary">إضافة</button>
                    <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">إلغاء</button>
                </div>
            </form>

        </div>
    </div>
</div>
<!--    End Modal addModel -->



<!--    Start Modal editModel -->
<div class="modal fade" id="editModel" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="editModalLabel">تعديل نوع حملة توعية</h5>
                <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class='formSendAjaxRequest was-validated' refresh-seconds='2' action="{{ url('/cp/tags/edit') }}" method="post">
                <div class="modal-body px-sm-5">
                    <div class="formResult text-center"></div>
                    {{ csrf_field() }}
                    <input type="hidden" name="id" />
                    <div class="form-group row">
                        <label for="inputNameEdit" class="col-sm-auto w-75px col-form-label text-right">الاسم</label>
                        <div class="col-sm">
                            <input type="text" name="name" class="form-control" id="inputNameEdit" placeholder="الاسم بالعربي" pattern="\s*([0-9A-Za-z\u0621-\u064A]\s*){3,32}" title="@lang('messages.stringBetwen3And64')"
                                required>
                            <div class="invalid-feedback text-center">@lang('messages.stringBetwen3And64')</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputDescEdit" class="col-sm-auto w-75px col-form-label text-right">الوصف</label>
                        <div class="col-sm">
                            <textarea name="desc" rows="3" class="form-control" id="inputDescEdit" placeholder="وصف مختصر" maxlength="150"></textarea>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputActiveEdit" class="col-sm-auto w-75px col-form-label text-right">الحالة</label>
                        <div class="col-sm">
                            <select id="inputActiveEdit" name="active" class="form-control" required>
                                <option value="1">تفعيل</option> 
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
<!--    End Modal editModel -->



@endsection


@section('extra-js')
    <script> 
            $('.btnEdit').click(function() {
                var tr = $(this).parent().parent();
                $('#editModel form .formResult ').html('');
                $('#editModel form input[name="id"]').val(tr.data('id'));
                $('#editModel form select[name="active"]').val(tr.data('active'));
                $('#editModel form input[name="name"]').val(tr.find('td[data="name"]').html());
                $('#editModel form textarea[name="desc"]').val(tr.find('td[data="desc"]').html());
            });
    </script>
@endsection