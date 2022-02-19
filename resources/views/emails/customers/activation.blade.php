@extends('emails.layouts.app')


@section('subject')
    {{ $subject }}
@endsection

@section('content')
    
    <p>
        لقد قمنا بمراجعة بياناتك وتم قبول طلب انضمامك لنا.
        <br/>
        رقم العضوية الخاصة بك <b><bdi>( {{ $customer->code }} )</bdi></b>.
        <br/>
        يمكنك من الأن الدخول للموقع والحصول على عناوين الشحن الخاصة بك وبدء في الاستفادة من خدماتنا
    </p>
        

@endsection