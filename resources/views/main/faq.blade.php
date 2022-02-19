@extends('main.layouts.header-footer')

@section('content')



    <!--  breadcrumb area start  -->
    <div class="breadcrumb-area faq-breadcrumb-bg home-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="breadcrumb-txt">
                        <span>الأسئلة الشائعة</span>
                        <h1>كيف يمكننا مساعدتك ؟</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                                <li class="breadcrumb-item active" aria-current="page">الأسئلة الشائعة</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb-overlay"></div>
    </div>
    <!--  breadcrumb area end  -->

    
    
    <!--   faq section start    -->
    <div class="faq-section">
        <div class="container">
            <div class="row">

                {{-- Start show questions --}}
                <div class="col-lg-8">

                    <div class="row">
                        <div class="col-lg-8">
                            <span class="title">أسئلة متكررة</span>

                            @if(Request::get('search'))
                            
                                <h2 class="subtitle">نتائج البحث عن "{{ Request::get('search') }}"</h2>
                            
                            @else
                            
                                <h2 class="subtitle">أسئلة شائعة</h2>

                            @endif

                        </div>
                    </div>
                    

                    <div class="accordion" id="accordionExample">

                        @foreach($faqs as $faq)
                            <div class="card wow fadeInUp" data-wow-duration="1s" data-wow-delay=".2s">
                                
                                <div class="card-header" id="headingTwo{{ $loop->iteration }}">
                                    <h2 class="mb-0">
                                        <button class="btn btn-link collapsed btn-block text-right" type="button" data-toggle="collapse" data-target="#collapseTwo{{ $loop->iteration }}"
                                            aria-expanded="false" aria-controls="collapseTwo{{ $loop->iteration }}">
                                            {{ $faq->question }}
                                        </button>
                                    </h2>
                                </div>

                                <div id="collapseTwo{{ $loop->iteration }}" class="collapse" aria-labelledby="headingTwo{{ $loop->iteration }}" data-parent="#accordionExample">
                                    <div class="card-body">
                                        <div class="editor-content">{!! $faq->answer !!}</div>
                                    </div>
                                </div>

                            </div>
                        @endforeach

                    </div>

                    {{ $faqs->links('vendor.pagination.main-pages') }}
                    
                </div>
                {{-- End show questions --}}
                
                <!--  sidebar section start  -->
                <div class="col-lg-4" id="boxSendMsg">
                    
                    <div class="blog-sidebar-widgets">
                        <div class="searchbar-form-section">
                            <form action="{{ url('faq') }}">
                                <div class="searchbar">
                                    <input name="search" type="text" value="{{ Request::get('search') }}" placeholder="بحث" maxlength="32" required>
                                    <button type="submit"><i class="fa fa-search"></i></button>
                                </div>
                            </form>
                        </div>
                    </div>
                    
                    <div class="sidebar">
                        <div class="quote-sidebar">
                            <h3>لديك سؤال؟</h3>

                            <form class="quote-form formSendAjaxRequest" hideOnSuccess="true" action="{{ url('contact') }}" method="POST" id="formSendMsg"
                                msgSuccess="تم إرسال سؤالك بنجاح , سيتم مراجعة سؤالك والتواصل معك إذا احتجنا لذلك" focus-on="#boxSendMsg">

                                @csrf

                                <div class="formResult"></div>
                                
                                <div class="form-element">
                                    <label>الاسم</label>
                                    <input type="text" name="name" value="{{ get_client_property_if_logged_in('name') }}" placeholder="اسمك" required
                                        pattern="\s*([0-9A-Za-z\u0621-\u064A]\s*){9,32}" title="@lang('validation.between.string',['attribute'=>'الاسم','min'=> 9 ,'max'=>32])">
                                </div>
                                
                                <div class="form-element">
                                    <label>البريد الإلكتروني</label>
                                    <input type="email" name="email" value="{{ get_client_property_if_logged_in('email') }}" placeholder="mail@domain.com" required>
                                </div>
                                
                                <div class="form-element">
                                    <label>رقم الهاتف</label>
                                    <input type="text" name="phone" value="{{ get_client_property_if_logged_in('phone') }}" placeholder="09xxxxxxxx" required
                                        class="text-right" dir='ltr' pattern="\s*([0-9\-\+]\s*){3,14}" title="@lang('validation.digits_between',['attribute'=>'رقم الهاتف','min'=> 3 ,'max'=>14])">
                                </div>
                                
                                <input type="text" name="title" class="d-none" value="سؤال للاستفسار عن شئ ما" required>
                                
                                <div class="form-element">
                                    <label>السؤال</label>
                                    <textarea name="content" minlength="10" maxlength="500" placeholder="محتوى سؤالك" required></textarea>
                                </div>
                                
                                <div class="form-element">
                                    <button type="submit"><span>إرسال</span></button>
                                </div>
                            
                            </form>

                        </div>
                    </div>

                </div>
                <!--  sidebar section end  -->

            </div>
        </div>
    </div>
    <!--   faq section end    -->


@endsection
