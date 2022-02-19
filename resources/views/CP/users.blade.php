@extends('CP.layouts.header-footer')
@section('content')



<!--    Start header    -->
<div class="d-flex justify-content-between">
    <h4 class="font-weight-bold">المستخدمين {{ count($users) }}</h4>
    <button class="btn btn-primary w-100px btnAdd" data-toggle="modal" data-active="0" data-target="#Modal">
        <i class="fas fa-plus mx-1"></i>أضف
    </button>
</div>
<!--    End header    -->




{{--  Start box users  --}}
<div class="card card-shadow my-4 text-center">

    <!-- Start search  -->
    <div class="card-header bg-primary text-white">
        <form class="justify-content-between" action="{{ Request::url() }}" method="get">
            <input type="hidden" name="search" value="1">

            <div class="form-inline">
                <span class="ml-2"><i class="fa fa-filter"></i></span>
                    <div class="form-group">
                        <label class="d-none" for="inputNameSearch">الاسم</label>
                        <input type="search" maxlength="32" name="name" value="{{ Request::get('name') }}" placeholder="الاسم" id="inputNameSearch" class="form-control mx-sm-2">
                    </div>
                    <div class="form-group">
                        <label class="d-none" for="inputUserNameSearch">اسم المستخدم</label>
                        <input type="search" maxlength="32" name="username" value="{{ Request::get('username') }}" placeholder="اسم المستخدم" id="inputUserNameSearch" class="form-control mx-sm-2">
                    </div>
                    <div class="form-group">
                        <label class="d-none" for="inputPhoneSearch">رقم الهاتف</label>
                        <input type="search" maxlength="32" name="phone" value="{{ Request::get('phone') }}" placeholder="رقم الهاتف" id="inputPhoneSearch" class="form-control mx-sm-2">
                    </div>
                    <div class="form-group">
                        <label class="d-none" for="inputRoleSearch">الدور</label>
                        <select id="inputRoleSearch" class="form-control mx-sm-2 setValue" style="width: 200px;" name="role" value="{{ Request::get('role') }}">
                           {{--  I will set values using JS --}}
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="d-none" for="inputStateSearch">الحالة</label>
                        <select id="inputStateSearch" class="form-control mx-sm-2 setValue" style="width: 200px;" name="state" value="{{ Request::get('state') }}">
                            <option value="">كل الحالات</option>
                            <option value="0">غير فعال</option>
                            <option value="1">فعال</option>
                        </select>
                    </div>
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </div>

        </form>
    </div>
        <!-- End search  -->




    <!--    Start show users   -->
    <div class="card-body p-0">

        <table class="table table-striped text-center">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">الاسم</th>
                    <th scope="col">اسم المستخدم</th>
                    <th scope="col">رقم الهاتف</th>
                    <th scope="col">الدور</th>
                    <th scope="col">الفرع</th>
                    <th scope="col">أضيفه في</th>
                    <th scope="col">أخر وصول</th>
                    <th scope="col">تعديل</th>
                </tr>
            </thead>
            <tbody>

                <!-- Start print users -->
                @foreach($users as $user)
            <tr id='{{$user->id}}' data-active='{{ $user->active }}' data-role='{{ $user->role_id }}' data-branches='{{$user->branches_id }}'
                        class="<?= ($user->active)? '':'table-danger' ?>">
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td data="name">{{ $user->name }}</td>
                        <td data="username">{{ $user->username }}</td>
                        <td data="phone">{{ $user->phone }}</td>
                        <td>{{ $user->role->name }}</td>
                        <td>{{ $user->getBranchCity() }}</td>
                        <td><bdi>{{ $user->created_at->format('Y-m-d g:ia')}}</bdi></td>
                        <td>
                            @if($user->last_access)
                                <bdi>{{$user->last_access->format('Y-m-d g:ia')}}</bdi>
                            @endif
                        </td>
                        <td>
                            <button type="button" class="btn btn-primary btn-sm btnEdit" data-toggle="modal" data-target="#Modal">
                                <i class="fas fa-pen"></i>
                            </button>
                        </td>
                    </tr>
                @endforeach
                <!-- End print users -->

            </tbody>
        </table>

    </div>
    <!--    End show users   -->


</div>
{{--  End box users  --}}



<!--    Start Modal Modal -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">تعديل معلومات مستخدم</h5>
                <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form class='formSendAjaxRequest was-validated' refresh-seconds='2' action="{{ url('/cp/users/edit') }}" method="post">
                <div class="modal-body px-sm-5">
                    <div class="alert alert-warning text-right" id="alertMsgPassword">لاتكتب كلمة المرور إذا لا تريد تغيرها</div>
                    <div class="formResult text-center"></div>
                    {{ csrf_field() }}
                    <input type="hidden" name="id" />
                    <div class="form-group row">
                        <label for="inputName" class="col-sm-auto w-125px col-form-label text-right">الاسم</label>
                        <div class="col-sm">
                            <input type="text" name="name" class="form-control" id="inputName" placeholder="الاسم" pattern=".{3,32}" required>
                            <div class="invalid-feedback text-center">@lang('validation.between.string',[ 'attribute'=>'الاسم','min'=> 3,'max'=>32])</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPhone" class="col-sm-auto w-125px pl-0 col-form-label text-right">رقم الهاتف</label>
                        <div class="col-sm">
                            <input type="text" name="phone" class="form-control" id="inputPhone" placeholder="رقم الهاتف" pattern=".{3,14}" required>
                            <div class="invalid-feedback text-center">@lang('validation.digits_between',[ 'attribute'=>'رقم الهاتف','min'=> 3,'max'=>14])</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputUsername" class="col-sm-auto w-125px pl-0 col-form-label text-right">اسم المستخدم</label>
                        <div class="col-sm">
                            <input type="text" name="username" class="form-control" id="inputUsername" placeholder="اسم المستخدم" pattern=".{3,32}" required>
                            <div class="invalid-feedback text-center">@lang('validation.between.string',[ 'attribute'=>'اسم المستخدم','min'=> 3,'max'=>32])</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputPassword" class="col-sm-auto w-125px pl-0 col-form-label text-right">كلمة المرور</label>
                        <div class="col-sm">
                            <input type="text" name="password" class="form-control" id="inputPassword" placeholder="كلمة المرور" pattern=".{6,32}" >
                            <div class="invalid-feedback text-center">@lang('validation.between.string',[ 'attribute'=>'كلمة المرور','min'=> 6,'max'=>32])</div>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputRole" class="col-sm-auto w-125px col-form-label text-right">الفرع</label>
                        <div class="col-sm">
                            <select id="inputbranch" name="branches" class="form-control" required>
                                <option value="" selected>اختر...</option>
                                @foreach($branches as $branches)
                                    <option value="{{ $branches->id }}">{{ $branches->city }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputRole" class="col-sm-auto w-125px col-form-label text-right">الدور</label>
                        <div class="col-sm">
                            <select id="inputRole" name="role" class="form-control" required>
                                <option value="" selected>اختر...</option>
                                @foreach($roles as $role)
                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                @endforeach
                            </select>
                        </div>
                    </div>
                    <div class="form-group row">
                        <label for="inputActive" class="col-sm-auto w-125px col-form-label text-right">الحالة</label>
                        <div class="col-sm">
                            <select id="inputActive" name="active" class="form-control" required>
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
<!--    End Modal Modal -->



@endsection


@section('extra-js')
    <script>

            /* {{--
                Start config select(roles) --
                Copy Users Roles from input form to search form
            --}} */
            var inputRoleSearch = $('#inputRoleSearch');
            $(inputRoleSearch).html($('#inputRole').html());
            $(inputRoleSearch).val($(inputRoleSearch).attr('value'));
            $(inputRoleSearch).find('option[value=""]').html('كل الأدوار');


            var addAction = "{{ url('/cp/users') }}";
            var editAction = "{{ url('/cp/users/edit') }}";
            var form = $('#Modal form')[0];

            $('.btnAdd').click(function() {
                form.reset();
                $(form).attr('action',addAction);
                $('#ModalLabel').html('إضافة مستخدم');
                $(form).find('.formResult').html('');
                $(form).find('#alertMsgPassword').hide();
                $(form).find('input[name="id"]').val('');
                $(form).find('input[name="password"]').prop('required',true);
            });


            $('.btnEdit').click(function() {
                var tr = $(this).closest('tr');
                $(form).attr('action',editAction);
                $('#ModalLabel').html('تعديل معلومات مستخدم');
                $(form).find('.formResult').html('');
                $(form).find('#alertMsgPassword').show();
                $(form).find('input[name="password"]').prop('required',false);
                $(form).find('input[name="id"]').val(tr.attr('id'));
                $(form).find('input[name="name"]').val(tr.find('td[data="name"]').html());
                $(form).find('input[name="phone"]').val(tr.find('td[data="phone"]').html());
                $(form).find('input[name="username"]').val(tr.find('td[data="username"]').html());
                $(form).find('select[name="branches"]').val(tr.data('branches'));
                $(form).find('select[name="role"]').val(tr.data('role'));
                $(form).find('select[name="active"]').val(tr.data('active'));
            });
    </script>
@endsection
