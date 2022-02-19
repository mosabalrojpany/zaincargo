
@extends('Client.layouts.app')

@section('content')


    @php
        $showExtraFields = $order->state > 3 ? '' : 'd-none';
    @endphp


    <!--  Start path  -->
    <div class="d-flex align-items-center justify-content-between mb-3">

        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb mb-0" style="background-color: transparent">
                <li class="breadcrumb-item">
                    <h4 class="mb-0">
                        <a class="text-decoration-none" href="{{ url('client/purchase-orders') }}">طلبات الشراء</a>
                    </h4>
                </li>
                <li class="breadcrumb-item active text-truncate col pr-0 text-right" aria-current="page">
                    <h4 class="mr-1 mb-0 d-inline-block">{{ $order->id }}</h4>
                </li>
            </ol>
        </nav>

        {{--  if order is new that means client can edit order  --}}
        @if($order->state == 1)
            <div class="col-auto">
                <a href="{{ url('client/purchase-orders/edit',$order->id) }}" class="btn btn-primary"><i class="fas fa-pen ml-1"></i>تعديل</a>
            </div>
        @endif

    </div>
    <!--  End path  -->



    <div class="card card-shadow">

        {{--  Start header of Order  --}}
        <div class="card-header bg-white pt-4">

            <div class="row text-right">

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">رقم الطلب</label>
                        <div class="col text-secondary">{{ $order->id }}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">الحالة</label>
                        <div class="col text-secondary">{{ $order->getState() }}</div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">تاريخ الطلب</label>
                        <div class="col text-secondary"><bdi>{{ $order->created_at() }}</bdi></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>

                @if($order->isOrderDone())
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px">تاريخ الشراء</label>
                            <div class="col text-secondary"><bdi>{{ $order->ordered_at() }}</bdi></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>
                @endif

                @if($order->isUserPaid())
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">تاريخ الدفع</label>
                        <div class="col text-secondary"><bdi>{{ $order->paid_at() }}</bdi></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>
                @endif

                @if($order->isOrderAccepted())

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px">العملة</label>
                            <div class="col text-secondary"><b>{{ $order->currency->name }}</b></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>

                    @unless($order->isCurrencyEqualsMain())
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px">سعر الصرف</label>
                            <div class="col text-secondary"><b>{{ $order->exchange_rate }}</b></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>
                    @endunless

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px">الإجمالي</label>
                            <div class="col text-secondary"><b>{{ $order->getCost() }}</b></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px">الضرائب</label>
                            <div class="col text-secondary"><b>{{ $order->tax }}</b></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px pl-0">الشحن الداخلي</label>
                            <div class="col text-secondary"><b>{{ $order->shipping }}</b></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px pl-0">عمولة الشراء</label>
                            <div class="col text-secondary"><b>{{ $order->fee }}</b></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px">التخفيض</label>
                            <div class="col text-secondary"><b>{{ $order->discount }}</b></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px pl-0">الصافي</label>
                            <div class="col"><b>{{ $order->getTotalCostByCurrency() }}</b></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>

                @endif


                @if($order->isUserPaid())

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px">عملة الدفع</label>
                            <div class="col text-secondary"><b>{{ $order->paidCurrency->name }}</b></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>

                    @unless($order->isPaidCurrencyEqualsMain())
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px">سعر الصرف</label>
                            <div class="col text-secondary"><b>{{ $order->paid_exchange_rate }}</b></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>
                    @endunless

                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px">المدفوع</label>
                            <div class="col"><b>{{ $order->getPaidByCurrency() }}</b></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>

                @endif

                @if($order->note)
                    <div class="col-md mb-3">
                        <div class="row">
                            <label class="col-auto w-125px">ملاحظة</label>
                            <div class="col text-secondary">{{ $order->note }}</div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>
                @endif

            </div>

        </div>
        {{--  End header of Order  --}}


        {{--  Start items of Order  --}}
        <div class="card-body table-responsive">


            <table class="table table-center table-bordered text-center">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>الوصف</th>
                        <th>العدد</th>
                        <th class="{{ $showExtraFields }}">السعر</th>
                        <th class="{{ $showExtraFields }}">الضريبة</th>
                        <th class="{{ $showExtraFields }}">الشحن</th>
                        <th>اللون</th>
                        <th>ملاحظة</th>
                        <th>الحالة</th>
                    </tr>
                </thead>
                <tbody>


                    @foreach($order->items as $item)

                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>
                                <a target="_blank" href="{{ $item->link }}">{{ $item->desc }}</a>
                            </td>
                            <td>{{ $item->count }}</td>
                            <td class="{{ $showExtraFields }}">{{ $item->price }}</td>
                            <td class="{{ $showExtraFields }}">{{ $item->tax }}</td>
                            <td class="{{ $showExtraFields }}">{{ $item->shipping }}</td>
                            <td style="background-color: {{ $item->color }};" title="{{ $item->color }}">
                                <bdi class="order-item-color">{{ $item->color }}</bdi>
                            </td>
                            <td>{{ $item->note }}</td>
                            <td>
                                @if($order->state == 3)
                                    <span class="text-white no-wrap py-1 px-2 rounded bg-danger">{{ $order->getState() }}</span>
                                @else
                                    <span class="text-white no-wrap py-1 px-2 rounded bg-{{ $item->getStateColor() }}">{{ $item->getState() }}</span>
                                @endif
                            </td>
                        </tr>

                    @endforeach

                </tbody>
            </table>


        </div>
        {{--  End items of Order  --}}



    </div>



    {{-- Start comments --}}
    <div class="card shadow border-0 mt-4 text-right">
        <div class="card-header bg-white py-3">
            <h4 class="mb-0">التعليقات ({{ $order->comments->count() }})</h4>
        </div>
        <div class="comments">

            <ul class="list-unstyled pr-0">

                {{-- Start print comments --}}
                @foreach ($order->comments as $comment)

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
            <form class="formSendAjaxRequest validate-on-click px-4 pb-4 pt-2" action="{{ url('client/purchase-order-comments') }}" method="POST"
                id="formAddComment" focus-on="#formAddComment" refresh-seconds="1">

                <div class="formResult my-3 text-center"></div>

                @csrf
                <input type="hidden" name="order_id" value="{{ $order->id }}" />

                <div class="form-group">
                    <h5 class="mb-3">إضافة تعليق</h5>
                    <textarea placeholder="محتوى التعليق ..." class="form-control" minlength="9" maxlength="500" name="comment" rows="3" required></textarea>
                    <div class="invalid-feedback text-center">@lang('validation.between.string',['attribute'=>'التعليق','min'=> 9 ,'max'=>500])</div>
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
                <form class='formSendAjaxRequest validate-on-click' refresh-seconds='1' action="{{ url('/client/purchase-order-comments/edit') }}" method="post">
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


@endsection


@section('extra-js')

    <script>
        $('.btnEditComment').click(function(){
            var commentBox = $(this).closest('.media');
            $('#editCommentModal form input[name="id"]').val($(commentBox).attr('id'));
            $('#editCommentModal form textarea').val($(commentBox).find('.comment-content').html());
        });
    </script>

@endsection
