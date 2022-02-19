
@extends('Client.layouts.app')

@section('content')


    @php
        $showExtraFields = $order->state > 3 ? '' : 'd-none';
    @endphp


    <!--  Start path  -->
    <div class="d-flex align-items-center bg-white mb-3 d-print-none">

        <nav class="col pr-0" aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb bg-white mb-0">
                <li class="breadcrumb-item">
                    <a href="{{ url('client/merchant_prchase_order') }}">طلبات الشراء</a>
                </li>
                <li class="breadcrumb-item active text-truncate col pr-0 text-right" aria-current="page">
                    <span class="mr-1">{{ $order->id }}</span>
                </li>
            </ol>
        </nav>

    </div>
    <!--  End path  -->



    <div class="card card-shadow">

        {{--  Start header of Order  --}}
        <div class="card-header text-right bg-white pt-4">

            <div class="row">

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

                @if($order->isOrderDone())
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px">تاريخ الشراء</label>
                            <div class="col text-secondary"><bdi>{{ $order->ordered_at() }}</bdi></div>
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

            </div>

        </div>
        {{--  End header of Order  --}}


        {{--  Start items of Order  --}}
        <div class="card-body">


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
                        <div class="media-body">
                            <div class="row justify-content-between">
                                <div class="col">
                                    <h5 class="my-0 f-18px font-weight-bold"> الكترو ليبيا </h5>
                                    <span class="text-muted d-inline-block f-15px">
                                        <i class="far fa-clock ml-1"></i><bdi>{{ $comment->created_at() }}</bdi>
                                    </span>
                                </div>
                                <div class="col-auto">
                                </div>
                            </div>
                            <p class="mt-1 mb-0 pre-wrap comment-content">{{ $comment->comment }}</p>
                        </div>
                    </li>
                @endforeach
                {{-- End print comments --}}
            </ul>
        </div>
    </div>
    {{-- End comments --}}

@endsection


@section('extra-js')

    <script>
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
    </script>

@endsection
