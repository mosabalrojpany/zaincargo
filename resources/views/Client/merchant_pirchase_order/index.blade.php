@extends('Client.layouts.app')

@section('content')
    {{-- Start box orders --}}
    <div class="card card-shadow my-4 text-center">

        <!-- Start search  -->

        <div class="card-header bg-primary text-white">
            <form class="justify-content-between" action="{{ Request::url() }}" method="get">
                <input type="hidden" name="search" value="1">

                <div class="form-inline">
                    <span class="ml-2"><i class="fa fa-filter"></i></span>
                    <div class="form-group">
                        <label class="d-none" for="inputIdSearch">رقم الطلب</label>
                        <input type="number" name="id" min="1" value="" placeholder="رقم الطلب" id="inputIdSearch"
                            class="form-control mx-sm-2" value="{{ Request::get('id') }}">
                    </div>

                    <div class="form-group">
                        <label class="d-none" for="inputStateSearch">الحالة</label>
                        <select id="inputStateSearch" class="form-control mx-sm-2 setValue" style="width: 220px;"
                            name="state" value="{{ Request::get('state') }}">
                            <option value="">كل الحالات</option>
                            <option value="5">تم الدفع</option>
                            <option value="7">تم الشراء</option>
                            <option value="6">مكتمل</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label class="d-none" for="inputMerchant_stateSearch">الحالة</label>
                        <select id="inputMerchant_stateSearch" class="form-control mx-sm-2 setValue" style="width: 220px;"
                            name="merchant_state" value="{{ Request::get('merchant') }}">
                            <option value="">الكل </option>
                            <option value="1">لم يتم السداد</option>
                            <option value="2">تم السداد</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                </div>


                {{-- Start dates fields search --}}
                <div class="form-inline mt-2">
                    <span class="ml-2"><i class="fa fa-filter"></i></span>
                    <div class="form-group">
                        <label for="inputOrderedAtFromDate">تاريخ الشراء من</label>
                        <input type="date" name="ordered_at_from" value="{{ Request::get('ordered_at_from') }}"
                            id="inputOrderedAtFromDate" class="form-control mx-sm-2">
                    </div>
                    <div class="form-group">
                        <label for="inputOrderedAtToDate">إلى</label>
                        <input type="date" name="ordered_at_to" max="{{ date('Y-m-d') }}"
                            value="{{ Request::get('ordered_at_to') }}" id="inputOrderedAtToDate"
                            class="form-control mx-sm-2">
                    </div>
                    <button type="submit" class="btn btn-primary d-none"><i class="fa fa-search"></i></button>
                </div>
                {{-- End dates fields search --}}


            </form>
        </div>

        <!-- End search  -->


        <!--    Start show orders   -->
        <div class="card-body p-0">
            <table class="table table-center table-striped table-hover">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">رقم الطلب</th>
                        <th scope="col">عمولة الشراء</th>
                        <th scope="col">التكلفة</th>
                        <th scope="col">الاجمالي</th>
                        <th scope="col">تاريخ الشراء</th>
                        <th scope="col">سداد الفاتورة</th>
                        <th scope="col">الحالة</th>
                        <th scope="col">تعديل</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- Start print orders -->
                    @foreach ($orders as $order)

                        <tr id="{{ $order->id }}">
                            <th scope="row">{{ $loop->iteration }}</th>
                            <td><a target="_blank" href="{{ url('client/merchant_prchase_order/show', $order->id) }}">{{ $order->id }}</a>
                            </td>
                            <td>{{ $order->fee }}</td>
                            <td>{{ $order->getCost() }}</td>
                            <td>{{ $order->total_cost }}</td>
                            @if ($order->ordered_at)
                                <td>{{ $order->ordered_at('y-m-d') }}</td>
                            @else
                                <td>لم يتم الشراء</td>
                            @endif
                            @if ($order->merchant_state == 1)
                                <td>لم يتم السداد</td>
                            @else
                                <td>تم السداد</td>
                            @endif
                            <td>{{ $order->getState() }}</td>
                            <td>
                                @if ($order->state < 6)
                                    <button type="button" id="changestate" class="btn btn-primary btn-sm paymentdone">
                                        <i class="fas"> تم الشراء</i>
                                    </button>
                                    <button id="" class="btn btn-danger btn-sm removeorder" data-toggle="modal" data-target="#Modal">
                                        <i class="fas">رفض</i>
                                    </button>
                                @endif
                            </td>
                        </tr>

                    @endforeach
                    <!-- End print orders -->

                </tbody>
            </table>
        </div>
        <!--    End show orders   -->

    </div>
    {{-- End box orders --}}



    {{-- pagination --}}
    <div class="pagination-center">{{ $orders->links() }}</div>


    <!--    Start Modal Modal سبب الرفض-->
    <div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="ModalLabel">رفض فاتورة </h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <form class='formSendAjaxRequest was-validated' refresh-seconds='2' action="{{ url('client/merchant_prchase_order') }}"
                    method="get">
                    <div class="modal-body px-sm-5">
                        <div class="alert alert-warning text-right" id="alertMsgPassword">توضيح سبب الرفض</div>
                        <div class="formResult text-center"></div>
                        {{ csrf_field() }}
                        <input type="hidden" name="id" />
                        <input type="hidden" name="state" value="2" />
                        <div class="form-group row">
                            <label for="inputMerchant_note" class="col-sm-auto w-125px col-form-label text-right">سبب الرفض</label>
                            <div class="col-sm">
                                <input type="text" name="merchant_note" class="form-control" id="merchant_note"
                                    placeholder="سبب الرفض" pattern=".{1,200}" required>
                                <div class="invalid-feedback text-center">@lang('validation.between.string',[
                                    'attribute'=>'سبب الرفض','min'=> 1,'max'=>200])</div>
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
        var form = $('#Modal form')[0];

        $('.removeorder').click(function() {
            var tr = $(this).closest('tr');
            $(form).find('input[name="id"]').val(tr.attr('id'));
        });
        $('.paymentdone').click(function(e) {
            var tr = $(this).closest('tr');
            $(".paymentdone").attr("disabled", true);
            $(".removeorder").attr("disabled", true);
            e.preventDefault();
            $.ajax({
                method: 'get',
                url: "{{ url('client/merchant_prchase_order') }}",
                data: {
                    '_token': "{{ csrf_token() }}",
                    state: 1,
                    id: tr.attr('id'),
                },
                success: function(result) {
                    setInterval(function() {
                        location.reload();
                    }, 1500);
                },
                error: function(reject) {
                    $(".paymentdone").attr("disabled", false);
                    $(".removeorder").attr("disabled", false);
                    var response = $.parseJSON(reject.responseText);
                    $("#error4_error2").text(response.error1);
                    if (reject.status == 403) {
                        var response = $.parseJSON(reject.responseText);
                        $("#errors_error").text(response.errors);
                    }

                }


            });
        });
    </script>
@endsection
