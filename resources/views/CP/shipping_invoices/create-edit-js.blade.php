<script>

    
        var form = $('#form-invoice');
        var imagesToUpload = [];    {{--  /* array to save uploaded images */  --}}
        

        /******** Start helper functions ********/

           
            /**
            *  Add image to form(form for Invoices) 
            * @param fileId {string} unique id for file in array that used to save uploaded files
            * @param img {string} img that will be show
            * @param id {integer} id value in database
            */
            function addImage(fileId, img, id = null) {

                $('#imgs-container').append(
                    '<div class="col-auto mb-4">'
                    + '  <div class="image-upload">'
                    + '      <span class="image-upload-delete" data-id="' + (id ? id : '') + '" data-file-id="' + fileId + '" data-container=".col-auto">'
                    + '          <i class="fa fa-times"></i>'
                    + '      </span>'
                    + '      <label class="m-0 img-box avatar-invoice-item">'
                    + '          <img src="' + img + '" class="img-thumbnail w-100 h-100">'
                    + '      </label>'
                    + '  </div>'
                    + '</div>'
                );
                
            }


            /**
            *  Delete image from form(form for Invoices) 
            * @param fileId {string} unique id for file in array that used to save uploaded files
            */
            function deleteImage(fileId) {

                for (var i = 0; i < imagesToUpload.length; i++) {

                    if (fileId == imagesToUpload[i].id) {

                        imagesToUpload.splice(i, 1);
                        
                        return true;

                    }

                }
                
            }

            /**
            *  Get Random Id  
            */
            function getRandomId() {
                return Math.random() + Math.random().toString(36) + new Date().getTime().toString(36);
            }
            /******** End helper functions ********/


            /*  Start events to control in form    */
            
            /* Preview uploaded image to user when upload images  */
            $(form).on('change', '#main-img-uploder', function () {

                var acceptExtensions = this.accept.split(',');
                var readers =[] ;

                for (var i = 0; i < this.files.length; i++) {

                    var file = this.files[i];
                    var extension = file.name.substr(file.name.lastIndexOf('.'));

                    if ($.inArray(extension.toLowerCase(), acceptExtensions) == -1) {
                        continue;
                    }

                    readers.push(new FileReader());

                    readers[i].onload = function (e) {
                        addImage(e.target.fileId, e.target.result);
                    }

                    readers[i].fileId = getRandomId();
                    imagesToUpload.push({ id: readers[i].fileId, file: file });
                    readers[i].readAsDataURL(file);
                }

            });

            /* on user click on delete icon , delete current image from form */
            $(form).on('click', '.image-upload .image-upload-delete', function (e) {

                var id = $(this).data('id');
                var fileId = $(this).data('file-id');
                deleteImage(fileId);
                
                if (id) {/* if id exsits that means user edit data and remove current img, so I have to save it as deleted value */
                    $(form).append('<input type="hidden" name="deleted_items[]" value="' + id + '" />');
                }
            
            });
            
            /*  End events to control in form    */





        /*
        * Start submit form to server (ajax)
        */
        $('#form-invoice').submit(function (event) {

            event.preventDefault(); /* cancel send form */

            /* to use it inside methods (.ajax ..etc)   */
            var form = $(this);

            /*  Disable button submit to stop send many requests in the same time */
            var btnSend = $(this).find(':submit');
            btnSend.attr('disabled', 'disabled');

            var formResult = $(this).find('.formResult');
            formResult.html('<div class="loader"><span class="loader-value"></span><label class="loader-shape mb-3"></label></div>');

            $("html ,body").animate({ scrollTop: $(this).offset().top }, 'slow');

            var ajax_info = {
                url: $(this).attr('action'),
                method: 'POST',
                xhr: function () {

                    function showProgress(e) {
                        if (e.lengthComputable) {
                            var precent = Math.round(100 * e.loaded / e.total) + '%';
                            console.log(precent);
                            //$('.loader .loader-value').html(precent);
                        }
                    }
                    var xhr = new window.XMLHttpRequest();
                    //Upload progress
                    xhr.upload.addEventListener("progress", showProgress, false);
                    return xhr;
                }
            };

            var data = new FormData(this);

            for (var i = 0; i < imagesToUpload.length; i++) {
                data.append('imgs[]', imagesToUpload[i].file);
            }

            ajax_info['data'] = data;
            ajax_info['contentType'] = false;
            ajax_info['cache'] = false;
            ajax_info['processData'] = false;


            /* Start send post request to server */
            $.ajax(ajax_info)
                .done(function (result) { /* Form seneded success without any error */

                    formResult.html('<div class="alert alert-success alert-dismissible text-right fade show role="alert"><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>تمت العملية بنجاح</div>');

                    if (worksAsAdd) {
                        location.reload();
                        return true;
                    }
                    
                    /*  Redirect from server    */
                    if (result.redirectTo != null && result.redirectTo != undefined) {
                        setTimeout(function () {
                            location.href = result.redirectTo;
                        }, 2000);
                    }

                })

                .fail(function (result) { /* There is error in send form or in server-side */

                    try {
                        var errorString = '<div class="alert alert-danger alert-dismissible text-right fade show role="alert"><ul class="mb-0">';
                        var response = JSON.parse(result.responseText);
                        if (response.errors) {
                            $.each(response.errors, function (key, value) {
                                //errorString += '<li>' + value + '</li>';
                                $.each(value, function (k, v) {
                                    errorString += '<li>' + v + '</li>';
                                });
                            });
                        }
                        else {
                            errorString += '<li>حدث خطأ</li>';
                            console.error(response.message);
                        }
                    } catch (e) {
                        errorString += '<li>حدث خطأ يرجى التأكد من اتصالك بالإنترنت وإعادة المحاولة</li>';
                    } finally {
                        errorString += '</ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div>';
                        formResult.html(errorString);
                    }

                })

                .always(function () {

                    btnSend.removeAttr('disabled');

                });
            /* End send post request to server */


        });
        /*  End Form add (ajax)   */



</script>