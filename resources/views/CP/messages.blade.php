@extends('CP.layouts.header-footer') 
@section('content')


    <h4 class="font-weight-bold text-right">الرسائل {{ $messages->total() }}</h4>


	<div class="row pt-4 mb-5 text-right">

		<!--    Start search box     -->
		<aside class="col-lg-4 col-xl-3 mb-5">
			<form action="{{ Request::url() }}">
				<input type="hidden" name="search" value="1" />
				<div class="form-group">
					<label>الحالة</label>
					<select name="unread" class="form-control setValue" value="{{ Request::get('unread') }}" >
                        <option value="" selected>الكل</option>
                        @foreach (trans('messageStatus.status') as $key => $value)
						    <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
					</select>
				</div>
                <div class="form-group">
                    <label>الاسم</label>
                    <input type="search" maxlength="32" value="{{ Request::get('name') }}" name="name" class="form-control" />
                </div>
                <div class="form-group">
                    <label>رقم الهاتف</label>
                    <input type="search" maxlength="14" value="{{ Request::get('phone') }}" name="phone" class="form-control" />
                </div>
                <div class="form-group">
                    <label>البريد الإلكتروني</label>
                    <input type="search" maxlength="64" value="{{ Request::get('email') }}" name="email" class="form-control" />
                </div>
				<div class="form-group">
					<label>العنوان</label>
					<input type="search" maxlength="32" value="{{ Request::get('title') }}" name="title" class="form-control" />
				</div>
				<div class="form-group">
					<label>من</label>
				<input type="date" value="{{ Request::get('from') }}" max="{{ date('Y-m-d') }}" name="from" class="form-control" />
				</div>
				<div class="form-group">
					<label>إلى</label>
					<input type="date" value="{{ Request::get('to') }}" max="{{ date('Y-m-d') }}" name="to" class="form-control" />
				</div>
				<button type="submit" class="btn btn-primary btn-block mt-2">بحث</button>
			</form>
		</aside>
		<!--    End search box     -->


		<section class="col-lg-8 col-xl-9">

			<div id="messagesCollapsible" class="d-flex flex-column" role="tablist">

				@foreach($messages as $message)

                    <div class="bg-white box-list mb-1">

                        {{-- Start title of item --}}
                        <div class="px-4 border-bottom-0 py-3" role="tab" id="heading{{ $message->id }}">
                            <h5 class="mb-1 d-flex f-18px align-items-start">
                                @if($message->unread)
                                    <span class="label-state col-auto ml-1 text-white d-inline-block bg-danger">{{ $message->getState() }}</span> 
                                @endif
                                <a data-toggle="collapse" class="text-dark collapsed" href="#collapse{{ $message->id }}"
                                    aria-expanded="false" aria-controls="collapse{{ $message->id }}">{{ $message->title }}</a>
                            </h5>
                            <span class="text-muted f-15px d-inline-block">
                                <i class="fa fa-user mx-1"></i>
                                <bdi>{{ $message->name }}</bdi>
                                <i class="far fa-clock ml-1 mr-3"></i>
                                <bdi>{{$message->created_at->diffForHumans() }}</bdi>
                            </span>
                        </div>
                        {{-- end title of item --}}
                        
                        {{-- Start content of item --}}
                        <div id="collapse{{ $message->id }}" class="collapse border-top text-right" role="tabpanel" aria-labelledby="heading{{ $message->id }}" data-parent="#messagesCollapsible">
                            <div class="px-4 pt-3 text-secondary">

                                <div class="row justify-content-between">

                                    {{-- Start info about message --}}
                                    <ul class="col-auto message-info list-unstyled mb-0">
                                        <li>
                                            <span class="info-icon"><i class="fa fa-envelope ml-1"></i></span>
                                            {{ $message->email }}
                                        </li>
                                        <li>
                                            <span class="info-icon"><i class="fa fa-phone ml-1"></i></span>
                                            <bdi>{{ $message->phone }}</bdi>
                                        </li>
                                        <li title="{{ $message->ip }}">
                                            <span class="info-icon"><i class="fa fa-map-marker-alt ml-1"></i></span>
                                            {{ $message->country.' - '.$message->city }}
                                        </li>
                                        <li>
                                            <span class="info-icon"><i class="far fa-clock ml-1"></i></span>
                                            <bdi>{{ $message->created_at() }}</bdi>
                                        </li>
                                    </ul>
                                    {{-- End info about message --}}

                                    {{-- Start delete and update options --}}
                                    <div class="col-auto">

                                        @if(hasRole('messages_edit'))
                                            @if($message->unread)
                                                <a href="{{ url('cp/messages/update/state',$message->id) }}" class="btn btn-dark btn-sm ml-1 text-white">
                                                    <i class="fas fa-check fa-fx"></i>
                                                </a>
                                            @else
                                                <a href="{{ url('cp/messages/update/state',$message->id) }}" class="btn btn-secondary btn-sm ml-1 text-white">
                                                    <i class="fas fa-times fa-fx"></i>
                                                </a>
                                            @endif
                                        @endif
                                        
                                        @if(hasRole('messages_delete'))
                                            <button type="button" class="btn btn-danger btn-sm btnDelete" data-toggle="modal" data-target="#deleteModel" data-id="{{ $message->id }}">
                                                <i class="fas fa-trash fa-fx"></i>
                                            </button>
                                        @endif
                                        
                                    </div>
                                    {{-- End delete and update options --}}

                                </div>
                                
                                <hr class="align-self-center w-75"/>

                                <p class="pre-wrap mt-3 pb-4">{{ $message->content }}</p>

                            </div>
                        </div>
                        {{-- End content of item --}}
                        
                    </div>

				@endforeach

			</div>

			<div class="pagination-center mt-4"> {{ $messages->links() }}</div>

		</section>

	</div>

   
   
   
    {{--     Start Modal deleteModel --}}
    <div class="modal fade" id="deleteModel" tabindex="-1" role="dialog" aria-labelledby="deleteModelLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
    
                <div class="modal-header">
                    <h5 class="modal-title" id="deleteModelLabel">حذف رسالة</h5>
                    <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
               
                <form class='formSendAjaxRequest' redirect-to="{{ Request::url() }}" refresh-seconds='2' action="{{ url('cp/messages') }}" method="post">
                    
                    <div class="modal-body text-right">
                        <div class="formResult text-center"></div>
                        @method('DELETE')
                        @csrf
                        <input type="hidden" name="id" />
                        هل أنت متأكد أنك تريد حذف الرسالة ؟
                    </div>
    
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">حذف</button>
                        <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">إلغاء</button>
                    </div>
    
                </form>
    
            </div>
        </div>
    </div>
    {{--     End Modal deleteModel    --}}

@endsection


@section('extra-js')
    <script>
    
        {{-- /*  When click on btnDelete that for delete item , change id in deleteModel */ --}}
        $('.btnDelete').click(function () {
            $('#deleteModel form input[name="id"]').val($(this).data('id'));
        });

    </script>
@endsection