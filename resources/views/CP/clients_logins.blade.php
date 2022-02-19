@extends('CP.layouts.header-footer')
@section('content')
 

    <!--    Start header    -->
    <div class="d-flex justify-content-between">
        <h4 class="font-weight-bold">حركات الدخول للزبائن {{ number_format($logins->total()) }}</h4> 
    </div>
    <!--    End header    -->
    
     
    <!--    show errors if they exist   -->
    @include('layouts.errors')

    
    <!--    Start show Logins   -->
    <div class="card mt-3">

        
        <!-- Start search  -->
        <div class="card-header bg-primary text-white"> 
            <form class="row justify-content-between" action="{{ Request::url() }}"  method="get">
                <input type="hidden" name="search" value="1" />
                <div class="form-inline col-auto">
                    <div class="form-group">
                        <label for="inputShowSearch">عرض</label>
                        <select id="inputShowSearch" name="show" class="form-control mx-sm-2 setValue" value="{{ Request::get('show') }}">
                            <option value="25"selected>25</option>
                            <option value="50">50</option>
                            <option value="100">100</option>
                            <option value="250" >250</option>
                            <option value="500">500</option>
                            <option value="750">750</option>
                            <option value="1000">1000</option>
                        </select>
                    </div>
                </div>
                <div class="form-inline col-auto">
                    <span class="ml-4"><i class="fa fa-filter"></i></span>
                    <div class="form-group">
                        <label for="inputFromSearch">من</label>
                        <input type="date" id="inputFromSearch" name='from' value="{{ Request::get('from') }}" style="min-width: 195px;" max="{{ date('Y-m-d') }}" class="form-control mx-sm-2">
                    </div> 
                    <div class="form-group">
                        <label for="inputToSearch">إلى</label>
                        <input type="date" id="inputToSearch" name='to' value="{{ Request::get('to') }}" style="min-width: 195px;" max="{{ date('Y-m-d') }}" class="form-control mx-sm-2">
                    </div>  
                    <div class="form-group">
                        <label for="inputCodeSearch">رقم العضوية</label>
                        <input type="number" min="1" name="code" value="{{ Request::get('code') }}" placeholder="رقم العضوية" id="inputCodeSearch" class="form-control mx-sm-2">
                    </div>
                    
                    <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
                </div>
            </form> 
        </div>
        <!-- End search  -->
    
 
        <!--    Start table data    -->
        <div class="card-body">

            <table class="table table-striped text-center">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">الزبون</th>
                        <th scope="col">نظام التشغيل</th>
                        <th scope="col">المتصفح</th>
                        <th scope="col">البلد</th>
                        <th scope="col">المدينة</th>
                        <th scope="col">ip</th>
                        <th scope="col">الدخول</th>
                        <th scope="col">أخر وصول</th>
                    </tr>
                </thead>
                <tbody>

                    <!-- start print items -->
                    @foreach($logins as $login)
                    <tr>
                        <th scope="row">{{1+$loop->index}}</th>
                        <td>
                            <a href="{{ url('/cp/customers',$login->customer_id) }}">
                                <bdi>{{ $login->customer->code }}</bdi>-{{ $login->customer->name}}
                            </a>
                        </td>
                        <td>{{ $login->os}}</td>
                        <td>{{ $login->browser }}</td>
                        <td>{{ $login->country }}</td>
                        <td>{{ $login->city }}</td>
                        <td>{{ $login->ip }}</td>
                        <td><bdi>{{ $login->log_in->format('Y-m-d g:ia')}}</bdi></td>
                        <td><bdi>{{ $login->log_out->format('Y-m-d g:ia')}}</bdi></td> 
                    </tr>
                    @endforeach 
                    <!-- End print items -->

                </tbody>
            </table>

        </div>
        <!--    Start table data    -->

        
    </div>
    <!--    End show Logins   -->


    <!--    pagination    -->
    <div class="pagination-center mt-4">{{ $logins->links() }}</div>

 
@endsection