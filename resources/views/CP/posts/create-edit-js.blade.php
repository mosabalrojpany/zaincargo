
@section('extra-js')

    <script src="{{ url('js/ckeditor/ckeditor.js') }}" ></script> 
    <script src="{{ url('js/ckeditor/lang/ar.js') }}" ></script> 
    <script> 

        CKEDITOR.replace('editor',{
            height : 500,
            filebrowserImageBrowseUrl : "{{ url('/cp/laravel-filemanager?type=Images') }}",
            filebrowserImageUploadUrl : "{{ url('/cp/laravel-filemanager/upload?type=Images&_token=') }}" ,
            filebrowserBrowseUrl :      "{{ url('/cp/laravel-filemanager?type=Files') }}" ,
            filebrowserUploadUrl :      "{{ url('/cp/laravel-filemanager/upload?type=Files&_token=') }}" , 
        });

        $('#form-post button').click(function (e) {
            
            for (instance in CKEDITOR.instances) {
                CKEDITOR.instances[instance].updateElement();
            }
            var form = $('#form-post');

            var errors = [];
            if ($(form).find('input[name="tags[]"]').length == 0) {
                errors.push('يرجى تحديد التصنيف');
            }
            if (strip_tags(CKEDITOR.instances.editor.getData()).length < 32) {
                errors.push('يجب أن يكون المحتوى على الأقل 32 حرفا');
            }
            if(errors.length > 0){
                var errorString = '<div class="alert alert-danger alert-dismissible text-right fade show" role="alert"><ul class="mb-0">';
                errors.forEach(element => {
                    errorString +='<li>'+element+'</li>';                     
                });    
                errorString += '</ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                $(form).find('.formResult').html(errorString);
                $("html ,body").animate({
                    scrollTop: $('.breadcrumb').offset().top
                }, 'slow');
            }
            if (errors.length > 0 /* || form.checkValidity() === false */) {
                e.preventDefault();
                e.stopPropagation();
            }
        });
        
    </script>

@endsection