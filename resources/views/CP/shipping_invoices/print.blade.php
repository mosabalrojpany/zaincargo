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

        .table {
            width: 100%;
            text-align: center;
            border-collapse: collapse;
        }

        .table th , .table td {
            padding: 7px;
            border: 1px solid #ddd;
          }
        .footer ul {
            padding: 0;
            list-style: none;
        }

        .footer ul li {
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
                <li><b>رقم الفاتورة / </b><bdi>{{ $invoice->id }}</bdi></li>
                <li><b>رقم التتبع / </b>{{ $invoice->tracking_number }}</li>
                <li><b>رمز الشحنة / </b>{{ $invoice->shipment_code }}</li>
                @if($invoice->received_at)
                    <li><b>تاريخ التسليم/ </b><bdi>{{ $invoice->received_at->format('Y/m/d') }}</bdi></li>
                @endif
            </ul>
            <ul>
                <li><b>رقم العضوية / </b><bdi>{{ $invoice->customer->code }}</bdi></li>
                <li><b>اسم الزبون / </b>{{ $invoice->customer->name }}</li>
                @if($invoice->note)
                    <li><b>ملاحظة / </b>{{ $invoice->note }}</li>
                @endif
            </ul>
        </div>

        <div class="footer">

            <table class="table" style="margin-top: 20px;">
                <thead>
                    <tr style="background-color: #bbb;">
                        <th>الحجم(cm)</th>
                        <th>الوزن</th>
                        <th>الوزن الحجمي</th>
                        <th>الحجم(CBM)</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td><bdi>{{ $invoice->length.'x'.$invoice->width.'x'.$invoice->height }}</bdi></td>
                        <td>kg<bdi>{{ $invoice->weight }}</bdi></td>
                        <td>kg<bdi>{{ $invoice->volumetric_weight }}</bdi></td>
                        <td>CBM<bdi>{{ $invoice->cubic_meter }}</bdi></td>
                    </tr>

                </tbody>
            </table>

            <table class="table" style="margin-top: 20px;">
                <thead>
                    <tr style="background-color: #bbb;">
                        <th>التكلفة</th>
                        <th>ت.إضافية</th>
                        <th>إجمالي التكلفة</th>
                        <th>المدفوع</th>
                        <th>الموظف</th>
                        <th>التاريخ</th>
                    </tr>
                </thead>
                <tbody>

                    <tr>
                        <td>{{ $invoice->cost }}</td>
                        <td>{{ $invoice->additional_cost }}</td>
                        <td>{!! $invoice->total_cost() !!}</td>
                        <td>{!! $invoice->paid() !!}</td>
                        <td><bdi>{{ Auth::user()->name }}</bdi></td>
                        <td><bdi>{{ date('Y-m-d g:ia') }}</bdi></td>
                    </tr>

                </tbody>
            </table>

        </div>

    </div>


    <script>
        print();
        window.onafterprint = function(e) { window.close() };
    </script>

</body>

</html>
