@extends('main.layouts.header-footer')

@section('content')


    <!--  breadcrumb area start  -->
    <div class="breadcrumb-area contact-breadcrumb-bg home-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="breadcrumb-txt">
                        <span>اتصل بنا</span>
                        <h1>ابق على تواصل معنا</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                                <li class="breadcrumb-item active" aria-current="page">اتصل بنا</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb-overlay"></div>
    </div>
    <!--  breadcrumb area end  -->



    <!--   branches section start    -->
    <div class="contact-section">
        <div class="container">

            <h2 class="subtitle">فروعنا</h2>

            <!--  contact infos start  -->
            <div class="row justify-content-between">

                @foreach($branches as $branch)
                    <div class="col-md-6 col-lg-4">
                        <div class="shadow p-4">
                            <div class="card-body">

                                <h4 class="card-title font-weight-bold">{{ $branch->city }}</h4>

                                <div class="footer-contact">

                                    <div class="contact-info">
                                        <div class="icon-wrapper"><i class="flaticon-placeholder"></i></div>
                                        <p>{{ $branch->address }}</p>
                                    </div>

                                    <div class="contact-info">
                                        <div class="icon-wrapper"><i class="flaticon-call"></i></div>
                                        <p><bdi>{{ $branch->phone }}</bdi></p>
                                    </div>

                                    @isset($branch->phone2)
                                        <div class="contact-info">
                                            <div class="icon-wrapper"><i class="flaticon-call"></i></div>
                                            <p><bdi>{{ $branch->phone }}</bdi></p>
                                        </div>
                                    @endisset

                                    <div class="contact-info">
                                        <div class="icon-wrapper"><i class="flaticon-email"></i></div>
                                        <p>{{ $branch->email }}</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach


            </div>
            <!--  contact infos end  -->
        </div>
    </div>
    <!--   branches section end    -->


    {{-- Start Contact-us form and google map --}}
    <div class="container-fluid bg-light">
        <div class="row">
            <div class="col-lg-6 py-5">

                <!--  contact form start  -->
                <div class="contact-form-section mt-0" id="boxSendMsg">
                    <span class="title">اتصل بنا</span>
                    <h2 class="subtitle">أبق على اتصال</h2>

                    <form class="quote-form m-auto formSendAjaxRequest" hideOnSuccess="true" action="{{ url('contact') }}" method="POST" focus-on="#boxSendMsg"
                        msgSuccess="تم إرسال رسالتك بنجاح , سيتم مراجعة رسالتك والتواصل معك إذا احتجنا لذلك">

                        @csrf
                        <div class="formResult"></div>

                        <div class="row">

                            <div class="col-md-6">
                                <div class="form-element">
                                    <label>الاسم</label>
                                    <input type="text" name="name" value="{{ get_client_property_if_logged_in('name') }}" placeholder="اسمك" required
                                        pattern="\s*([0-9A-Za-z\u0621-\u064A]\s*){9,32}" title="@lang('validation.between.string',['attribute'=>'الاسم','min'=> 9 ,'max'=>32])">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-element">
                                    <label>البريد الإلكتروني</label>
                                    <input type="email" name="email" value="{{ get_client_property_if_logged_in('email') }}" placeholder="mail@domain.com" required>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-element">
                                    <label>رقم الهاتف</label>
                                    <input type="text" name="phone" value="{{ get_client_property_if_logged_in('phone') }}" placeholder="09xxxxxxxx" required
                                        class="text-right" dir='ltr' pattern="\s*([0-9\-\+]\s*){3,14}" title="@lang('validation.digits_between',['attribute'=>'رقم الهاتف','min'=> 3 ,'max'=>14])">
                                </div>
                            </div>

                            <div class="col-md-6">
                                <div class="form-element">
                                    <label>العنوان</label>
                                    <input type="text" name="title" placeholder="عنوان الموضوع" required
                                        pattern="\s*([^\s]\s*){9,100}" title="@lang('validation.between.string',['attribute'=>'العنوان','min'=> 9 ,'max'=>100])">
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-element">
                                    <label>الرسالة</label>
                                    <textarea name="content" minlength="10" maxlength="500" placeholder="محتوى الرسالة" required></textarea>
                                </div>
                            </div>

                            <div class="col-12">
                                <div class="form-element">
                                    <button type="submit"><span>إرسال</span></button>
                                </div>
                            </div>

                        </div>

                    </form>
                </div>
                <!--  contact form end  -->

            </div>

            <div class="col-lg-6 px-0">

                {{-- Start google map --}}
                <div style="min-height: 400px; height: 100%;">
                    {!! Mapper::render() !!}
                </div>
                {{-- End google map --}}

            </div>

        </div>
    </div>
    {{-- End Contact-us form and google map --}}


@endsection
