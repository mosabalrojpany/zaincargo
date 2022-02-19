@extends('CP.layouts.header-footer')
@section('content')
    

    <!--    Start header    -->
    <div class="d-flex justify-content-between">
        <h4 class="font-weight-bold">الأخبار {{ $posts->total() }}</h4>
        
        @if(hasRole('posts_add'))
            <a href="{{ url('cp/posts/create') }}" class="btn btn-primary w-100px">
                <i class="fas fa-plus mx-1"></i>أضف
            </a>
        @endif

    </div>
    <!--    End header    -->




    <div class="row pt-4 mb-5 text-right">


        <!--    Start search box     -->
        <aside class="col-lg-4 col-xl-3">

            <form action="{{ Request::url() }}">

                <input type="hidden" name="search" value="1" />

                <div class="form-group">
                    <label>التصنيف</label>
                    <select name="tag" class="form-control setValue" value="{{ Request::get('tag') }}">
                        <option value="" selected>الكل</option> 
                        @foreach($tags as $t)
                            <option value="{{ $t->id }}">{{ $t->name }}</option>
                        @endforeach
                    </select>
                </div>  
                <div class="form-group">
                    <label>الناشر</label>
                    <select name="user" class="form-control setValue" value="{{ Request::get('user') }}">
                        <option value="" selected>الكل</option> 
                        @foreach($users as $u)
                            <option value="{{ $u->id }}">{{ $u->name }}</option>
                        @endforeach
                    </select>
                </div>  
                <div class="form-group">
                    <label>الحالة</label>
                    <select name="state" class="form-control setValue" value="{{ Request::get('state') }}">
                        <option value="" selected>الكل</option> 
                        <option value="0">غير منشور</option> 
                        <option value="1">منشور</option> 
                    </select>
                </div> 
                <div class="form-group">
                    <label>أضيف من</label>
                    <input type="date" value="{{ Request::get('from') }}" max="{{ date('Y-m-d') }}" name="from" class="form-control" />
                </div>
                <div class="form-group">
                    <label>أضيف إلى</label>
                    <input type="date" value="{{ Request::get('to') }}" max="{{ date('Y-m-d') }}" name="to" class="form-control" />
                </div> 
                <button type="submit" class="btn btn-primary btn-block mt-2 mb-5">بحث</button>

            </form>

        </aside>
        <!--    End search box     -->



        <!--    Start show data  -->
        <section class="col-lg-8 col-xl-9">

            @if(count($posts) > 0)
                
                <div class="bg-white p-4 shadow">

                    <div class="row"> 

                        
                        @php
                            $canEdit = hasRole('posts_edit')        
                        @endphp

                        <!-- Start print posts -->
                        @foreach($posts as $post)
                            
                            <div class="box-posts col-md-6 mb-3">

                                <div class="post-img">
                                    <a href="{{ url('cp/posts',$post->id) }}">
                                        <img src="{{ $post->getImageAvatar() }}" />
                                        <span class="overly"></span>
                                    </a>
                                    <label class="post-date">
                                        <bdi>{{ $post->created_at() }}</bdi>
                                    </label>

                                    @if($canEdit)
                                        <a href="{{ url('cp/posts/edit',$post->id) }}" class="btn btn-primary post-edit">
                                            <i class="fa fa-pen"></i>
                                        </a>
                                    @endif

                                </div>

                                @if(!$post->active)
                                    <label class="post-flag text-white px-2 mt-4 bg-danger">غير فعالة</label>
                                @endif
                                
                                <div class="px-1">
                                    <h5 class="post-title my-2">
                                        <a href="{{ url('cp/posts',$post->id) }}">{{ $post->title }}</a>
                                    </h5>
                                    <span class="text-muted d-inline-block mb-2 f-15px"> 
                                        <i class="fas fa-user mx-1"></i>{{ $post->user->name }}
                                        <i class="fa fa-tags fa-sm mr-2"></i>
                                        <bdi>{{ collect($post->tags->pluck('name'))->implode(' , ') }}</bdi>  
                                    </span>
                                </div>
                            </div>
    
                        @endforeach 
                        <!-- End print posts -->

                    </div>

                </div>
            
            @else
                
                <h1 class="text-secondary py-5 my-5 text-center">لايوجد نتائج</h1>
            
            @endif 

             <div class="pagination-center mt-4">{{ $posts->links() }}</div>  

        </section>
        <!--    End show data  -->


    </div>


@endsection