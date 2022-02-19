@extends('emails.layouts.app')


@section('subject')
    {{ $subject }}
@endsection

@section('content')


    <p>
        تم استلام طلب انضمامك إلينا , سيتم مراجعة بياناتك وسنرد عليك في أقرب فرصة ممكنة
    </p>

@endsection