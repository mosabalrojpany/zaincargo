@extends('emails.layouts.app')


@section('subject')
    {{ $subject }}
@endsection


@section('content')
    
<p>
    تم احالة طلب شراء لك رقم الطلب <b><bdi>{{ $PurchaseOrder->id }}</bdi></b>
</p>
        
    <table style="margin-top: 20px; border: 1px solid #333; width: 100%; text-align: center; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #1f415f; color: #fff; height: 36px;">
                <th style="border: 1px solid #999;">رقم الطلب</th>
            </tr>
        </thead>
        <tbody>
            <tr style="height: 34px;">
                <td style="border: 1px solid #999;"><bdi>{{ $PurchaseOrder->id }}</bdi></td>
            </tr>
        </tbody>
    </table>

    <p>
        للاطلاع على تفاصيل الطلب الرجاء الدخول إلى حسابك أو  
        <b>
            <a target="_blank" href="{{ url('client/merchant_prchase_order/show',$PurchaseOrder->id) }}">اضغط هنا لعرض الطلب</a>.
        </b>
    </p>

@endsection