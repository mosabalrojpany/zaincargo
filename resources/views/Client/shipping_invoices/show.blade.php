
@extends('Client.layouts.app')

@section('content')


    <!--  Start path  -->
    <div class="d-flex align-items-center mb-3">

        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb mb-0" style="background-color: transparent">
                <li class="breadcrumb-item">
                    <h4 class="mb-0">
                        <a class="text-decoration-none" href="{{ url('client/shipping-invoices') }}">الشحنات</a>
                    </h4>
                </li>
                <li class="breadcrumb-item active text-truncate col pr-0 text-right" aria-current="page">
                    <h4 class="mr-1 mb-0 d-inline-block">{{ $invoice->id }}</h4>
                </li>
            </ol>
        </nav>

    </div>
    <!--  End path  -->



    <div class="card card-shadow">

        {{--  Start header of invoice  --}}
        <div class="card-header bg-white pt-4">

            <div class="row text-right">

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">رقم الفاتورة</label>
                        <div class="col text-secondary" id="invoiceid">{{ $invoice->id }}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">رقم التتبع</label>
                        <div class="col text-secondary"><bdi>{{ $invoice->tracking_number }}</bdi></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">رمز الشحنة</label>
                        <div class="col text-secondary"><bdi>{{ $invoice->shipment_code }}</bdi></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">رقم الرحلة</label>
                        <div class="col text-secondary">
                            <bdi>{{ $invoice->trip_number() }}</bdi>
                        </div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px pl-0">رقم تتبع الرحلة</label>
                        <div class="col text-secondary"><bdi>{{ $invoice->trip_tracking_number() }}</bdi></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">الحالة</label>
                        <div class="col text-secondary">{{ $invoice->getState() }}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">وصف الحالة</label>
                        <div class="col text-secondary">{{ $invoice->getStateDesc() }}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">العنوان</label>
                        <div class="col text-secondary">{{ $invoice->address->name }}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">استلام في</label>
                        <div class="col text-secondary">{{ $invoice->receivingPlace->name }}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">تاريخ الاستلام</label>
                        <div class="col text-secondary"><bdi>{{ $invoice->arrived_at() }}</bdi></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">تاريخ الوصول المتوقع</label>
                        <div class="col text-secondary"><bdi>{{ $invoice->estimated_arrive_at() }}</bdi></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">تاريخ التسليم</label>
                        <div class="col text-secondary"><bdi>{{ $invoice->received_at() }}</bdi></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">الطول</label>
                        <div class="col text-secondary"><bdi>cm</bdi>{{ $invoice->length }}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">العرض</label>
                        <div class="col text-secondary"><bdi>cm</bdi>{{ $invoice->width }}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">الارتفاع</label>
                        <div class="col text-secondary"><bdi>cm</bdi>{{ $invoice->height }}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">الحجم</label>
                        <div class="col text-secondary"><bdi>CBM</bdi>{{ $invoice->cubic_meter }}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">الوزن الحجمي</label>
                        <div class="col text-secondary"><bdi>kg</bdi>{{ $invoice->volumetric_weight }}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">الوزن</label>
                        <div class="col text-secondary"><bdi>kg</bdi>{{ $invoice->weight }}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px pl-0">تكاليف الإضافية</label>
                        <div class="col text-secondary"><b>{{ $invoice->additional_cost }}</b></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">التكلفة</label>
                        <div class="col text-secondary"><b>{{ $invoice->cost }}</b></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                @unless($invoice->isCurrencyEqualsMain())
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px">سعر الصرف</label>
                            <div class="col text-secondary"><b>{{ $invoice->exchange_rate }}</b></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>
                @endunless

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">الإجمالي</label>
                        <div class="col">{!! $invoice->total_cost() !!}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>
                @if($invoice->Insurance == null && $invoice->trip_id == null)
                <button class="btn btn-primary w-100px btnAdd" id="ins" style="width: 47px !important;height: 39px;" data-toggle="modal" data-active="0" data-target="#Modal">
                    <i class="fas fa-plus mx-1"></i>
                </button>
                @endif
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px ">قيمة التأمين</label>
                        <div class="col">{!! $invoice->Insuranceogitem() !!}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                @if($invoice->received_at)

                    @unless($invoice->isPaidCurrencyEqualsMain())
                        <div class="col-md-6 col-lg-4 mb-3">
                            <div class="row">
                                <label class="col-auto w-125px">سعر الصرف</label>
                                <div class="col text-secondary"><b>{{ $invoice->paid_exchange_rate }}</b></div>
                            </div>
                            <div class="border-b mb-1"></div>
                        </div>
                    @endunless

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px">المدفوع</label>
                            <div class="col text-secondary"><b>{!! $invoice->paid() !!}</b></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>

                @endif

                <div class="col-md-12 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">ملاحظة</label>
                        <div class="col text-secondary">{{ $invoice->note }}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

            </div>

        </div>
        {{--  End header of invoice  --}}



        {{--  Start items of invoice  --}}
        <div class="card-body px-0">

            <div class="container">

                <div class="row">

                    @foreach($invoice->items as $item)

                        <div class="col-auto my-3">
                            <a target="_blank" href="{{ $item->getImage() }}">
                                <img class="img-thumbnail avatar-invoice-item" src="{{ $item->getImageAvatar() }}" />
                            </a>
                        </div>

                    @endforeach

                </div>

            </div>

        </div>
        {{--  End items of invoice  --}}



    </div>


    {{-- Start comments --}}
    <div class="card shadow border-0 mt-4 text-right">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0">التعليقات ({{ $invoice->comments->count() }})</h4>
        </div>
        <div class="comments">

            <ul class="list-unstyled pr-0">

                {{-- Start print comments --}}
                @foreach ($invoice->comments as $comment)

                    <li id="{{ $comment->id }}" class="media p-4">

                        <img src="{{ $comment->getImageForCustomerSide() }}" class="ml-3 w-50px rounded-circle" alt="...">

                        <div class="media-body">
                            <div class="row justify-content-between">

                                <div class="col">
                                    <h5 class="my-0 f-18px font-weight-bold">{{ $comment->getCommenterForCustomerSide() }}</h5>
                                    <span class="text-muted d-inline-block f-15px">
                                        <i class="far fa-clock ml-1"></i><bdi>{{ $comment->created_at() }}</bdi>
                                    </span>
                                </div>

                                <div class="col-auto">

                                    @if($comment->customerCanEditComment())
                                        <button type="button" class="btn btn-primary btn-sm btnEditComment" data-toggle="modal" data-target="#editCommentModal">
                                            <i class="fas fa-pen fa-fx"></i>
                                        </button>
                                    @endif

                                </div>

                            </div>
                            <p class="mt-1 mb-0 pre-wrap comment-content">{{ $comment->comment }}</p>
                        </div>

                    </li>

                @endforeach
                {{-- End print comments --}}

            </ul>

            {{-- Start Add new comment --}}
            <form class="formSendAjaxRequest validate-on-click px-4 pb-4 pt-2" action="{{url('/client/shipment-comments')}}" method="POST"
                id="formAddComment" focus-on="#formAddComment" refresh-seconds="1">

                <div class="formResult my-3 text-center"></div>

                @csrf
                <input type="hidden" name="shipment_id" value="{{ $invoice->id }}" />

                <div class="form-group">
                    <h5 class="mb-3">إضافة تعليق</h5>
                    <textarea placeholder="محتوى التعليق ..." class="form-control" minlength="3" maxlength="500" name="comment" rows="3" required></textarea>
                    <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'التعليق','min'=> 3 ,'max'=>500])</div>
                </div>

                <button type="submit" class="btn btn-primary w-100px">تعليق</button>
            </form>
            {{-- End Add new comment --}}

        </div>
    </div>
    {{-- End comments --}}


    <!--    Start Modal editCommentModal -->
    <div class="modal fade" id="editCommentModal" tabindex="-1" role="dialog" aria-labelledby="editCommentModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editCommentModalLabel">تعديل تعليق</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                </div>
                <form class='formSendAjaxRequest validate-on-click' refresh-seconds='1' action="{{ url('/client/shipment-comments/edit') }}" method="post">
                    <div class="modal-body text-right">

                        <div class="formResult text-center"></div>
                        {{ csrf_field() }}
                        <input type="hidden" name="id" />

                        <div class="form-group">
                            <textarea placeholder="محتوى التعليق ..." class="form-control" minlength="9" maxlength="500" name="comment" rows="8" required></textarea>
                            <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'التعليق','min'=> 9 ,'max'=>500])</div>
                        </div>

                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-primary">تعديل</button>
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">إلغاء</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
    <!--    End Modal editCommentModal -->

    <!--    Start قيمة الشحنة Modal -->
<div class="modal fade" id="Modal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">سعر الشحنة</h5>
                <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                                <!-- Basic Linear Progress Picker -->
                                {{-- <div class="loader" style="align-self: center;"><span class="loader-value"></span><label class="loader-shape mb-3"></label></div> --}}
                            <!-- Linear Progress end -->
                            {{-- alert sucess --}}
                            {{-- <div class="alert alert-primary mb-2" id="success-alert" role="alert">
                                <strong>تم التعديل بنجاح</strong>
                            </div> --}}
                            {{-- end alert --}}
            <form class='formSendAjaxRequest was-validated' refresh-seconds='2' action="{{route('shipping.Insurance')}}" method="post">
                <div class="modal-body px-sm-5">
                    <div class="alert alert-warning text-right" id="alertMsgPassword">ننوه زبوننا انه في حال ضياع الشحنة سوق يتم تعويضك بالقيمة المصرح بها</div>
                    <div class="formResult text-center"></div>
                    {{ csrf_field() }}
                    <input type="hidden" name="id" id="id"/>
                    <input type="hidden" name="oldid" id="oldid"/>
                    <small id="id_error"
                    style="display: block;font-size: 16px;font-family: 'PhpDebugbarFontAwesome';text-align:center;color: red"></small>

                    <div class="form-group row">
                        <label for="Insurance" class="col-sm-auto w-125px pl-0 col-form-label text-right">قيمة الشحنة</label>
                        <div class="col-sm">
                            <input type="text" name="Insurance" class="form-control" id="Insurance" placeholder="قيمة الشحنة" pattern=".{1,14}">
                            <div class="invalid-feedback text-center">@lang('validation.digits_between',[ 'attribute'=>'قيمة التأمين','min'=> 1,'max'=>14])</div>
                        </div>
                    </div>
                    <small id="Insurance_error"
                    style="display: block;font-size: 16px;font-family: 'PhpDebugbarFontAwesome';text-align:center;color: red"></small>
                </div>
                <div class="modal-footer">
                    <button type="submit" id="submit" class="btn btn-primary">تحديث</button>
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
        $('.btnEditComment').click(function(){
            var commentBox = $(this).closest('.media');
            $('#editCommentModal form input[name="id"]').val($(commentBox).attr('id'));
            $('#editCommentModal form textarea').val($(commentBox).find('.comment-content').html());
        });
        // ####################### اضافة قيمة التأمين ##########################
         var form = $('#Modal form')[0];
         $('.btnAdd').click(function(e) {
             oldid = $('#invoiceid').text(),
             $(form).find('input[name="id"]').val(oldid);
         });
         $('#submit').click(function(e) {
            $(form).find('input[name="oldid"]').val(oldid);
        });
        // ####################### انتهاء اضافة قيمة التأمين ###################
    </script>
@endsection
