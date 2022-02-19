@extends('CP.layouts.header-footer')

@section('content')



    <!--  Start path  -->
    <div class="d-flex align-items-center bg-white mb-3 d-print-none">

        <nav class="col pr-0" aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb bg-white mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('cp/shipping-invoices') }}">الشحنات</a>
                </li>
                <li class="breadcrumb-item active text-truncate col pr-0 text-right" aria-current="page">
                    <span class="mr-1">{{ $invoice->id }}</span>
                </li>
            </ol>
        </nav>

        <div class="col-auto">

                <a href="{{ url('cp/shipping-invoices/printlabel',$invoice->id) }}" target="_blank" class="btn btn-secondary btn-sm">
                    <i class="fas">طباعة ملصق</i>
                </a>


            @if($invoice->isReadyToReceive())
                <button class="btn btn-secondary btn-sm" data-toggle="modal" data-target="#PrintModal">
                    <i class="fas fa-print"></i>
                </button>
            @elseif($invoice->isReceived())
                <a href="{{ url('cp/shipping-invoices/print',$invoice->id) }}" target="_blank" class="btn btn-secondary btn-sm">
                    <i class="fas fa-print"></i>
                </a>
            @endif



            @if(hasRole('shipping_invoices_edit'))
                <a href="{{ url('cp/shipping-invoices/edit',$invoice->id) }}" class="btn btn-primary btn-sm">
                    <i class="fas fa-pen"></i>
                </a>
            @endif

            @if(hasRole('shipping_invoices_delete'))
                <button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal">
                    <i class="fas fa-trash"></i>
                </button>
            @endif

        </div>

    </div>
    <!--  End path  -->



    <div class="card card-shadow">

        {{--  Start header of invoice  --}}
        <div class="card-header bg-white pt-4">

            <div class="row text-right">

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">رقم الفاتورة</label>
                        <div class="col text-secondary">{{ $invoice->id }}</div>
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
                            @if($invoice->trip_id)
                                <a href="{{ url('cp/trips',$invoice->trip_id) }}" target="_blank">
                                    <bdi>{{ $invoice->trip->trip_number }}</bdi>
                                </a>
                            @endif
                        </div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">رقم العضوية</label>
                        <div class="col text-secondary"><bdi>{{ $invoice->customer->code }}</bdi></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">اسم الزبون</label>
                        <div class="col text-secondary">
                            <a href="{{ url('cp/customers',$invoice->customer_id) }}">{{ $invoice->customer->name }}</a>
                        </div>
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
                        <label class="col-auto w-125px">تاريخ التسليم</label>
                        <div class="col text-secondary"><bdi>{{ $invoice->received_at() }}</bdi></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">تاريخ الإضافة</label>
                        <div class="col text-secondary"><bdi>{{ $invoice->created_at->format('Y-m-d g:ia') }}</bdi></div>
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
                        <label class="col-auto w-125px pl-0">العملة</label>
                        <div class="col text-secondary"><b>{{ $invoice->currency->name }}</b></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px pl-0">سعر الصرف</label>
                        <div class="col text-secondary"><b>{{ $invoice->exchange_rate }}</b></div>
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

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">الإجمالي</label>
                        <div class="col"><b>{!! $invoice->total_cost() !!}</b></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">قيمة التامين</label>
                        <div class="col"><b>{!! $invoice->Insuranceogitem() !!}</b></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">قيمة الشحنة</label>
                        <div class="col"><b>@if($invoice->Insurance==null)لا يوجد @else {!! $invoice->Insurance !!} @endif </b></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>


                @if(isset($invoice) && $invoice->trip_id && $invoice->trip->state == 3 && $invoice->received_at)

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px pl-0">عملة الدفع</label>
                            <div class="col text-secondary"><b>{{ $invoice->paidCurrency->name }}</b></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px pl-0">سعر الصرف</label>
                            <div class="col text-secondary"><b>{{ $invoice->paid_exchange_rate }}</b></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px">المدفوع</label>
                            <div class="col"><b>{!! $invoice->paid() !!}</b></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>

                @endif
                <div class="col-md-6 col-lg-4 mb-3"></div>
                <div class="col-md-6 col-lg-4 mb-3"></div>
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px pl-0">أضيفة بواسطة</label>
                        <div class="col text-secondary">{{ $invoice->user->name }}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3"></div>

                <div class="col-md-6 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">ملاحظة</label>
                        <div class="col text-secondary">{{ $invoice->note }}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px pl-0">معلومات أخرى</label>
                        <div class="col text-secondary">{{ $invoice->extra }}</div>
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
    @if(hasRole(['shipment_comments_show','shipment_comments_add']))

        <div class="card shadow border-0 mt-4 text-right">
            <div class="card-header bg-white py-3">
                <h4 class="mb-0">التعليقات</h4>
            </div>
            <div class="comments">

                @if(hasRole('shipment_comments_show'))

                    <ul class="list-unstyled pr-0">

                        @foreach ($invoice->comments as $comment)

                            <li id="{{ $comment->id }}" class="media p-4 {{ $comment->customer_id ? 'customer' : '' }} {{ !$comment->userCanEditComment() && $comment->unread ? 'bg-light' : '' }}">

                                <img src="{{ $comment->getImage() }}" class="ml-3 w-50px rounded-circle" alt="...">

                                <div class="media-body">

                                    <div class="row justify-content-between">
                                        <div class="col">
                                            <h5 class="my-0 f-18px font-weight-bold">{{ $comment->getCommenter() }}</h5>
                                            <span class="text-muted d-inline-block f-15px">
                                                <i class="far fa-clock ml-1"></i><bdi>{{ $comment->created_at() }}</bdi>
                                            </span>
                                        </div>
                                        <div class="col-auto">

                                            @if(hasRole('shipment_comments_edit'))

                                                @if($comment->userCanEditComment())
                                                    <button type="button" class="btn btn-primary btn-sm btnEditComment" data-toggle="modal" data-target="#editCommentModal">
                                                        <i class="fas fa-pen fa-fx"></i>
                                                    </button>
                                                @elseif($comment->unread)
                                                    <a href="{{ url('/cp/shipment-comments/update/state',$comment->id) }}" class="btn btn-dark btn-sm text-white">
                                                        <i class="fas fa-check fa-fx"></i>
                                                    </a>
                                                @else
                                                    <a href="{{ url('/cp/shipment-comments/update/state',$comment->id) }}" class="btn btn-secondary btn-sm text-white">
                                                        <i class="fas fa-times fa-fx"></i>
                                                    </a>
                                                @endif

                                            @endif

                                            @if(hasRole('shipment_comments_delete'))

                                                <button type="button" class="btn btn-danger btn-sm btnDeleteComment" data-toggle="modal" data-target="#deleteCommentModal">
                                                    <i class="fas fa-trash fa-fx"></i>
                                                </button>

                                            @endif

                                        </div>
                                    </div>

                                    <p class="mt-1 mb-0 pre-wrap comment-content">{{ $comment->comment }}</p>
                                </div>

                            </li>

                        @endforeach

                    </ul>

                @endif

                @if(hasRole('shipment_comments_add'))

                    <form class="formSendAjaxRequest validate-on-click px-4 pb-4 pt-2" action="{{ url('cp/shipment-comments') }}" method="POST"
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

                @endif

            </div>
        </div>

    @endif
    {{-- End comments --}}




    @if(hasRole('shipment_comments_delete'))

        <!--    Start Modal deleteCommentModal -->
        <div class="modal fade" id="deleteCommentModal" tabindex="-1" role="dialog" aria-labelledby="deleteCommentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteCommentModalLabel">حذف تعليق</h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form class='formSendAjaxRequest' refresh-seconds='2' action="{{ url('/cp/shipment-comments') }}"
                        method="post">
                        <div class="modal-body text-right">
                            <div class="formResult text-center"></div>
                            @method('DELETE')
                            {{ csrf_field() }}
                            <input type="hidden" name="id" />
                            هل أنت متأكد أنك تريد حذف التعليق ؟
                            <hr/>
                            <p>{{-- I will set content of comment here using JS --}}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">حذف</button>
                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--    End Modal deleteCommentModal -->

    @endif




    @if(hasRole('shipment_comments_edit'))

        <!--    Start Modal editCommentModal -->
        <div class="modal fade" id="editCommentModal" tabindex="-1" role="dialog" aria-labelledby="editCommentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editCommentModalLabel">تعديل تعليق</h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form class='formSendAjaxRequest validate-on-click' refresh-seconds='1' action="{{ url('/cp/shipment-comments/edit') }}" method="post">
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

    @endif






    @if(hasRole('shipping_invoices_delete'))

        <!--    Start Modal deleteModal -->
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteModalLabel">حذف فاتورة</h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form class='formSendAjaxRequest' redirect-to='{{ url('/cp/shipping-invoices') }}' refresh-seconds='2' action="{{ url('/cp/shipping-invoices') }}"
                        method="post">
                        <div class="modal-body text-right">
                            <div class="formResult text-center"></div>
                            @method('DELETE')
                            {{ csrf_field() }}
                            <input type="hidden" name="id" value="{{ $invoice->id }}" />
                            هل أنت متأكد أنك تريد حذف الفاتورة ؟
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">حذف</button>
                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--    End Modal deleteModal -->

    @endif



    @if($invoice->isReadyToReceive())
        <!--    Start Modal Print  -->
        <div class="modal fade" id="PrintModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
            <div class="modal-dialog modal-lg" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="ModalLabel">طباعة فاتورة</h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <form target="_blank" id="printForm" class="was-validated" action="{{ url('cp/shipping-invoices/print',$invoice->id) }}" method="GET">

                        {{--  Start input fildes  --}}
                        <div class="modal-body px-sm-5 text-right">

                            <div class="row">

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-auto w-125px pl-0 col-form-label text-right">التكلفة</label>
                                        <div class="col pr-md-0">
                                            <input class="form-control" readonly value="{{ strip_tags($invoice->total_cost()) }}" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-auto w-125px pl-0 col-form-label text-right">عملة الدفع</label>
                                        <div class="col pr-md-0">
                                            <select name="currency" class="form-control setValue" id="inputCurrency" value={{ $invoice->currency_type_id }} required>
                                                <option value="" selected disabled>...</option>
                                                @foreach($currencies as $currency)
                                                    <option value="{{ $currency->id }}" data-value="{{ $currency->value }}">{{ $currency->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-auto w-125px pl-0 col-form-label text-right">سعر الصرف</label>
                                        <div class="col pr-md-0">
                                            <input type="number" name="exchange_rate" class="form-control" id="inputExchangeRate" step="any" min="0.001" required />
                                            <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'سعر الصرف','min'=> 0])</div>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group row">
                                        <label class="col-auto w-125px pl-0 col-form-label text-right">المدفوع</label>
                                        <div class="col pr-md-0">
                                            <input type="number" min="0" value="{{ $invoice->total_cost }}" step="any" name="paid_up" class="form-control" required>
                                            <div class="invalid-feedback text-center">@lang('validation.min.numeric',['attribute'=>'المدفوع','min'=> 0])</div>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        {{--  End input fildes  --}}

                        <div class="modal-footer">
                            <button type="submit" class="btn btn-secondary">طباعة</button>
                            <button type="button" class="btn btn-danger mr-2" data-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--    End Modal Print -->
    @endif


@endsection


@section('extra-js')

    <script>

        var main_currency = {{app_settings()->currency_type_id}}

        {{-- /* Set default value of exchange_rate depends on selected currency for cost */ --}}
        $('#inputCurrency').change(function(){
            var selected_currency = $(this).find('option:selected');
            var exchange_rate_input =  $('#inputExchangeRate');
            if(main_currency == selected_currency.val()){
                exchange_rate_input.val(1).prop("readonly", true);
            }
            else
            {
                exchange_rate_input.val(selected_currency.data('value')).prop("readonly", false);
            }
        }).change(); /* we call change() event to set default value for exchange_rate */

        $('.btnDeleteComment').click(function(){
            var commentBox = $(this).closest('.media');
            $('#deleteCommentModal form input[name="id"]').val($(commentBox).attr('id'));
            $('#deleteCommentModal form p').html($(commentBox).find('.comment-content').html());
        });

        $('.btnEditComment').click(function(){
            var commentBox = $(this).closest('.media');
            $('#editCommentModal form input[name="id"]').val($(commentBox).attr('id'));
            $('#editCommentModal form textarea').val($(commentBox).find('.comment-content').html());
        });

        $('#printForm').submit((e)=>{
            setTimeout(()=> (location.reload()),100)
        });
    </script>

@endsection
