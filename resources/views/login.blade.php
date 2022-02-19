<!doctype html>
<html lang="en">

<head>
    <title>Title</title>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap And Fontawsome CSS -->
    <link rel="stylesheet" href="{{ url('/css/bootstrap.min.css') }}">

    <style>
            @font-face {
                font-family: 'Tajawal';
                font-style: normal;
                font-weight: 400;
                src: url(../fonts/Tajawal/Tajawal-Medium.ttf);
                unicode-range: U+0600-06FF, U+200C-200E, U+2010-2011, U+204F, U+2E41, U+FB50-FDFF, U+FE80-FEFC;
            }

            body {
                font-family: Tajawal;
                overflow-x: hidden;
                direction: rtl;
            }
            .custom-control-label::before, .custom-control-label::after {
                right: -1.5rem;
            }
            .alert {
                padding-left: 3rem;
                padding-right: 1.25rem;
            }
            .alert >button{
                left : 0 !important;
                right:unset !important;
            }
            .alert > ul {
                    padding-right: 20px
            }
            /* Start loadding (spinner) style */

            .loader {
                position: relative;
            }

            .loader .loader-shape {
                border: 15px solid #f3f3f3;
                border-radius: 50%;
                border-top: 15px solid #3498db;
                width: 100px;
                height: 100px;
                -webkit-animation: spin 2s linear infinite;
                /* Safari */
                animation: spin 2s linear infinite;
            }

            .loader .loader-value {
                position: absolute;
                top: 32px;
                width: 100%;
                right: 0;
                font-size: 24px;
            }

            /* End loadding (spinner) style */

            /* Safari */

            @-webkit-keyframes spin {
                0% {
                    -webkit-transform: rotate(0deg);
                }
                100% {
                    -webkit-transform: rotate(360deg);
                }
            }

            @keyframes spin {
                0% {
                    transform: rotate(0deg);
                }
                100% {
                    transform: rotate(360deg);
                }
            }

            /* End loadding style */

    </style>

</head>

<body class="bg-light">


    <main class="text-center" style="width: 300px;margin:60px auto;">

        <img src="{{ asset('images/login-icon.svg') }}" style="width: 120px;" alt=".." />
        <h3 class="my-3">الدخول للنظام</h3>

        @include('layouts.errors')

        <form method="POST" class="formSendAjaxRequest" btnsuccess="hide" refresh-seconds="0" action="{{ url('cp/login') }}"
        aria-label="تسجيل الدخول" msgsuccess="جاري الدخول...">
             @csrf

            <div class="formResult text-center"></div>

            <div class="form-group">
                <input type="text" maxlength="32" class="form-control text-center" autofocus="" required="" name="username" placeholder="اسم المستخدم">
            </div>
            <div class="form-group mb-2">
                <input type="password" maxlength="32" class="form-control text-center" required="" name="password" placeholder="كلمة المرور">
            </div>
            <div class="form-group">
                <div class="custom-control custom-checkbox">
                    <input type="checkbox" name="remember" class="custom-control-input" id="customControlValidation1">
                    <label class="custom-control-label" for="customControlValidation1">تذكر كلمة المرور</label>
                </div>
            </div>

                <div class="text-center" ></div>
                <button type="submit" class="btn btn-secondary btn-block">تسجيل الدخول</button>
        </form>

    </main>



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <!--<script src="js/jquery-3.3.1.slim.min.js"></script>-->
    <script src="{{ url('/js/jquery-3.3.1.min.js') }}"></script>
    <script src="{{ url('/js/bootstrap.min.js') }}"></script>
    <script src="{{ url('/js/script.js') }}"></script>


            <script>
    let change1;
    let change2;
    let change3;
    let change4;
    let change5;
        </script>


</body>

</html>
