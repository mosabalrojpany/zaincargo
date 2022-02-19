@extends('main.layouts.header-footer')

@section('content')



    <!--  breadcrumb area start  -->
    <div class="breadcrumb-area blog-breadcrumb-bg home-3">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="breadcrumb-txt">
                        <span>أخبارنا</span>
                        <h1>ما أخر أخبارنا ؟</h1>
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                                <li class="breadcrumb-item active" aria-current="page">أخبارنا</li>
                            </ol>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <div class="breadcrumb-overlay"></div>
    </div>
    <!--  breadcrumb area end  -->



    
    <!--    blog lists start   -->
    <div class="news-section blog-grid-sidebar">
        <div class="container">
            <div class="row">
            
                <div class="col-xl-7 offset-xl-1 col-lg-8">
                    <div class="row">

                        @if(Request::get('tag'))

                            <div class="col-lg-12">
                                <span class="title">الأخبار</span>
                                <h2 class="subtitle">{{ Request::get('tag') }}</h2>
                            </div>

                        @elseif(Request::get('search'))

                            <div class="col-lg-12">
                                <span class="title">الأخبار</span>
                                <h2 class="subtitle">نتائج البحث "{{ Request::get('search') }}"</h2>
                            </div>

                        @endif


                        @foreach($posts as $post)
                            <div class="col-md-6 mb-3">
                                <div class="single-news wow fadeInUp" data-wow-duration="1.5s" data-wow-delay="{{ $loop->iteration * .1 }}s">
                                    
                                    <img src="{{ $post->getImageAvatar() }}" alt="{{ $post->title }}">
                                    
                                    <div class="news-txt">
                                        
                                        @foreach($post->tags as $tag)
                                            <a href="{{ url("news?tag=$tag->name") }}" class="tag ml-1">
                                                <i class="fa fa-tag" style="vertical-align: middle"></i>
                                                {{ $tag->name }}
                                            </a>
                                        @endforeach
                                        |
                                        <span class="date mr-1">
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
                    
                    <div class="row">
                        <div class="col-lg-12">
                            {{ $posts->links('vendor.pagination.main-pages') }}
                        </div>
                    </div>
                
                </div>

                <!--    blog sidebar section start   -->
                <div class="col-lg-4">
                    @include('main.posts.sidebar')
                </div>
                <!--    blog sidebar section end   -->
            
            </div>
        </div>
    </div>
    <!--    blog lists end   -->
    
    


@endsection
