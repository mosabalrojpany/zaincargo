@extends('CP.layouts.header-footer')


@section('content')


{{--  Start header  --}}
<div class="d-flex justify-content-between">
    <h4 class="font-weight-bold">الرحلات {{ $trips->total() }}</h4>
    
    @if(hasRole('trips_add'))
        <a class="btn btn-primary w-100px" href="{{ url('cp/trips/create') }}">
            <i class="fas fa-plus mx-1"></i>أضف
        </a>
    @endif

</div>
{{--  End header  --}}



{{--  Start box trips  --}}
<div class="card card-shadow my-4 text-center">
        
    <!-- Start search  -->
    <div class="card-header bg-primary text-white"> 
        <form class="justify-content-between" action="{{ Request::url() }}" method="get">
            <input type="hidden" name="search" value="1">

            <div class="form-inline">
                <span class="ml-2"><i class="fa fa-filter"></i></span>
                <div class="form-group">
                    <label class="d-none" for="inputTripNumberSearch">رقم الرحلة</label>
                    <input type="search" maxlength="32" name="trip_number" value="{{ Request::get('trip_number') }}" placeholder="رقم الرحلة" id="inputTripNumberSearch" class="form-control mx-sm-2">
                </div>
                <div class="form-group">
                    <label class="d-none" for="inputTrackingNumberSearch">رقم التتبع</label>
                    <input type="search" maxlength="32" name="tracking_number" value="{{ Request::get('tracking_number') }}" placeholder="رقم التتبع" id="inputTrackingNumberSearch" class="form-control mx-sm-2">
                </div>
                <div class="form-group">
                    <label class="d-none" for="inputStateSearch">الحالة</label>
                    <select id="inputStateSearch" class="form-control mx-sm-2 setValue" style="width: 140px;" name="state" value="{{ Request::get('state') }}">
                        <option value="">كل الحالات</option>
                        @foreach($status as $k => $v)
                            <option value="{{ $k }}">{{ $v }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="d-none" for="inputAddressSearch">العنوان</label>
                    <select id="inputAddressSearch" class="form-control mx-sm-2 setValue" style="width: 220px;" name="address" value="{{ Request::get('address') }}">
                        <option value="">كل العناوين</option>
                        @foreach($addresses as $address)
                            <option value="{{ $address->id }}">{{ $address->name }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="form-group">
                    <label class="d-none" for="inputCompanySearch">الشركة</label>
                    <select id="inputCompanySearch" class="form-control mx-sm-2 setValue" style="width: 220px;" name="company" value="{{ Request::get('company') }}">
                        <option value="">كل الشركات</option>
                        @foreach($companies as $company)
                            <option value="{{ $company->id }}">{{ $company->name }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="btn btn-primary"><i class="fa fa-search"></i></button>
            </div>

        </form>  
    </div>  
    <!-- End search  -->


    @php
        $canEdit =  hasRole('trips_edit')        
    @endphp

    <!--    Start show trips   -->
    <div class="card-body p-0">
        <table class="table table-center table-striped table-hover">
            <thead>
                <tr>
                    <th scope="col">#</th>
                    <th scope="col">رقم الرحلة</th>
                    <th scope="col">رقم التتبع</th>
                    <th scope="col">الحالة</th>
                    <th scope="col">الشركة</th>
                    <th scope="col">تاريخ الخروج</th>
                    
                    @if($canEdit)
                        <th scope="col">تعديل</th>
                    @endif

                </tr>
            </thead>
            <tbody>

                <!-- Start print trips -->
                @foreach($trips as $trip)
                    <tr>
                        <th scope="row">{{ $loop->iteration }}</th>
                        <td><a target="_blank" href="{{ url('cp/trips',$trip->id) }}">{{ $trip->trip_number }}</a></td> 
                        <td>{{ $trip->tracking_number }}</td> 
                        <td>{{ $trip->getState() }}</td> 
                        <td>{{ $trip->company->name }}</td> 
                        <td><bdi>{{ $trip->exit_at() }}</bdi></td>
                        
                        @if($canEdit)
                            <td>
                                <a href="{{ url('cp/trips/edit',$trip->id) }}" class="btn btn-primary btn-sm">
                                    <i class="fas fa-pen"></i>
                                </a>
                            </td>
                        @endif
                        
                    </tr>
                @endforeach
                <!-- End print trips -->

            </tbody>
        </table>
    </div>
    <!--    End show trips   -->

</div>
{{--  End box trips  --}}



{{--  pagination  --}}
<div class="pagination-center">{{ $trips->links() }}</div>  



@endsection