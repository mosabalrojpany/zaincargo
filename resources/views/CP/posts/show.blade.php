@extends('CP.layouts.header-footer')
@section('content')


    <!--    Start path   -->
    <nav aria-label="breadcrumb" role="navigation" class="shadow">
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item"> 
                <a href="{{ url('/cp/posts') }}">الأخبار</a>
            </li>
            <li class="breadcrumb-item active text-truncate col pr-0 text-right" aria-current="page">{{ $post->title }}</li>
        </ol>
    </nav>
    <!--    End path    -->



<!--    Start post info    -->
<div class="row mt-3 mb-5 justify-content-center text-right">
 
    {{-- Start show post --}}
    <div class="col-xl-8 mb-4">

        <div class="bg-white shadow py-3 px-4">
            
            <div class="row align-items-center">
                <div class="col">
                    <h5 class="mb-0">{{ $post->title }}</h5>
                </div>

                @if(hasRole('posts_edit'))
                    <div class="col-auto">
                        <a href="{{ url('cp/posts/edit',$post->id) }}" class="btn btn-primary"><i class="fa fa-pen"></i></a>
                    </div>
                @endif
                
            </div>
            
            <span class="text-muted d-inline-block mb-2 f-15px"> 
                <i class="fas fa-user mx-1"></i>{{ $post->user->name }}
                <i class="far fa-clock ml-1 mr-2"></i><bdi>{{ $post->created_at() }}</bdi>
                <i class="fa fa-tags fa-sm mr-2 ml-1"></i><bdi>{{ collect($post->tags->pluck('name'))->implode(' , ') }}</bdi>  
            </span>
            
            <hr class="mt-2"/>
            
            <img class="img-fluid w-100" src="{{ $post->getImage() }}" />
            
            <div class="editor-content mt-4">{!! $post->content !!}</div>
        
        </div>

    </div> 
    {{-- end show post --}}


    <div class="col-xl-4 last-posts">

        <div class="row">
            <!--    Start last-posts    -->
            <div class="col-md-6 col-xl-12 mb-3">

                <div class="bg-white shadow p-3">
                    
                    <h4 class="">أخر الحملات</h4>
                    
                    <hr/>
                    
                    @foreach($last_posts as $p)
                    
                        <div class="card border-0 mb-3">
                            <div class="row no-gutters">
                                <a href="{{ url('cp/posts',$p->id) }}" class="col-4 box-img">
                                    <img src="{{ $p->getImageAvatar() }}" class="card-img rounded-0" >
                                    <div class="overly"></div>
                                </a>
                                <div class="col-8 text-right pr-2">
                                    <h6 class="card-text mb-0">
                                        <a href="{{ url('cp/posts',$p->id) }}">{{ $p->title }}</a>
                                    </h6>
                                    <span class="text-muted f-15px"><i class="far fa-clock ml-1 mr-2"></i><bdi>{{ $p->created_at() }}</bdi></span>
                                </div>
                            </div>
                        </div>
                    
                    @endforeach
                
                </div>
            
            </div>
            <!--    End last-posts      -->
            
            <!--    Start related posts    -->
            @if($related_posts)
                <div class="col-md-6 col-xl-12 mb-3">
                    <div class="bg-white p-3 shadow">
                        <h4 class="">حملات ذات صلة</h4>
                        <hr/>
                        @foreach($related_posts as $p)
                            <div class="card border-0 mb-3">
                                <div class="row no-gutters">
                                    <a href="{{ url('cp/posts',$p->id) }}" class="col-4 box-img">
                                        <img src="{{ $p->getImageAvatar() }}" class="card-img rounded-0" >
                                        <div class="overly"></div>
                                    </a>
                                    <div class="col-8 text-right pr-2">
                                        <h6 class="card-text mb-0"><a href="{{ url('cp/posts',$p->id) }}">{{ $p->title }}</a></h6>
                                        <span class="text-muted f-15px"><i class="far fa-clock ml-1 mr-2"></i><bdi>{{ $p->created_at->format('Y-m-d g:ia') }}</bdi></span>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
            <!--    End related posts    -->
        </div>

    </div>
</div>
<!--    End post info    -->

 
@endsection