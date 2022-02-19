

<script src="{{ url('js/sweetalert.min.js') }}"></script> 


<style>
    
    .swal-modal .swal-text  {
        text-align: center !important;
    }
    .swal-modal .swal-footer {
        text-align: center !important;
    }
    .swal-modal .swal-footer .swal-button{
        min-width: 100px;
    }
</style>

<script>
    
    function alertMsgError(msg ) {
        swal(msg, {
            icon: 'error',
            dangerMode: true,
            timer: 10000, 
        });  
    }

    function alertMsgSuccess(msg ) {
        swal(msg, {
            icon: 'success',
            dangerMode: false,
            timer: 10000, 
        });  
    } 
   
</script>   