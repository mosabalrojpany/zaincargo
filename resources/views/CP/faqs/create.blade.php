@extends('CP.layouts.header-footer')
@section('content')

<!--    Start path   -->
<nav aria-label="breadcrumb" role="navigation" class="shadow">
    <ol class="breadcrumb bg-white">
        <li class="breadcrumb-item">
            <a href="{{ url('/cp/faqs') }}">الأسئلة الشائعة</a>
        </li>
        <li class="breadcrumb-item active text-truncate col pr-0 text-right" aria-current="page">إضافة سؤال</li>
    </ol>
</nav>
<!--    End path    -->


<div class="card border-0 shadow">

    <div class="card-body">
            
        <!--    Start section insert data    -->
        <form id="form-post" class="text-right was-validated formSendAjaxRequest" redirect-to="{{ url('cp/faqs') }}" action="{{ url('cp/faqs') }}" focus-on=".breadcrumb" refresh-seconds="1" method="POST">

            <div class="formResult text-center"></div>
            {{ csrf_field() }}


            <!--    Start main-content   -->
            <div class="form-group row mb-3 text-right">
                <label class="col-sm-auto w-75px pl-0 col-form-label">السؤال</label>
                <div class="col-sm">
                    <input type="text" class="form-control" name="question" placeholder="السؤال" pattern="\s*([\S]\s*){10,150}" required>
                    <div class="invalid-feedback text-center">
                        @lang('messages.between.string',['attribute' =>'السؤال','min'=>10,'max'=>150])
                    </div> 
                </div>
            </div>

            <div class="form-group row my-3">
                <label class="col-sm-auto w-75px pl-0 col-form-label">الإجابة</label>
                <div class="col-sm">
                    <textarea id="editor" name="answer" placeholder="الإجابة" minlength="12" class="form-control mt-3" required></textarea>
                </div>
            </div>

            <div class="row justify-content-between mt-3">
                <div class="col-md-4">
                    <div class="form-group row">
                        <label class="col-sm-auto w-75px pl-0 col-form-label">نشر</label>
                        <div class="col-sm">
                            <select name="state" class="form-control" required>
                                <option value="0">لا</option>
                                <option value="1" selected>نعم</option>
                            </select>
                        </div> 
                    </div>
                </div>
                <div class="col-md-auto">
                    <button type="submit" class="btn btn-primary w-200px">حفظ</button>
                </div>
            </div>
            <!--    End main-content   -->

        </form>
        <!--    End section insert data    -->

    </div>

</div>

        
@endsection

@include('CP.faqs.create-edit-js')