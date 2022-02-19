<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/png"   href="{{ url('images/logo.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/sheets-of-paper.css') }}">

</head>

<body class="document">

    <style>

        /* arabic */

        @font-face {
            font-family: 'Tajawal';
            font-style: normal;
            font-weight: 400;
            src: url( {{ url('fonts/Tajawal/Tajawal-Medium.ttf') }} );
        }

        body {
            direction: rtl;
            font-family: Tajawal;
        }

        .header {
            text-align: center;
            display: flex;
            align-items: center;
            justify-content: center;
            padding-bottom: 20px;
            border-bottom: 1px solid #000;
            margin-bottom: 20px;
        }

        .header img {
            height: 80px;
        }

        .header .title {
            font-size: 24px;
            text-align: right;
            padding-right: 10px;
            margin: 0;
        }

        .page-title {
            text-align: center;
            font-size: 18px;
            text-decoration: underline;
            text-underline-position: under;
        }

        .info {
            display: flex;
            justify-content: space-between;
        }

        .info ul {
            padding: 0;
            list-style: none;
            max-width: 50%;
        }

        .info ul li {
            line-height: 1.5;
        }

        table {
            page-break-inside: auto !important;
        }

        .table {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
        }

        .table th , .table td {
            padding: 7px;
            border: 1px solid #ddd;
          }
        .content ul {
            padding: 0;
            list-style: none;
        }

        .content ul li {
            line-height: 1.5;
        }
    </style>

    <div class="page">

        <div class="header">
            <img src="{{ url('images/logo-with-title-black.png') }}" />
        </div>

        <h2 class="page-title">فاتورة شحن</h2>

        <div class="info">
            <ul>
                <li><b>رقم العضوية / </b><bdi>{{ $invoices[0]->customer->code }}</bdi></li>
                <li><b>اسم الزبون / </b>{{ $invoices[0]->customer->name }}</li>
            </ul>
        </div>

        <div class="content">

            <table class="table" style="margin-top: 20px;">
                <thead>
                    <tr style="background-color: #bbb;">
                        <th>رقم الفاتورة</th>
                        <th>رمز الشحنة</th>
                        <th>الوزن</th>
                        <th>الوزن الحجمي</th>
                        <th>الحجم(CBM)</th>
                        <th>التكلفة</th>
                        <th>المدفوع</th>
                        {{-- <th>الإجمالي</th> --}}
                    </tr>
                </thead>
                <tbody>

                    @foreach($invoices as $invoice)
                        <tr>
                            <td>{{ $invoice->id }}</td>
                            <td>{{ $invoice->shipment_code }}</td>
                            <td>kg<bdi>{{ $invoice->weight }}</bdi></td>
                            <td>kg<bdi>{{ $invoice->volumetric_weight }}</bdi></td>
                            <td>CBM<bdi>{{ $invoice->cubic_meter }}</bdi></td>
                            <td>{!! $invoice->total_cost() !!}</td>
                            <td>{!! $invoice->paid() !!}</td>
                            {{-- <td><bdi>{{ $invoice->total_cost }}</bdi>د.ل</td> --}}
                        </tr>
                    @endforeach

                </tbody>
            </table>

            {{-- Start sum of weights and size --}}
            <table class="table" style="margin-top: 20px;">
                <thead>
                    <tr style="background-color: #bbb;">
                        <th>عدد الشحنات</th>
                        <th>إجمالي الوزن</th>
                        <th>إجمالي الوزن الحجمي</th>
                        <th>إجمالي الحجم</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td><bdi>{{ $invoices->count() }}</bdi></td>
                        <td>kg<bdi>{{ $invoices->sum('weight') }}</bdi></td>
                        <td>kg<bdi>{{ $invoices->sum('volumetric_weight') }}</bdi></td>
                        <td>cbm<bdi>{{ $invoices->sum('size') }}</bdi></td>
                    </tr>

                </tbody>
            </table>
            {{-- End sum of weights and size --}}


            {{-- Start total paid up grouped by currencies --}}
            <table class="table" style="margin-top: 20px;">
                <thead>
                    <tr style="background-color: #bbb;">
                        <th>#</th>
                        <th>المدفوع</th>
                        <th>العملة</th>
                        <th>عدد الشحنات</th>
                    </tr>
                </thead>
                <tbody>

                    @foreach($total_paid_by_currencies as $paid)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $paid['amount'] }}</td>
                        <td>{{ $paid['currency'] }}</td>
                        <td>{{ $paid['count'] }}</td>
                    </tr>
                    @endforeach

                </tbody>
            </table>
            {{-- End total paid up grouped by currencies --}}

            <table class="table" style="margin-top: 20px;">
                <thead>
                    <tr style="background-color: #bbb;">
                        <th>إجمالي التكلفة</th>
                        <th>المدفوع</th>
                        <th>الموظف</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td><bdi>{{ $invoices->sum(function ($shipment) { return $shipment['total_cost'] * $shipment['exchange_rate'];}) }}</bdi>{{ app_settings()->currency->sign }}</td>
                        <td><bdi>{{ $invoices->sum(function ($shipment) { return $shipment['paid_up'] * $shipment['paid_exchange_rate'];}) }}</bdi>{{ app_settings()->currency->sign }}</td>
                        <td><bdi>{{ Auth::user()->name }}</bdi></td>
                        <td><bdi>{{ date('Y-m-d g:ia') }}</bdi></td>
                    </tr>

                </tbody>
            </table>

        </div>

    </div>


    <script>
        print();
    </script>

</body>

</html>
