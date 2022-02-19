@extends('CP.layouts.header-footer')
@section('content')


    <!--    Start header    -->
    <div class="d-flex justify-content-between">
        <h4 class="font-weight-bold">الأسئلة الشائعة {{ $faqs->total() }}</h4>
        <a class="btn btn-primary w-100px" href="{{ url('cp/faqs/create') }}">
            <i class="fas fa-plus mx-1"></i>أضف
        </a>
    </div>
    <!--    End header    -->

    

    <div class="row mt-5 text-right">

        <!--    Start search box     -->
        <aside class="col-lg-4 col-xl-3 mb-5">
            <form action="{{ Request::url() }}">
                <input type="hidden" name="search" value="1" />
                <div class="form-group">
                    <label>السؤال</label>
                    <input type="search" value="{{ Request::get('question') }}" name="question" maxlength="32" class="form-control" />
                </div>
                <div class="form-group">
                    <label>الإجابة</label>
                    <input type="search" value="{{ Request::get('answer') }}" name="answer" maxlength="32" class="form-control" />
                </div>
                <div class="form-group">
                    <label>الحالة</label>
                    <select name="state" class="form-control setValue" value="{{ Request::get('state') }}">
                        <option value="" selected>الكل</option>  
                        <option value="1">فعال</option>  
                        <option value="0">غير فعال</option>  
                    </select>
                </div>
                <button type="submit" class="btn btn-primary btn-block mt-2">بحث</button>
            </form>
        </aside>
        <!--    End search box     -->


        <!--    Start show data  -->
        <section class="col-lg-8 col-xl-9">

            <!-- Start print FAQs -->
            @foreach($faqs as $faq)

                <div class="card border-0 mb-3 {{ $faq->active ? 'border-state-active' : 'border-state-disable' }}">
                    
                    {{--  Start header  --}}
                    <div class="card-header bg-white py-3 d-flex justify-content-between align-items-center" role="tab" id="heading{{ $faq->id }}">
                        
                        <h6 class="mb-0 py-1 pl-2 text-truncate">{{ $faq->question }}</h6>
                        
                        <div class="no-wrap">
                            <a class="btn btn-sm btn-primary ml-2" href="{{ url('cp/faqs/edit',$faq->id) }}" >
                                <i class="fas fa-pen"></i>
                            </a>
                            <a data-toggle="collapse" class="text-dark" href="#collapse{{ $faq->id }}" aria-expanded="false" aria-controls="collapse{{ $faq->id }}">
                                <i class="fa fa-chevron-down"></i>
                            </a>
                        </div>
                    
                    </div>
                    {{--  End header  --}}

                    {{--  Start body  --}}
                    <div id="collapse{{ $faq->id }}" class="collapsing" role="tabpanel" aria-labelledby="heading{{ $faq->id }}">

                        <div class="card-body text-right">

                            <p class="text-primary font-weight-bold">{{ $faq->question }}</p>
                            
                            <hr/>
                            
                            <div class="editor-content">{!! $faq->answer !!}</div>
                        
                        </div>

                    </div>
                    {{--  End body  --}}

                </div>

            @endforeach
            <!-- End print FAQs -->

             <div class="pagination-center mt-2">{{ $faqs->links() }}</div>  

        </section>
        <!--    End show data  -->


    </div>

@endsection