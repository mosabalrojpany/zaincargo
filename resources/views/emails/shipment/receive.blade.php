@extends('emails.layouts.app')


@section('subject')
    {{ $subject }}
@endsection


@section('content')
    
    <p>
        تم استلام شحنة لك على العنوان <b><bdi>{{ $shipment->address->name }}</bdi></b>
        من <b><bdi>{{ $shipment->address->country->name }}</bdi></b>
    </p>
        
    <table style="margin-top: 20px; border: 1px solid #333; width: 100%; text-align: center; border-collapse: collapse;">
        <thead>
            <tr style="background-color: #1f415f; color: #fff; height: 36px;">
                <th style="border: 1px solid #999;">رمز الشحنة</th>
                <th style="border: 1px solid #999;">رقم التتبع</th>
                <th style="border: 1px solid #999;">الوزن</th>
                <th style="border: 1px solid #999;">الأبعاد</th>
            </tr>
        </thead>
        <tbody>
            <tr style="height: 34px;">
                <td style="border: 1px solid #999;"><bdi>{{ $shipment->shipment_code }}</bdi></td>
                <td style="border: 1px solid #999;"><bdi>{{ $shipment->tracking_number }}</bdi></td>
                <td style="border: 1px solid #999;">kg<bdi>{{ $shipment->weight }}</bdi></td>
                <td style="border: 1px solid #999;"><bdi>{{ $shipment->length.'x'.$shipment->width.'x'.$shipment->height }}</bdi></td>
            </tr>
        </tbody>
    </table>

    <p>
        للاطلاع على تفاصيل الشحنة الرجاء الدخول إلى حسابك أو  
        <b>
            <a target="_blank" href="{{ url('client/shipping-invoices',$shipment->id) }}">اضغط هنا لعرض الشحنة</a>.
        </b>
    </p>

@endsection