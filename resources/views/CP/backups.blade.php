@extends('CP.layouts.header-footer')
@section('content')



    <!--    Start header    -->
    <div class="d-flex justify-content-between">
        <h4 class="font-weight-bold">النسخ الاحتياطية {{ count($files) }}</h4>
        @if(hasRole('backups_add'))
            <button class="btn btn-primary btnAdd" data-toggle="modal" data-active="0" data-target="#Modal">
                <i class="fas fa-plus mx-1"></i>أحذ تسخة احتياطية
            </button>
        @endif
    </div>
    <!--    End header    -->




    {{--  Start box backups  --}}
    <div class="card card-shadow my-4 text-center">

        <!--    Start show backups   -->
        <div class="card-body p-0">

            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">الملف</th>
                        <th scope="col">التاريخ</th>
                        <th scope="col">الحجم</th>
                        <th scope="col">خيارات</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- Start print backups -->
                    @foreach($files as $file)
                        <tr>
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td><bdi>{{ $file['name'] }}</bdi></td>
                            <td><bdi>{{ $file['date']}}</bdi></td>
                            <td><bdi>{{ $file['size'] }}</bdi></td>
                            <td>
                                @if(hasRole('backups_download'))
                                    <a class="btn btn-secondary btn-sm" href="{{ url('cp/backups',$file['name']) }}" >
                                        <i class="fa fa-download"></i>
                                    </a>
                                    @endif

                                @if(hasRole('backups_delete'))
                                    <button type="button" class="btn btn-danger btn-sm btnDelete" data-toggle="modal" data-target="#deleteModel" data-id="{{ $file['name'] }}">
                                        <i class="fas fa-trash fa-fx"></i>
                                    </button>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                    <!-- End print backups -->

                </tbody>
            </table>

        </div>
        <!--    End show backups   -->


    </div>
    {{--  End box backups  --}}




@if(hasRole('backups_delete'))

    {{--     Start Modal deleteModel --}}
    <div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModelLabel">حذف نسخة احتياطية</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>

                <form class='formSendAjaxRequest' redirect-to="{{ Request::url() }}" refresh-seconds='2' action="{{ url('cp/backups') }}" method="post">

                    <div class="modal-body text-right">
                        <div class="formResult text-center"></div>
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="id" />
                        هل أنت متأكد أنك تريد حذف الملف ؟
                    </div>

                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">حذف</button>
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">إلغاء</button>
                    </div>

                </form>

            </div>
        </div>
    </div>
    {{--     End Modal deleteModel    --}}

@endif



@if(hasRole('backups_add'))

    <!--    Start Add Modal  -->
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">أخذ نسخة احتياطية</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class='formSendAjaxRequest was-validated' refresh-seconds='2' action="{{ url('/cp/backups') }}" method="post"
                        msgSuccess="سيتم إرسال إليك رسالة على البريد الإلكتروني عندما يتم الإنتهاء من أخذ النسحة الاحتياطية">

                    <div class="modal-body px-sm-5">
                        <div class="formResult text-center"></div>
                        {{ csrf_field() }}
                        <div class="form-group row">
                            <label for="inputType" class="col-sm-auto w-75px col-form-label text-right">النوع</label>
                            <div class="col-sm">
                                <select id="inputType" name="type" class="form-control" required>
                                    <option value="0" selected>الكل</option>
                                    <option value="1">قاعدة البيانات</option>
                                    <option value="2">الملفات</option>
                                </select>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">أخذ</button>
                        <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--    End Add Modal  -->

@endif



@endsection


@section('extra-js')
    <script>

        @if(hasRole('backups_add'))
            var form = $('#Modal form')[0];

            $('.btnAdd').click(function() {
                form.reset();
                $(form).find('.formResult').html('');
            });
        @endif

        @if(hasRole('backups_delete'))
            {{-- /*  When click on btnDelete that for delete item , change id in deleteModel */ --}}
            $('.btnDelete').click(function () {
                $('#deleteModel form input[name="id"]').val($(this).data('id'));
            });
        @endif

    </script>
@endsection
