<!doctype html>
<html lang="ar">

<head>
    <title>@yield('title',config('app.name'))</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <link href="https://fonts.googleapis.com/css?family=Tajawal&display=swap" rel="stylesheet">
</head>

<body
    style="box-sizing: border-box; padding: 0; margin: 0; direction: rtl; text-align: right; font-family: 'Tajawal', sans-serif; font-size: 16px; background-color: #1F415F;">


    {{-- Start container --}}
    <div style="max-width: 720px; min-width: fit-content; padding: 10px; margin: 10px auto;">

        {{-- Start header --}}
        <h1 style="margin: 15px 0;">
            <a href="{{ url('/') }}" title="{{ config('app.name') }}" style="max-height: 62px; display: block;">
                <img src="{{ url('images/logo-with-title.png') }}" style="max-height: 60px;" />
            </a>
        </h1>
        {{-- End header --}}


        {{-- Start card-content --}}
        <div
            style="background-color: #fff; border-radius: 5px; box-shadow: 0 .5rem 1rem rgba(0,0,0,.15); padding: 20px;">

            <h2 style="text-align: center;  margin:0; font-size: 1.35em;">@yield('subject')</h2>

            <div style="border-bottom:1px solid #999; margin: 20px auto;"></div>


            {{-- Start content of email --}}
            <div style="margin: 30px 0;">

                <p>أهلاً بك سيد/ة <b><bdi>{{ $customer->name }}</bdi></b>...</p>

                @yield('content')

            </div>
            {{-- End content of email --}}


            {{-- Start footer-content --}}
            <h4 style="margin-bottom: 10px;">لاي استفسار يمكنك مراسلتنا على</h4>

            <div style="direction: ltr; text-align: right;">

                <div>{{ app_settings()->email }}</div>

                <a style="color:inherit;" href="{{ url('/contact') }}">{{ url('/contact') }}</a>

            </div>

            <div style="margin-top: 20px; margin-bottom: 10px;">شكرا لك<br/>{{ config('app.name') }}</div>
            {{-- End footer-content --}}


        </div>
        {{-- End card-content --}}


        {{-- Start footer --}}
        <div style="margin-top: 10px; text-align: center; color: #eee;">
            <a style="color:inherit;" href="{{ url('/') }}">{{ url('/') }}</a>
        </div>
        {{-- Start End --}}


    </div>
    {{-- End container --}}



</body>

</html>
