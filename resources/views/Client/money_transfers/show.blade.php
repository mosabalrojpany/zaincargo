@extends('Client.layouts.app')

@section('content')


    {{-- Start path --}}
    <div class="d-flex align-items-center justify-content-between mb-3">

        <nav aria-label="breadcrumb" role="navigation">
            <ol class="breadcrumb mb-0" style="background-color: transparent">
                <li class="breadcrumb-item"> 
                    <h4 class="mb-0">
                        <a class="text-decoration-none" href="{{ url('client/money-transfers') }}">حوالات مالية</a> 
                    </h4>
                </li>
                <li class="breadcrumb-item active text-truncate col pr-0 text-right" aria-current="page">
                    <h4 class="mr-1 mb-0 d-inline-block">{{ $transfer->id }}</h4>
                </li>
            </ol>
        </nav>

        {{--  if transfer is new that means client can edit it  --}}
        @if($transfer->state == 1)
            <div class="col-auto">
                <a href="{{ url('client/money-transfers/edit',$transfer->id) }}" class="btn btn-primary"><i class="fas fa-pen ml-1"></i>تعديل</a>        
            </div>
        @endif

    </div>
    {{-- End path --}}



<div class="card card-shadow">

    {{--  Start header of transfer  --}}
    <div class="card-header bg-white pt-4 text-right">

        {{-- Firtst box info --}}
        <div class="row">

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">رقم الحوالة</label>
                    <div class="col text-secondary"><bdi>{{ $transfer->id }}</div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">الحالة</label>
                    <div class="col text-secondary">{{ $transfer->getState() }}</div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">البلد</label>
                    <div class="col text-secondary">{{ $transfer->country->name }}</div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">المدينة</label>
                    <div class="col text-secondary">{{ $transfer->city->name }}</div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

        </div>
        {{-- End box info --}}

        <hr/>

        {{-- Start Recipient info --}}
        <div class="row">
            
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">اسم المستلم</label>
                    <div class="col text-secondary">{{ $transfer->recipient }}</div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">رقم الهاتف</label>
                    <div class="col text-secondary"><bdi>{{ $transfer->phone }}</bdi></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">رقم الهاتف 2</label>
                    <div class="col text-secondary"><bdi>{{ $transfer->phone2 }}</bdi></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>
        
        </div>
        {{-- End Recipient info --}}

        <hr/>

        {{-- Start Recipient Type/File info --}}
        <div class="row">

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">نوع المستلم</label>
                    <div class="col text-secondary">{{ $transfer->getRecipientType() }}</div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">ملف</label>
                    <div class="col text-secondary">
                        @if($transfer->file)
                            <a href="{{ $transfer->getFile() }}" target="_blank">عرض الملف</a>
                        @else
                            لا يوجد ملف
                        @endif
                    </div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

        </div>
        {{-- End Recipient Type/File info --}}

        <hr/>
        
        {{-- Start Money info --}}
        <div class="row">
            
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">العمولة على</label>
                    <div class="col text-secondary"><b>{{ $transfer->getFeeOn() }}</b></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px pl-0">طريقة الاستلام</label>
                    <div class="col text-secondary">{{ $transfer->getRecevingMethod() }}</div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">العملة</label>
                    <div class="col text-secondary">{{ $transfer->currency->name }}</div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">المبلغ</label>
                    <div class="col text-secondary"><b>{{ $transfer->amount }}</b></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">العمولة</label>
                    <div class="col text-secondary"><b>{{ $transfer->fee }}</b></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">الإجمالي</label>
                    <div class="col text-secondary"><b>{{ $transfer->getTotalByCurrency() }}</b></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>
            
        </div>
        {{-- End Money info --}}


        @if($transfer->account_number)

            <hr/>

            {{-- Start Bank info --}}
            <div class="row">
                    
                <div class="col-md-6 col-lg-4 mb-3">
                    <div class="row">
                        <label class="col-auto w-125px">رقم الحساب</label>
                        <div class="col text-secondary"><bdi>{{ $transfer->account_number }}</bdi></div>
                    </div>
                    <div class="border-b mb-1"></div>
                </div>
                
                @if($transfer->account_number2)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px pl-0">رقم الحساب 2</label>
                            <div class="col text-secondary"><bdi>{{ $transfer->account_number2 }}</bdi></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>
                @endif

                @if($transfer->account_number3)
                    <div class="col-md-6 col-lg-4 mb-3">
                        <div class="row">
                            <label class="col-auto w-125px pl-0">رقم الحساب 3</label>
                            <div class="col text-secondary"><bdi>{{ $transfer->account_number3 }}</bdi></div>
                        </div>
                        <div class="border-b mb-1"></div>
                    </div>
                @endif

            </div>
            {{-- End Bank info --}}

        @endif

        <hr/>

        {{-- Start Datas/addedBy --}}
        <div class="row">
            
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">تاريخ الطلب</label>
                    <div class="col text-secondary"><bdi>{{ $transfer->created_at() }}</bdi></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>

            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">تاريخ التحويل</label>
                    <div class="col text-secondary"><bdi>{{ $transfer->converted_at() }}</bdi></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>
            
            <div class="col-md-6 col-lg-4 mb-3">
                <div class="row">
                    <label class="col-auto w-125px">تاريخ الاستلام</label>
                    <div class="col text-secondary"><bdi>{{ $transfer->received_at() }}</bdi></div>
                </div>
                <div class="border-b mb-1"></div>
            </div>
    
        </div>
        {{-- End Datas/addedBy --}}

        
        {{-- Start Note --}}
        @if($transfer->note)
            
            <hr/>
            
            <div class="mb-3">
                <div class="row">
                    <label class="col-auto w-125px">ملاحظة</label>
                    <div class="col text-secondary">{{ $transfer->note }}</div>
                </div>
                <div class="border-b mb-1"></div>
            </div>
        
        @endif
        {{-- End Note --}}
    
    </div>
    {{--  End header of transfer  --}}

</div>


@endsection