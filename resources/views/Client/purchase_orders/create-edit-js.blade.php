<script>


        var form = $('#form-order');

        /******** Start helper functions ********/

            /**
            *  Add Row to table with input fildes to form(form for purchase order)
            * @param link {string} link value
            * @param count {integer} count value
            * @param color {string} color value
            * @param desc {string} desc value
            * @param id {integer} id value
            * @param row_state {string} state of row , must be (added|updated|default)
            */
            function addRowInput(link = '', count = '', color = '',desc = '', id = '', row_state = 'default') {

                row_num = getRowsCount(form) + 1;
                if(getRowsCount(form)<15)
                {
                $(form).find('tbody').append(
                    '<tr>'
                    + ((id) ? '<input type="hidden" name="items[id][]" value="' + id + '" />' : '')
                    + '    <input type="hidden" name="items[row_state][]" value="' + row_state + '" />'
                    + '    <th scope="row">' + row_num + '</th>'
                    + '    <td>'
                    + '        <textarea class="form-control" minlength="3" maxlength="150" name="items[desc][]" required>' + desc + '</textarea>'
                    + '        <div class="invalid-feedback text-center">@lang("validation.between.string",["attribute"=>"الوصف","min"=> 3 ,"max"=>150])</div>' {{-- this line will get value using laravl --}}
                    +'    </td>'
                    + '    <td>'
                    +'         <input type="url" pattern="[^\\s]+" value="' + link + '" class="form-control" name="items[link][]" placeholder="https://www.example.com/item" required>'
                    + '    </td>'
                    + '    <td>'
                    +'         <input type="number" min="1" value="' + count + '" name="items[count][]" class="form-control" required>'
                    + '    </td>'
                    + '    <td>'
                    +'         <input type="color" value="' + color + '" class="form-control" name="items[color][]" required>'
                    + '    </td>'
                    + '    <td>'
                    + '        <div class="d-flex mt-1">'
                    + '            <button type="button" class="btn btn-danger btn-sm btnDeleteRow ml-1"><i class="fa fa-trash"></i></button>'
                    + '            <button type="button" class="btn btn-primary btn-sm btnAddRow"><i class="fa fa-plus"></i></button>'
                    + '        </div>'
                    + '    </td>'
                    + '</tr>'
                );

            }
        }

            /**
            * add rowInputItemEmptyWithStatusAdded
            * @param listContainer {object} parent of tbody
            */
            function addRowInputEmptyWithStatusAdded(){
                addRowInput('', '', '', '', '', 'added');
            }
            /******** End helper functions ********/


            /********   Start events    ********/

            {{-- /* when user click on add button , add new item to list */ --}}
            $(form).on('click', '.btnAddRow', function () {
                addRowInputEmptyWithStatusAdded();
            });

            {{-- /* on user click on delete button , delete current item from form list */ --}}
            $(form).on('click', '.btnDeleteRow', function () {

                if (getRowsCount(form) <= 1) {
                    {{-- /* Kepp at least one item in list to allow to user add new items from it */ --}}
                    return false;
                }

                var tr = $(this).closest('tr');
                var id = $(tr).find('[name="items[id][]"]').val();

                if (id) {
                    {{-- /* if id exsits that means user edit data and remove current item, so I have to save it as deleted value */ --}}
                    $(form).append('<input type="hidden" name="deleted_items[]" value="' + id + '" />');
                }

                tr.remove();
                tableNumbering(form);
            });

            /********   End events    ********/


</script>
