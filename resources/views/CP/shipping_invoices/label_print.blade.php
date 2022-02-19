<!DOCTYPE html>
<html lang="ar">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ config('app.name') }}</title>
    <link rel="icon" type="image/png"   href="{{ url('images/logo.png') }}">
    <link rel="stylesheet" type="text/css" href="{{ url('css/label-sheets-of-paper.css') }}">

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
            padding-bottom: 4px;
            border-bottom: 0.5px solid #000;
            margin-bottom: 4px;
        }

        .header img {
            height: 40px;
        }

        .header .title {
            font-size: 100px;
            text-align: right;
            padding-right: 10px;
            margin: 0;
        }

        .page-title {
            text-align: center;
            font-size: 16px;
            text-decoration: underline;
            text-underline-position: under;
            margin: 0;
        }

        .info {
            display: flex;
            font-size: 13PX;
            width: 100%;
        }

        .info ul {
            padding: 0;
            list-style: none;
            max-width: 100%;
            margin: 0px;
            margin-right: 10px;
            margin-top: 7px;

        }

        .info ul li {
            line-height: 1;
            width: auto;
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

        <h2 class="page-title">رقم العضوية :- ELL{{ substr($invoice->customer->code, 1) }}</h2>
        <h2 class="page-title">المدينة :- {{ $invoice->receivingPlace->name }}</h2>

        <div class="info">
            <ul>
                <li><b>رقم الفاتورة / </b><bdi>{{ $invoice->id }}</bdi></li>
                <li><b>رقم التتبع / </b>{{ $invoice->tracking_number }}</li>
                <li><b>رمز الشحنة / </b>{{ $invoice->shipment_code }}</li>
            </ul>
        </div>
        <div class="info" style="border-bottom: groove;">
            <ul>
                <li><b>اسم الزبون / </b><bdi>{{ $invoice->customer->name }}</bdi></li>
                <li><b>رقم الهاتف / </b>{{ $invoice->customer->phone }}</li>
                <li><b>العنوان / </b>{{ $invoice->customer->address }}</li>
            </ul>
            <ul>
                <div style="text-align-last: center;">
                    <img width="70px" src="{{ url('images/qr-code.png') }}" />
                </div>
            </ul>
        </div>
        <div class="info" style="justify-content: space-between;">
            <ul>
                <li><b>بنغازي / </b><bdi>0914858527</bdi></li>
                <li><b>طرابلس / </b>0919485773</li>
                <li><b>مصراته / </b>0911996311</li>
            </ul>
            <ul>
                <h1 style="FONT-SIZE:8PX; margin:0px;" >WWW.ELECTROLIBYA.COM</h1>
            </ul>
        </div>

    </div>


    <script>
        //  print();
        //  window.onafterprint = function(e) { window.close() };
        // onAfterClose = function() {
        //     history.go(-1);
        // };
    </script>

</body>

</html>
