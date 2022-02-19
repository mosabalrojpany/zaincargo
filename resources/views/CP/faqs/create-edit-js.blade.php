 
@section('extra-js')
    <script src="{{ url('js/ckeditor/ckeditor.js') }}" ></script> 
    <script src="{{ url('js/ckeditor/lang/ar.js') }}" ></script> 
    <script>

        CKEDITOR.replace( 'editor',{ height : 250,
                filebrowserImageBrowseUrl : "{{ url('/cp/laravel-filemanager?type=Images') }}",
                filebrowserImageUploadUrl : "{{ url('/cp/laravel-filemanager/upload?type=Images&_token=') }}" ,
                filebrowserBrowseUrl :      "{{ url('/cp/laravel-filemanager?type=Files') }}" ,
                filebrowserUploadUrl :      "{{ url('/cp/laravel-filemanager/upload?type=Files&_token=') }}" ,
             }); 

        $('#form-post button').click(function (e) {

            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }

            if (strip_tags(CKEDITOR.instances.editor.getData()).length < 12) {
                
                e.preventDefault();
                e.stopPropagation();
                
                $('#form-post').find('.formResult').html(
                    '<div class="alert alert-danger alert-dismissible text-right fade show" role="alert">'
                    +   'يجب أن تكون الإجابة على الأقل 12 حرفا'
                    +   '<button type="button" class="close" data-dismiss="alert" aria-label="Close">'
                    +       '<span aria-hidden="true">&times;</span>'
                    +   '</button>'
                    +'</div>'
                );
                
                $("html ,body").animate({
                    scrollTop: $('.breadcrumb').offset().top
                }, 'slow');
                
            }
        });

    </script>
@endsection