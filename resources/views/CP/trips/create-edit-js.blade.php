@section('extra-js')

    <script>

        var table = $('#tableInvoices');
        var tableBody = $(table).find('tbody');

        /**
         * Add row to table
         * @param invoice   object of invoice to add invoice to table
         */
        function AddRow(invoice) {

            row_num = getRowsCount(table) + 1;

            $(tableBody).append(
                '<tr>'
                + '    <th>' + row_num + '</th>'
                + '    <td>'
                + '        <div class="form-group mb-0 pr-4">'
                + '            <div class="custom-control custom-checkbox">'
                + '                <input type="checkbox" name="invoices[]" value="' + invoice.id + '" class="custom-control-input" id="customControInvoice_' + row_num + '">'
                + '                <label class="custom-control-label" for="customControInvoice_' + row_num + '">' + invoice.id + '</label>'
                + '            </div>'
                + '        </div>'
                + '    </td>'
                + '    <td>' + invoice.tracking_number + '</td>'
                + '    <td>' + invoice.shipment_code + '</td>'
                + '    <td>'
                            {{-- /* this line will compile with laravel */  --}}
                + '         <a target="_blank" href="{{ url('cp/customers') }}/' + invoice.customer_id + '">' + invoice.customer_code + '</a>'
                + '    </td>'
                + '    <td><bdi>' + invoice.created_at + '</bdi></td>'
                + '    <td><bdi>' + invoice.arrived_at + '</bdi></td>'
                + '    <td>'
                            {{-- /* this line will compile with laravel */  --}}
                + '         <a class="btn btn-sm btn-outline-primary" target="_blank" href="{{ url('cp/shipping-invoices') }}/' + invoice.id + '">'
                + '             <i class="fas fa-binoculars"></i>'
                + '         </a>'
                + '    </td>'
                + '</tr>'
            );
        }


        var request;

        {{-- /* get invoices depends on address and add them to table */  --}}
        function getInvoices(address) {

            $(tableBody).html('<tr><td colspan="6"><div class="loader text-center"><label class="loader-shape mb-3"></label></div></td></tr>');

            $('#checkBoxSelectAll').prop('checked',false );

            request = $.ajax({
                url: "{{ url('cp/shipping-invoices/short') }}/" + address,
                dataType: 'json',
                method: 'GET',
            })
                .done(function (result) { /* Form seneded success without any error */
                    $(tableBody).empty();
                    $.each(result, function (key, invoice) {
                        AddRow(invoice);
                    });
                })
                .fail(function (result) { /* There is error in send form or in server-side */
                    try {
                        var errorString = '<tr><td colspan="6"><div class="alert alert-danger alert-dismissible text-right fade show" role="alert"><ul class="mb-0">';
                        var response = JSON.parse(result.responseText);
                        if (response.errors) {
                            $.each(response.errors, function (key, value) {
                                errorString += '<li>' + value + '</li>';
                            });
                        }
                        else {
                            errorString += '<li>حدث خطأ</li>';
                            console.error(response.message);
                        }
                    } catch (e) {
                        errorString += '<li>حدث خطأ يرجى التأكد من اتصالك بالإنترنت وإعادة المحاولة</li>';
                    } finally {
                        errorString += '</ul><button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button></div></td></tr>';
                        tableBody.html(errorString);
                    }
                })
                .always(function () {
                    request = null;
                });
        }

        {{-- /*  When user click on get addresses then cancle old request if exists and send new request */  --}}
        $('#buttonAddress').click(function () {
            if (request) {
                request.abort();
            }
            var address = parseInt($('#inputAddress').val());
            if (address != null && address != undefined && address != NaN && address > 0) {
                getInvoices(address);
            }
        })


        {{-- /* when user click select all , select all invoice or unselect them depends on checked property */  --}}
        $('#checkBoxSelectAll').change(function(){
            $(tableBody).find('input[type=checkbox]').prop('checked',this.checked);
        })

        {{-- /* when invoice in table selected or unselected check if all invoices selected then select (select all option) */  --}}
        $(tableBody).on('change','input[type=checkbox]',function(){
            checkIfAllInvoicesChecked();
        });

        {{-- /* check if all invoices checked then select (select all option) */  --}}
        function checkIfAllInvoicesChecked(){
            var isSelected = $(tableBody).find('input[type=checkbox]').length == $(tableBody).find('input[type=checkbox]:checked').length;
            $('#checkBoxSelectAll').prop('checked',isSelected);
        }

        /* call funtion to set state of selectAll after user load page {{--  for update --}} */
        checkIfAllInvoicesChecked();



        {{-- /* when user change state , then change arrived_at input filed properties to make user inster correct logical data */  --}}
        $('#inputState').change(function(){
            if(this.value == 3){
                $('#inputArrivedAt').prop('required',true).prop('disabled',false);
            }else{
                $('#inputArrivedAt').prop('required',false).prop('disabled',true).val('');
            }
        });

        /* trigger event to check filde after user load page {{--  for update --}} */
        $('#inputState').trigger('change');


        var main_currency = {{ app_settings()->currency_type_id }}

        {{-- /* Set default value of exchange_rate depends on selected currency for cost */ --}}
        $('#inputCurrency').change(function(){
            var selected_currency = $(this).find('option:selected');
            var exchange_rate_input =  $('#inputExchangeRate');
            if(main_currency == selected_currency.val()){
                exchange_rate_input.val(1).prop("readonly", true);
            }
            else
            {
                exchange_rate_input.val(selected_currency.data('value')).prop("readonly", false);
            }
        });

    </script>

@endsection
