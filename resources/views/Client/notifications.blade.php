@extends('Client.layouts.app') 
@section('content')


    <h4 class="font-weight-bold text-right">الإشعارات {{ $notifications->total() }}</h4>

    
	<div class="notifications-page pt-4 mb-5 text-right">

        @if($notifications->count())
        
            <div class="list-group shadow">

                @foreach($notifications as $notification)

                    <a href="{{ get_url_for_notifications($notification) }}" 
                        class="list-group-item list-group-item-action {{ $notification->unRead()? 'list-group-item-primary' : '' }} d-flex align-items-center border-0 mb-1">
                    
                        <span class="notification-icon ml-3">
                            <i class="{{ get_icon_for_notifications($notification) }} fa-fw fa-2x"></i>
                        </span>
                        
                        <div>
                            {!! $notification->data['title'] !!}
                            <label class="text-muted f-15px d-block mb-0">
                                <span title="{{$notification->created_at->format('Y-m-d g:ia') }}">
                                    <i class="far fa-clock ml-1"></i>
                                    <bdi>{{$notification->created_at->diffForHumans() }}</bdi>
                                </span>

                                @if($notification->Read())
                                    <span title="{{$notification->read_at->format('Y-m-d g:ia') }}">
                                        <i class="fa fa-check-double ml-1 mr-3"></i>
                                        <bdi>{{$notification->read_at->diffForHumans() }}</bdi>
                                    </span>
                                @endif

                            </span>
                        </div>
                    
                    </a>

                @endforeach

            </div>

            <div class="pagination-center mt-4"> {{ $notifications->links() }}</div>

        @else
        
            <h2 class="p-5 text-muted text-center">لايوجد إشعارات</h2>

        @endif

	</div>


@endsection