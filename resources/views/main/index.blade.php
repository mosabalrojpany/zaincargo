@extends('main.layouts.header-footer')

@section('content')


    <!--  hero area start  -->
    <div class="hero-area hero-bg-3 home-3">
        <div class="container">
            <div class="row justify-content-center text-center">
                <div class="col-lg-9">
                    <div class="hero-txt">
                        <h1 class="wow fadeInUp" data-wow-duration="1.5s">Zain Albahar<br/>for sea shipping</h1>

                        @unless(authClient()->check())

                            <a class="wow fadeInUp boxed-btn mr-2" data-wow-duration="1.5s" href="{{ url('client/register') }}">
                                <span>Register now</span>
                            </a>

                        @endif

                    </div>
                </div>
            </div>
        </div>
        <div class="hero-overlay"></div>
    </div>
    <!--  hero area end  -->


    <!--  service section start  -->
    <div class="service-section home-3">
        <div class="container">
            <span class="title">OUR SERVICE</span>
            <h2 class="subtitle">OUR SERVICE</h2>
            <div class="services">
                <div class="row">


                    <div class="col-lg-6 mb-3">
                        <div class="single-service wow fadeInUp" data-wow-duration="1.5s" data-wow-delay=".2s">
                            <div class="icon-wrapper"><i class="flaticon-ferry"></i></div>
                            <div class="service-txt">
                                <h4 class="service-title">SEA SHIPPING</h4>
                                <p class="service-para">ان خدمة الشحن البحري هيا خدمة رئيسية في مجال الشحن لانها تكون ارخص عادة وبكميات كبيرة لدلك تسعى شركة الكترو ليبيا الي تقديم افضل الخدمات في الشحن البحري من جميع بلدان العالم لتكون البداية من اكبر دولة تجارية (الصين) وكدلك بلدان اخرى .</p>
                            </div>
                        </div>
                    </div>


                </div>
            </div>
        </div>
    </div>
    <!--  service section end  -->


    <!--  about section start  -->
    <div class="about-section home-2">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 offset-lg-2">
                    <img class="ceo-pic" src="{{ url('assets/img/about-us-img.png') }}" alt="حولنا">
                </div>
                <div class="col-lg-6">
                    <div class="comment-content">
                        <span class="title">ABOUT US</span>
                        <h2 class="subtitle">who are we</h2>
                        <p>شركة إلكتروليبيا للشحن وخدمات التسوق..نوفر لك منتجاتك الى ليبيا ونتسوق لك من اي مكان</p>
                        <p>تأسست الشركة في عام 2016 بشكل تجاري حر , وفي عام 2019 تأسست بشكل قانوني كامل تحت اسم شركة إلكتروليبيا لخدمات الشحن والتسوق االلكتروني ذ.م.م- مقرها الرئيسي بنغازي - الفويهات, برأس مال أولي 50000 دينار ليبي .</p>
                        <p>تم فتح فرع في طرابلس وفرع في مصراته .وتطمح الشركة بأن تكون هي الرائدة في مجال الشحن والتسوق الإلكتروني في ليبيا وفي جميع أنحاء العالم.</p>

                        <a class="readmore" href="{{ url('about') }}">read more</a>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  about section end  -->


    <!--  features section start  -->
    <div class="features-section home-2 border-top border-top-lg-0">
        <div class="container">
            <div class="row feature-content">
                <div class="col-xl-5 col-lg-6 mr-auto pl-0">
                    <div class="features">
                        <span class="title">Our Advantages</span>
                        <h2 class="subtitle">Why choose us</h2>

                        <div class="feature-lists">

                            <div class="single-feature wow fadeInUp" data-wow-duration="1s">
                                <div class="icon-wrapper"><i class="flaticon-customer-service"></i></div>
                                <div class="feature-details">
                                    <h4>24/7 دعم فني</h4>
                                    <p>نعمل بجهد وبشكل متواصل لتوفير خدمات دعم فني مميزة لزبائننا والرد على كل الاستفسارات.</p>
                                </div>
                            </div>

                            <div class="single-feature wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                                <div class="icon-wrapper"><i class="flaticon-email"></i></div>
                                <div class="feature-details">
                                    <h4>الإنجاز السريع</h4>
                                    <p>نحن نسعى لتسريع إنجاز خدماتنا مع توفير إجابات واضحة وشفافة للزبائننا .</p>
                                </div>
                            </div>

                            <div class="single-feature wow fadeInUp" data-wow-duration="1s" data-wow-delay=".4s">
                                <div class="icon-wrapper"><i class="flaticon-worldwide"></i></div>
                                <div class="feature-details">
                                    <h4>خدمات عالمية</h4>
                                    <p>نحن نسعى جاهدين إلى تطوير خدماتنا لكي نكون الأفضل ونقدم خدمات بجودة عالمية عالية جدا.</p>
                                </div>
                            </div>

                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  features section end  -->


    <!--  testimonial section start  -->
    <div class="testimonial-section pb-5 mb-5 home-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-6">
                    <span class="title">Our customers</span>
                    <h2 class="subtitle"></h2>
                </div>
            </div>
            <div class="row" style="direction: ltr;">
                <div class="col-md-12">
                    <div class="testimonial-carousel-3 owl-carousel owl-theme">

                        <div class="single-testimonial">
                            <div class="img-wrapper">
                                <img src="{{ url('assets/img/testimonial/Mohamed_Badi.png') }}" alt="">
                            </div>
                            <div class="client-desc">
                                <p class="icon-wrapper"><i class="flaticon-quote-left"></i></p>
                                <p class="comment">خدمات ما شاء الله.. الأفضل في ليبيا من جميع النواحي.. الأسعار والخدمات والمعاملة وسرعة الرد.. بالتوفيق إن شاء الله وإلى الأفضل</p>
                                <h5 class="name mb-3">‏‎Mohamed Badi‎</h5>
                            </div>
                        </div>

                        <div class="single-testimonial">
                            <div class="img-wrapper">
                                <img src="{{ url('assets/img/testimonial/Enaam_Alalem.png') }}" alt="">
                            </div>
                            <div class="client-desc">
                                <p class="icon-wrapper"><i class="flaticon-quote-left"></i></p>
                                <p class="comment">ماشاء الله خدمة العملاء ممتازة ، وخدمات الشحن تعتبر جيدة جداً كبداية ودائماً يسعوا للأفضل هذا شيء يحسبلهم وبأذن الله حيكون عندكم مستقبل زاهر وتنافسوا شركات عالمية 🌸</p>
                                <h5 class="name mb-3">Enaam Alalem</h5>
                            </div>
                        </div>

                        <div class="single-testimonial">
                            <div class="img-wrapper">
                                <img src="{{ url('assets/img/testimonial/Om_Arhoma_Rheel.png') }}" alt="">
                            </div>
                            <div class="client-desc">
                                <p class="icon-wrapper"><i class="flaticon-quote-left"></i></p>
                                <p class="comment">الشركة الاولي للشحن في ليبيا من حيث المميزات والاهتمام برضي العملاء فعلا مجهود يذكر فيشكر فلكم منا كل الاحترام والتقدير 🌹🌹🌹</p>
                                <h5 class="name mb-3">Om Arhoma Rheel‎</h5>
                            </div>
                        </div>

                        <div class="single-testimonial">
                            <div class="img-wrapper">
                                <img src="{{ url('assets/img/testimonial/Mosab_A_Shlimbo.png') }}" alt="">
                            </div>
                            <div class="client-desc">
                                <p class="icon-wrapper"><i class="flaticon-quote-left"></i></p>
                                <p class="comment">معامله و سرعة رد اسعار الله يبارك 👍</p>
                                <h5 class="name mb-3">Mosab A Shlimbo‎</h5>
                            </div>
                        </div>

                        <div class="single-testimonial">
                            <div class="img-wrapper">
                                <img src="{{ url('assets/img/testimonial/Munsir_Megrisi.png') }}" alt="">
                            </div>
                            <div class="client-desc">
                                <p class="icon-wrapper"><i class="flaticon-quote-left"></i></p>
                                <p class="comment">معاملة ممتازة ويمتازو بالجدية في العمل</p>
                                <h5 class="name mb-3">‏‎Munsir Megrisi‎‏</h5>
                            </div>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--  testimonial section end  -->




    <!--   news section start    -->
    <div class="news-section">
        <div class="container">
            <span class="title">last news</span>
            <div class="row">

                @foreach($posts as $post)
                    <div class="col-lg-4 col-md-6 mb-3">
                        <div class="single-news wow fadeInRight" data-wow-duration="1.5s">

                            <img src="{{ $post->getImageAvatar() }}" alt="{{ $post->title }}">

                            <div class="news-txt">

                                @foreach($post->tags as $tag)
                                    <a href="{{ url("news?tag=$tag->name") }}" class="tag ml-1">
                                        <i class="fa fa-tag" style="vertical-align: middle"></i>
                                        {{ $tag->name }}
                                    </a>
                                @endforeach
                                |
                                <span class="date">
                                    <i class="far fa-clock" style="vertical-align: middle"></i>
                                    <bdi>{{ $post->getDate() }}</bdi>
                                </span>

                                <a href="{{ url('news',$post->id) }}" class="title">
                                    <h3>{{ $post->title }}</h3>
                                </a>

                            </div>

                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!--   news section end    -->


@endsection

