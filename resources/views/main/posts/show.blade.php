@extends('main.layouts.header-footer')

@section('extra-meta')

    @php($shortDesc=mb_substr(strip_tags($post->content),0,250))

    <meta property="og:title"                   content="{{ $post->title }}" />
    <meta property="og:description"             content="{{ $shortDesc }}" />
    <meta property="og:image"                   content="{{ $post->getImage() }}" />
    <meta property="og:image:secure_url"        content="{{ $post->getImage() }}" />
    <meta property="og:type"                    content="article" />
    <meta property="article:section "           content="الأخبار">
    <meta property="article:published_time"     content="{{ $post->created_at }}">
    
    @foreach($post->tags as $tag)
        <meta property="article:tag"            content="{{ $tag->name }}" />
    @endforeach
    
    <meta name="twitter:card"                   content="summary_large_image" />
    <meta name="twitter:title"                  content="{{ $post->title }}" />
    <meta name="twitter:description"            content="{{ $shortDesc }}" />
    <meta name="twitter:image"                  content="{{ $post->getImage() }}" />

@endsection


@section('content')



    <!--  breadcrumb area start  -->
    <div class="breadcrumb-area blog-breadcrumb-bg home-3">
        <div class="container">
            <div class="breadcrumb-txt">
                <span>أخبارنا</span>
                <h1>{{ $post->title }}</h1>
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb">
                        <li class="breadcrumb-item"><a href="{{ url('/') }}">الرئيسية</a></li>
                        <li class="breadcrumb-item active" aria-current="page">أخبارنا</li>
                    </ol>
                </nav>
            </div>
        </div>
        <div class="breadcrumb-overlay"></div>
    </div>
    <!--  breadcrumb area end  -->


    
    <!--    blog details section start   -->
    <div class="blog-details-section section-padding">
        <div class="container">
            <div class="row">

                <div class="col-lg-8">
                    <div class="blog-details">
                        
                        <img class="blog-details-img-1" src="{{ $post->getImage() }}" alt="{{ $post->title }}">
                        
                        @foreach($post->tags as $tag)
                            <a href="{{ url("news?tag=$tag->name") }}" class="tag ml-1">
                                <i class="fa fa-tag" style="vertical-align: middle"></i>
                                {{ $tag->name }}
                            </a>
                        @endforeach
                        |
                        <small class="date mr-1">
                            <i class="far fa-clock" style="vertical-align: middle"></i>
                            <bdi>{{ $post->getDate() }}</bdi>
                        </small>

                        <h2 class="blog-details-title">{{ $post->title }}</h2>
                        
                        <div class="blog-details-body editor-content">
                            {!! $post->content !!}
                        </div>
                    </div>
                    <div class="blog-share">
                        <ul>
                            <li>
                                <a href="http://www.facebook.com/sharer.php?u={{ Request::url() }}" target="_blank" class="facebook-share">
                                    <i class="fab fa-facebook-f"></i> Share
                                </a>
                            </li>
                            <li>
                                <a href="https://twitter.com/share?url={{ Request::url().'&text='.$post->title }}" target="_blank" class="twitter-share">
                                    <i class="fab fa-twitter"></i> Tweet
                                </a>
                            </li>
                            <li>
                                <a href="https://pinterest.com/pin/create/button/?url={{ Request::url() }}" target="_blank" class="pinterest-share">
                                    <i class="fab fa-pinterest-p"></i> Pinterest
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>

                <!--    blog sidebar section start   -->
                <div class="col-lg-4">
                    <div class="sidebar">
                        @include('main.posts.sidebar')
                    </div>
                </div>
                <!--    blog sidebar section end   -->

            </div>
        </div>
    </div>
    <!--    blog details section end   -->
    


@endsection
