@extends('CP.layouts.header-footer')
@section('content')
    

    <!--    Start path   -->
    <nav aria-label="breadcrumb" role="navigation">
        <ol class="breadcrumb bg-white">
            <li class="breadcrumb-item">
                <a href="{{ url('/cp/posts') }}">الأخبار</a>
            </li>
            <li class="breadcrumb-item active text-truncate col pr-0 text-right" aria-current="page">إضافة خبر</li>
        </ol>
    </nav>
    <!--    End path    -->



    <!--    Start section insert data    -->
    <form id="form-post" class="row mt-4 mb-5 text-right was-validated formSendAjaxRequest" focus-on=".breadcrumb" refresh-seconds="1" upload-files="true" method="POST" action="{{ url('cp/posts') }}" enctype="multipart/form-data">

        <div class="formResult col-12 text-center"></div>
        {{ csrf_field() }}

        <!--    Start right-box (side)    -->
        <div class="col-lg-3"> 
            <div class="image-upload">  
                <label for="img-input" class="m-0 w-100 img-box">
                    <img src="{{ url('images/upload-img.png') }}" default-img="{{ url('images/upload-img.png') }}" class="img-thumbnail w-100 h-100"/>
                </label> 
                <input id="img-input" class="form-control img-input" type="file" name="img" accept=".png,.jpg,.gif" required /> 
                <div class="invalid-feedback text-center">يرجى تحديد صورة نوعها png , jpg , gif</div> 
            </div>
            <div class="tags-input my-3" tabindex="0">
                <div class="p-1 selected-items" data-placeholder="التصنيفات" input-name="tags[]">
                {{--
                    <span class="badge badge-primary text-truncate">
                        <i class="fa fa-times fa-sm ml-1"></i>
                        <span>example just testing</span>
                        <input type="hidden" name="tags[]" value="92">
                    </span>  
                --}}
                </div>
                <div class="invalid-feedback text-center">يجب أن تختار عنصر على الأقل</div>
                <ul class="tags-list list-unstyled bg-white">
                    @foreach($tags as $tag)
                        <li class="tag-item" data-id="{{ $tag->id }}">{{ $tag->name }}</li>
                    @endforeach
                </ul>
            </div>
            <div class="form-group row">
                <label for="inputState" class="col-sm-auto w-50px col-form-label text-right">نشر</label>
                <div class="col-sm">
                    <select id="inputState" name="state" class="form-control w-100" required>
                        <option value="" selected>اختر...</option>
                        <option value="0">لا</option>
                        <option value="1">نعم</option>
                    </select>
                </div> 
            </div>
            <button type="submit" class="btn btn-primary btn-block">حفظ</button>
        </div>
        <!--    End right-box (side)      -->

        <!--    Start main-content   -->
        <div class="col-lg-9">
            
            <div class="mb-3">
                <input type="text" class="form-control" name="title" placeholder="العنوان" pattern="\s*([\S]\s*){10,150}" required>
                <div class="invalid-feedback text-center">
                    @lang('messages.between.string',['attribute' =>'العنوان','min'=>10,'max'=>150])
                </div> 
            </div>
            
            <div class="mt-3">
                <textarea id="editor" name="content" placeholder="المحتوى" minlength="32" class="form-control" required></textarea>
            </div> 

        </div>
        <!--    End main-content   -->

    </form>
    <!--    End section insert data    -->

    
@endsection

@include('CP.posts.create-edit-js')