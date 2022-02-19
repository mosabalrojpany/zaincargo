@extends('main.layouts.header-footer')

@section('content')



    <!--  breadcrumb area start  -->
    <div class="breadcrumb-area about-breadcrumb-bg home-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="breadcrumb-txt">
                        <span>حولنا</span>
                        <h1>من نحن ؟</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                                <li class="breadcrumb-item active" aria-current="page">حولنا</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb-overlay"></div>
    </div>
    <!--  breadcrumb area end  -->



    
     <!--  about section start  -->
     <div class="about-section about home-2">
        <div class="container">

            <div class="row">
                
                <div class="col-lg-4 offset-lg-2">
                    <img class="ceo-pic" src="{{ url('assets/img/about-us-img.png') }}" alt="حولنا">
                </div>
                
                <div class="col-lg-6">
                    <div class="comment-content">
                        <span class="title">حولنا</span>
                        <h2 class="subtitle">من نحن</h2>
                        <p>شركة إلكتروليبيا للشحن وخدمات التسوق..نوفر لك منتجاتك الى ليبيا ونتسوق لك من اي مكان</p>
                        <p>تأسست الشركة في عام 2016 بشكل تجاري حر , وفي عام 2019 تأسست بشكل قانوني كامل تحت اسم شركة إلكتروليبيا لخدمات الشحن والتسوق االلكتروني ذ.م.م- مقرها الرئيسي بنغازي - الفويهات, برأس مال أولي 50000 دينار ليبي .</p>
                        <p>تم فتح فرع في طرابلس وفرع في مصراته .وتطمح الشركة بأن تكون هي الرائدة في مجال الشحن والتسوق الإلكتروني في ليبيا وفي جميع أنحاء العالم.</p>
                        <p>وما توفيقنا إلا باالله .</p>
                    </div>
                </div>

            </div>

            
            <div class="targets">
                <div class="row">

                    <div class="col-lg-6">
                        <div class="box wow fadeInUp" data-wow-duration="1s" style="visibility: visible; animation-duration: 1s; animation-name: fadeInUp;">
                            <div class="icon-wrapper"><i class="flaticon-external-link-square-with-an-arrow-in-right-diagonal"></i></div>
                            <div class="box-details">
                                <h4>هدفنا</h4>
                                <p>نسعى لأن نصبح من أهم شركات الشحن في ليبيا من خلال مواكبة التطور والشحن التجاري وتسهيل مهمة التصدير والاستيراد والتسوق وإرسال واستقبال الأموال من جميع دول العالم وتقديم خدمات متميزة وجودة وسرعة عالية بالأضافة إلى أهتمامنا براحة العميل .</p>
                            </div>
                        </div>
                    </div>
                    
                    <div class="col-lg-6">
                        <div class="box wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s" style="visibility: visible; animation-duration: 1s; animation-delay: 0.2s; animation-name: fadeInUp;">
                            <div class="icon-wrapper"><i class="flaticon-check"></i></div>
                            <div class="box-details">
                                <h4>رؤيتنا</h4>
                                <p>تطوير خدماتنا لكي نكون الأفضل , ولا يخلو الأمر من الأخطاء والعقبات في بداية طريقنا , ولكن نعد الجميع إننا نعمل باستمرار وبدون توقف على تحديث خطة عملنا إلى أن نكون على المنوال المطلوب , فكل خدماتنا هي قيد التطوير والتخطيط ونعدكم بأفضل الخدمات .</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>

        </div>
    </div>
    <!--  about section end  -->



@endsection
