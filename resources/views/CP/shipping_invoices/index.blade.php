@extends('CP.layouts.header-footer')


@section('content')


{{--  Start header  --}}
<div class="d-flex justify-content-between">
    <h4 class="font-weight-bold">الشحنات {{ $invoices->total() }}</h4>

    <div class="d-flex">
        <button id="btnPrint" class="btn btn-secondary w-100px ml-1">
            <i class="fas fa-print mx-1"></i>طباعة
        </button>

        @if(hasRole('shipping_invoices_add'))
            <a class="btn btn-primary w-100px" href="{{ url('cp/shipping-invoices/create') }}">
                <i class="fas fa-plus mx-1"></i>أضف
            </a>
        @endif
    </div>

</div>
{{--  End header  --}}



{{--  Start box invoices  --}}
<div class="card card-shadow my-4 text-center">

    <!-- Start search  -->

    <div class="card-header bg-primary text-white">
        <form class="justify-content-between" action="{{ Request::url() }}" method="get">
            <input type="hidden" name="search" value="1">

            <div class="form-inline">
                <span class="ml-2"><i class="fa fa-filter"></i></span>
                <div class="form-group">
                    <label class="d-none" for="inputIdSearch">رقم الفاتورة</label>
                    <input type="number" name="id" min="1" value="{{ Request::get('id') }}" placeholder="رقم الفاتورة" id="inputIdSearch" class="form-control mx-sm-2">
                </div>
                <div class="form-group">
                    <label class="d-none" for="inputCodeSearch">رقم العضوية</label>
                    <input type="number" min="1" name="code" value="{{ Request::get('code') }}" placeholder="رقم العضوية" id="inputCodeSearch" class="form-control mx-sm-2">
                </div>
                <div class="form-group">
                    <label class="d-none" for="inputTrackingNumberSearch">رقم التتبع</label>
                    <input type="search" maxlength="32" name="tracking_number" value="{{ Request::get('tracking_number') }}" placeholder="رقم التتبع" id="inputTrackingNumberSearch" class="form-control mx-sm-2">
                </div>
                <div class="form-group">
                    <label class="d-none" for="inputShipmentCodeSearch">رمز الشحنة</label>
                    <input type="search" maxlength="32" name="shipment_code" value="{{ Request::get('shipment_code') }}" placeholder="رمز الشحنة" id="inputShipmentCodeSearch" class="form-control mx-sm-2">
                </div>
                <div class="form-group">
                    <label class="d-none" for="inputCustomerSearch">العنوان</label>
                    <select id="inputCustomerSearch" class="form-control mx-sm-2 setValue" style="width: 240px;" name="address" value="{{ Request::get('address') }}">
                        <option value="">كل العناوين</option>
                        @foreach($addresses as $address)
                            <option value="{{ $address->id }}">{{ $address->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </div>


            {{--  Start second line search  --}}
            <div class="form-inline mt-2">
                <span class="ml-2"><i class="fa fa-filter"></i></span>
                <div class="form-group">
                    <label class="d-none" for="inputReceivingPlacesSearch">مكان الاستلام</label>
                    <select id="inputReceivingPlacesSearch" class="form-control mx-sm-2 setValue" style="width: 183px;" name="receive_in" value="{{ Request::get('receive_in') }}">
                        <option value="">كل الأماكن</option>
                        @foreach($receiving_places as $place)
                            <option value="{{ $place->id }}">{{ $place->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="d-none" for="inputStateSearch">الحالة</label>
                    <select id="inputStateSearch" class="form-control mx-sm-2 setValue" style="width: 220px;" name="state" value="{{ Request::get('state') }}">
                        <option value="">كل الحالات</option>
                        @foreach(__('shipmentStatus.shipment_status') as $k=>$v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label for="inputReceivedAtFromDate">تاريخ التسليم من</label>
                    <input type="date" name="received_at_from" value="{{ Request::get('received_at_from') }}" id="inputReceivedAtFromDate" class="form-control mx-sm-2">
                </div>
                <div class="form-group">
                    <label for="inputReceivedAtToDate">إلى</label>
                    <input type="date" name="received_at_to" max="{{ date('Y-m-d') }}" value="{{ Request::get('received_at_to') }}" id="inputReceivedAtToDate" class="form-control mx-sm-2">
                </div>
            </div>
            {{--  End dates fields search  --}}


        </form>
    </div>

    <!-- End search  -->


    @php
        $canEdit =  hasRole('shipping_invoices_edit')
    @endphp

    <!--    Start show invoices   -->
    <div class="card-body p-0">
        <table class="table table-center table-striped table-hover" id="shipments-table">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">رقم الفاتورة</th>
                    <th scope="col">الزبون</th>
                    <th scope="col">رقم الرحلة</th>
                    <th scope="col">الحالة</th>
                    <th scope="col">رمز الشحنة</th>
                    <th scope="col">التكلفة</th>
                    <th scope="col">المدفوع</th>

                    @if($canEdit)
                        <th scope="col">تعديل</th>
                    @endif

                </tr>
            </thead>
            <tbody>

                <!-- Start print invoices -->
                @foreach($invoices as $invoice)
                    <tr>
                        <th scope="row" data-id="{{ $invoice->id }}" data-cost="{{ $invoice->total_cost }}" data-currency="{{ $invoice->currency_type_id }}" data-exchange_rate="{{ $invoice->exchange_rate }}" data-payment_currency="{{ $invoice->payment_currency_type_id }}" data-paid_exchange_rate="{{ $invoice->paid_exchange_rate }}" data-paid="{{ $invoice->paid_up }}">
                            <div class="form-group mb-0 pr-4">
                                <div class="custom-control custom-checkbox">
                                    <input type="checkbox" name="invoices[]" value="{{ $invoice->id }}" class="custom-control-input" id="customControInvoice{{ $invoice->id }}">
                                    <label class="custom-control-label" for="customControInvoice{{ $invoice->id }}">{{ $loop->iteration }}</label>
                                </div>
                            </div>
                        </th>
                        <td><a target="_blank" href="{{ url('cp/shipping-invoices',$invoice->id) }}">{{ $invoice->id }}</a></td>
                        <td>
                            <a href="{{ url('cp/customers',$invoice->customer_id) }}">
                                <bdi>{{ $invoice->customer->code }}</bdi>-{{ $invoice->customer->name }}
                            </a>
                        </td>
                        <td>
                            @if($invoice->trip_id)
                                <a href="{{ url('cp/trips',$invoice->trip_id) }}">{{ $invoice->trip_number() }}</a>
                            @else
                                -----
                            @endif
                        </td>
                        <td>{{ $invoice->getState() }}</td>
                        <td>{{ $invoice->shipment_code }}</td>
                        <td name="cost_with_currency">{!! $invoice->total_cost() !!}</td>
                        <td>{!! $invoice->paid() !!}</td>

                        @if($canEdit)
                            <td>
                                <a href="{{ url('cp/shipping-invoices/edit',$invoice->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </td>
                        @endif

                    </tr>
                @endforeach
                <!-- End print invoices -->

            </tbody>
        </table>
    </div>
    <!--    End show invoices   -->

</div>
{{--  End box invoices  --}}



{{--  pagination  --}}
<div class="pagination-center">{{ $invoices->links() }}</div>



<!--    Start Modal Print  -->
<div class="modal fade" id="PrintMultiModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-xl" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="ModalLabel">طباعة عدة شحنات</h5>
                <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form target="_blank" class="was-validated" action="{{ url('cp/shipping-invoices/print/mulitple') }}" id="printForm" method="GET">

                {{--  Start input fildes  --}}
                <div class="modal-body px-sm-5">

                    <table class="table text-center">
                        <thead>
                            <tr>
                                <th>رقم الفاتورة</th>
                                <th>التكلفة</th>
                                <th>عملة الدفع</th>
                                <th>سعر الصرف</th>
                                <th>المدفوع</th>
                            </tr>
                        </thead>
                        <tbody>
                            {{--   I will add rows like this below using JS as I need with data
                            <tr>
                                <td>
                                    <input class="form-control" readonly name="shipments[id][]" required/>
                                </td>
                                <td>
                                    <input class="form-control" readonly data-cost="10" />
                                </td>
                                <td>
                                    <select name="shipments[currency][]" class="form-control inputPaymentCurrency" required>
                                        <option value="" selected disabled>...</option>
                                        @foreach($currencies as $currency)
                                            <option value="{{ $currency->id }}" data-value="{{ $currency->value }}">{{ $currency->name }}</option>
                                        @endforeach
                                    </select>
                                </td>
                                <td>
                                    <input type="number" name="shipments[exchange_rate][]" class="form-control inputExchangRate" step="any" min="0.001" required />
                                </td>
                                <td>
                                    <input type="number" name="shipments[paid_up][]" class="form-control" step="any" min="0" required />
                                </td>
                            </tr>
                            --}}
                        </tbody>
                    </table>

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

@endsection


@section('extra-js')

    <script>

        $("#btnPrint").click(function() {
            var selected_shipments = $('#shipments-table input[name="invoices[]"][type="checkbox"]:checked');
            if(selected_shipments.length == 0) {
                alert("يرجى تحديد فواتير لطباعتهم");

                /* stop the form from submitting */
                return false;
            }

            $('#printForm tbody').html('');

            selected_shipments.each(function() {
                var tr = $(this).parents('tr');
                var th = tr.children('th');

                var paid = th.data('paid');
                var currency,exchange_rate,state;

                if(paid == null || paid == ''){
                    currency = th.data('currency');
                    exchange_rate = th.data('exchange_rate');
                    paid = th.data('cost');
                    state = 'update';
                }
                else {
                    currency = th.data('payment_currency');
                    exchange_rate = th.data('paid_exchange_rate');
                    state = 'show';
                }

                addRowInputPrice(
                    $(this).val(),
                    th.data('cost'),
                    tr.find('td[name="cost_with_currency"]').text(),
                    currency ,
                    exchange_rate,
                    paid,
                    state
                )
            });

            $('#PrintMultiModal').modal('show');

            return false;
        });

        var main_currency = {{ app_settings()->currency_type_id }};

        /* When change payment currency , set default value for exchange rate */
        $('#printForm').on('change','.inputPaymentCurrency',function(){
            var tr = $(this).parents('tr');
            tr.find('input[name="shipments[exchange_rate][]"]')
                .val($(this).find('option:selected').data('value'))
                .attr('readonly',main_currency == $(this).val());
        });

            /******** Start helper functions ********/

            /**
             *  Add row with input fildes to form(form for print shipments)
             * @param id {integer} id value
             * @param cost {float} cost value
             * @param cost_with_currency {string} cost_with_currency value
             * @param currency {integer} currency value
             * @param exchange_rate {float} exchange_rate value
             * @param paid {float} paid_up value
             * @param state {string} state of row , must be (show|update)
             */
            function addRowInputPrice(id , cost, cost_with_currency, currency, exchange_rate, paid,state) {

                var  currencySelect = `
                        <select name="shipments[currency][]" id="selectCurrency${id}" class="form-control inputPaymentCurrency" required value="${currency}">
                            @foreach($currencies as $currency)
                            <option value="{{ $currency->id }}" data-value="{{ $currency->value }}">{{ $currency->name }}</option>
                            @endforeach
                        </select>`;

                var readonly = (state  == 'update')? '' : 'readonly';

                $('#printForm tbody').append(
                    `<tr>
                        <td>
                            <input class="form-control" readonly name="shipments[id][]" value="${id}" required/>
                            <input type="hidden" name="shipments[state][]" value="${state}"/>
                        </td>
                        <td>
                            <input class="form-control" readonly value="${cost_with_currency}" data-cost="${cost}" />
                        </td>
                        <td>${currencySelect}</td>
                        <td>
                            <input type="number" ${readonly} name="shipments[exchange_rate][]" value="${exchange_rate}" class="form-control inputExchangRate" step="any" min="0.001" required />
                        </td>
                        <td>
                            <input type="number" ${readonly} name="shipments[paid_up][]" value="${paid}" class="form-control" step="any" min="0" required />
                        </td>
                    </tr>`
                    );

                    var selectCurrency = $(`#selectCurrency${id}`).val(currency);
                    readonly ? selectCurrency.attr('disabled',true).append(`<input type=hidden name="shipments[currency][]" value="${currency}" />`) : selectCurrency.change();
            }

    </script>

@endsection
