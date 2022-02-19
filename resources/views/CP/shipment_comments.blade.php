@extends('CP.layouts.header-footer') 
@section('content')


    <h4 class="font-weight-bold text-right">تعليقات الشحنات {{ $comments->total() }}</h4>


	<div class="row pt-4 mb-5 text-right">

		<!--    Start search box     -->
		<aside class="col-lg-4 col-xl-3 mb-5">
			<form action="{{ Request::url() }}">
                
                <input type="hidden" name="search" value="1" />
                
                <div class="form-group">
					<label>الحالة</label>
					<select name="state" class="form-control setValue" value="{{ Request::get('state') }}" >
                        <option value="" selected>الكل</option>
                        @foreach (trans('shipmentComments.status') as $key => $value)
						    <option value="{{ $key }}">{{ $value }}</option>
                        @endforeach
					</select>
                </div>
                
                <div class="form-group">
                    <label>رقم الشحنة</label>
                    <input type="number" min="1" value="{{ Request::get('shipment_id') }}" name="shipment_id" class="form-control" />
                </div>
                
                <div class="form-group">
                    <label>رقم العضوية</label>
                    <input type="number" min="1" value="{{ Request::get('code') }}" name="code" class="form-control" />
                </div>
                
                <div class="form-group">
					<label>المستخدم</label>
					<select name="user" class="form-control setValue" value="{{ Request::get('user') }}" >
                        <option value="" selected>الكل</option>
                        @foreach ($users as $user)
						    <option value="{{ $user->id }}">{{ $user->name }}</option>
                        @endforeach
					</select>
                </div>

				<div class="form-group">
					<label>التعليق</label>
					<input type="search" maxlength="32" value="{{ Request::get('comment') }}" name="comment" class="form-control" />
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


        {{-- Start show comments --}}
		<section class="col-lg-8 col-xl-9">

			<div id="shipmentCommentsCollapsible" class="d-flex flex-column" role="tablist">

				@foreach($comments as $comment)

                    <div class="bg-white shadow box-list mb-1" id="{{ $comment->id }}">

                        {{-- Start title of item --}}
                        <div class="px-4 border-bottom-0 py-3" role="tab" id="heading{{ $comment->id }}">
                            
                            <h5 class="mb-1 d-flex f-18px align-items-start">
                                @if(!$comment->userCanEditComment() && $comment->unread)
                                    <span class="label-state col-auto ml-1 text-white d-inline-block bg-danger">{{ $comment->getState() }}</span> 
                                @endif
                                <a data-toggle="collapse" class="text-dark text-truncate collapsed" href="#collapse{{ $comment->id }}"
                                    aria-expanded="false" aria-controls="collapse{{ $comment->id }}">{{ $comment->comment }}</a>
                            </h5>
                            
                            <span class="text-muted f-15px d-inline-block">
                                <i class="fa fa-user mx-1"></i>
                                <span>{{ $comment->getCommenter() }}</span>
                                <a href="{{ url("cp/shipping-invoices/$comment->shipment_id#$comment->id") }}" class="text-muted">
                                    <i class="fa fa-cubes ml-1 mr-3"></i>
                                    <bdi>{{$comment->shipment_id }}</bdi>
                                </a>
                                <i class="far fa-clock ml-1 mr-3"></i>
                                <bdi>{{$comment->created_at() }}</bdi>
                            </span>

                        </div>
                        {{-- end title of item --}}
                        
                        {{-- Start content of item --}}
                        <div id="collapse{{ $comment->id }}" class="collapse border-top text-right" role="tabpanel" aria-labelledby="heading{{ $comment->id }}" data-parent="#shipmentCommentsCollapsible">
                            <div class="px-4 pt-3 text-secondary">

                                <div class="row">

                                    {{-- Start info about message --}}
                                    <div class="col">
                                        <p class="comment-content pre-wrap pb-4">{{ $comment->comment }}</p>
                                    </div>
                                    {{-- End info about message --}}

                                    {{-- Start delete and update options --}}
                                    <div class="col-auto">
                                        
                                        @if(hasRole('shipment_comments_edit') && !$comment->userCanEditComment())
                                            
                                            @if($comment->unread)
                                                <a href="{{ url('/cp/shipment-comments/update/state',$comment->id) }}" class="btn btn-dark btn-sm text-white">
                                                    <i class="fas fa-check fa-fx"></i>
                                                </a>
                                            @else
                                                <a href="{{ url('/cp/shipment-comments/update/state',$comment->id) }}" class="btn btn-secondary btn-sm text-white">
                                                    <i class="fas fa-times fa-fx"></i>
                                                </a>
                                            @endif

                                        @endif

                                        
                                        @if(hasRole('shipment_comments_delete'))

                                            <button type="button" class="btn btn-danger btn-sm btnDeleteComment" data-toggle="modal" data-target="#deleteCommentModal">
                                                <i class="fas fa-trash fa-fx"></i>
                                            </button>

                                        @endif
                                        
                                    </div>
                                    {{-- End delete and update options --}}

                                </div>

                            </div>
                        </div>
                        {{-- End content of item --}}
                        
                    </div>

				@endforeach

			</div>

			<div class="pagination-center mt-4"> {{ $comments->links() }}</div>

		</section>
        {{-- End show comments --}}

	</div>


    
    @if(hasRole('shipment_comments_delete'))
    
        <!--    Start Modal deleteCommentModal -->
        <div class="modal fade" id="deleteCommentModal" tabindex="-1" role="dialog" aria-labelledby="deleteCommentModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deleteCommentModalLabel">حذف تعليق</h5>
                        <button type="button" class="close ml-0" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                    </div>
                    <form class='formSendAjaxRequest' refresh-seconds='2' action="{{ url('/cp/shipment-comments') }}"
                        method="post">
                        <div class="modal-body text-right">
                            <div class="formResult text-center"></div>
                            @method('DELETE')
                            {{ csrf_field() }}
                            <input type="hidden" name="id" />
                            هل أنت متأكد أنك تريد حذف التعليق ؟
                            <hr/>
                            <p>{{-- I will set content of comment here using JS --}}</p>
                        </div>
                        <div class="modal-footer">
                            <button type="submit" class="btn btn-danger">حذف</button>
                            <button type="button" class="btn btn-secondary mr-2" data-dismiss="modal">إلغاء</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <!--    End Modal deleteCommentModal -->
        
    @endif


@endsection


@section('extra-js')
    <script>
    
        {{-- /*  When click on btnDelete that for delete item , change id in deleteModel */ --}}
        $('.btnDeleteComment').click(function(){
            var commentBox = $(this).closest('.box-list');
            $('#deleteCommentModal form input[name="id"]').val($(commentBox).attr('id'));
            $('#deleteCommentModal form p').html($(commentBox).find('.comment-content').html());
        });

    </script>
@endsection