@extends('Client.layouts.app')
@section('content')

    <!--  Start path  -->
    <div class="d-flex align-items-center bg-white mb-3 d-print-none">

        <nav class="col pr-0" aria-label="breadcrumb" role="navigation">
            {{-- Start header --}}
            <div class="d-flex justify-content-between align-items-center">
                <h4 class="font-weight-bold mb-0">حوالات مالية داخلية </h4>
                <button class="btn btn-primary w-100px" data-toggle="modal" data-active="0" data-target="#internaltransfaremoney">
                    <i class="fas fa-plus mx-1"></i>أضف
                </button>
            </div>
            {{-- End header --}}
        </nav>
    </div>
    <!--  End path  -->
    <div class="card card-shadow">
        @include('CP.elerts.errors')
        @include('CP.elerts.success')
        {{-- جدول يعرض كم عند الزبون --}}
        <div class="card-body">
            <table class="table table-center table-bordered text-center">
                <thead>
                    <tr>

                        <th>LY طرابلس</th>
                        <th>$ طرابلس</th>
                        <th>LY بنغازي</th>
                        <th>$ بنغازي</th>
                        <th>LY مصراته</th>
                        <th>$ مصراته</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>{{ $data->money_denar_t }}</td>
                        <td>{{ $data->money_dolar_t }}</td>
                        <td>{{ $data->money_denar_b }}</td>
                        <td>{{ $data->money_dolar_b }}</td>
                        <td>{{ $data->money_denar_m }}</td>
                        <td>{{ $data->money_dolar_m }}</td>
                    </tr>
                </tbody>
            </table>
        </div>
        {{-- End --}}
        {{-- Start items of Order --}}
        <div class="card-body">
            <table class="table table-center table-bordered text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>رقم الحوالة</th>
                        <th>الى الزبون</th>
                        <th>من الفرع</th>
                        <th>الى الفرع</th>
                        <th>القيمة</th>
                        <th>نوع العملة</th>
                        <th>الحالة</th>
                        <th>ملاحظة</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transfare as $transfares)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $transfares->id }}</td>
                            <td>{{ $transfares->to_customer }}</td>
                            <td>{{ $transfares->branche->city}}</td>
                            <td>{{ $transfares->branche2->city }}</td>
                            <td>{{ $transfares->price }}</td>
                            <td>{{ $transfares->currencytype->name }}</td>
                            <td>{{ $transfares->state() }}</td>
                            <td>{{ $transfares->note }}</td>
                            <td>{{ $transfares->created_at }}</td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        {{-- End items of Order --}}
        {{-- pagination --}}
        {{-- pagination --}}
        <div class="pagination-center">{{ $transfare->links() }}</div>
    </div>


    <!--    Start Modal Modal -->

    <div class="modal fade" id="internaltransfaremoney" tabindex="-1" role="dialog" aria-labelledby="ModalLabel"
        aria-hidden="true" style="display: none;">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">  حوالة مالية داخلية</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class="formSendAjaxRequest" action="{{ url('/client/internalmoneytransfare') }}" method="POST"
                    refresh-seconds='2'>
                    @csrf
                    <div class="alert-danger">
                        <small class="text-danger" id="wallet_id_error"></small>
                        <small id="errors_error"
                            style="display: block;font-size: 16px;font-family: 'PhpDebugbarFontAwesome';text-align:center;"></small>
                    </div>
                    <div class="modal-body px-sm-5">
                        <div class="formResult text-center"></div>
                        <div class="form-group row">
                            <label for="from_branch" class="col-sm-auto w-125px col-form-label text-right">من الفرع</label>
                            <div class="col-sm">
                                <select id="from_branch" name="from_branch" class="form-control">
                                    <option value="" selected>اختر...</option>
                                    @foreach ($branch as $branches)
                                        <option value="{{ $branches->id }}">{{ $branches->city }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-danger" id="from_branch_error" style="display: flex;"></small>
                            </div>
                            <small class="text-danger" id="from_branch_error"></small>
                        </div>
                        <div class="form-group row">
                            <label for="to_branch" class="col-sm-auto w-125px col-form-label text-right">الى الفرع</label>
                            <div class="col-sm">
                                <select id="to_branch" name="to_branch" class="form-control">
                                    <option value="" selected>اختر...</option>
                                    @foreach ($branch as $branches)
                                        <option value="{{$branches->id }}">{{ $branches->city }}
                                        </option>
                                    @endforeach
                                </select>
                                <small class="text-danger" id="to_branch_error" style="display: flex;"></small>
                            </div>
                            <small class="text-danger" id="to_branch_error"></small>
                        </div>
                        <div class="form-group row">
                            <label for="curancy_type" class="col-sm-auto w-125px col-form-label text-right">نوع
                                العملة</label>
                            <div class="col-sm">
                                <select id="curancy_type" name="curancy_type" class="form-control">
                                    <option value="" selected>اختر...</option>
                                    <option value="1">دينار</option>
                                    <option value="2">دولار</option>
                                </select>
                                <small class="text-danger" id="curancy_type_error" style="display: flex;"></small>
                            </div>
                            <small class="text-danger" id="curancy_type_error"></small>
                        </div>
                        <div class="form-group row">
                            <label for="to_customer" class="col-sm-auto w-125px col-form-label text-right">كود الزبون </label>
                            <div class="col-sm">
                                <input type="text" name="to_customer" class="form-control" id="to_customer" placeholder=" كود الزبون المحول له القيمة">
                                <small class="text-danger" id="to_customer_error" style="display: flex;"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="price" class="col-sm-auto w-125px col-form-label text-right amount">القيمة</label>
                            <div class="col-sm">
                                <input type="text" name="price"  class="form-control" id="price" placeholder="القيمة">
                                <small class="text-danger" id="price_error" style="display: flex;"></small>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label for="note" class="col-sm-auto w-125px pl-0 col-form-label text-right">ملاحظة</label>
                            <div class="col-sm">
                                <input type="text" name="note" class="form-control" id="note" placeholder="ملاحظة">
                                <small class="text-danger" id="note_error" style="display: flex;"></small>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-primary">تحديث</button>
                            <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">إلغاء</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!--    End Modal Modal -->
@endsection
