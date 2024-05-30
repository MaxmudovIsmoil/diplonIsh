
function addNewFileTr(data) {
    let length = $('.js_order_file_tbody tr').length + 1;
    const deleteUrl = window.location.href + "-file/delete/" + data.id;
    let tr = '<tr class="js_this_tr file-id-' + data.id + '" data-id="' + data.id + '">\n' +
        '    <td>'+length+'</td>\n' +
        '    <td>'+data.name+'</td>\n' +
        '    <td><a href="/storage/files/'+data.file+'" target="_blank">'+data.file+'</a></td>\n' +
        '    <td class="text-center">\n' +
        '        <a class="text-danger js_delete_btn" data-url="' + deleteUrl + '"><i class="fas fa-trash"></i></a>\n' +
        '    </td>\n' +
        '</tr>';

    $('.js_order_file_tbody').append(tr);
}


$(document).ready(function() {

    var body = $('body');

    body.delegate('.js_add_order_file_btn', 'click', function (e) {
        e.preventDefault();
        let storeUrl = $(this).data('url')
        let modal = $('#add_order_file_modal');
        let orderId = $('#order_show_modal').data('orderId');
        let form = modal.find('.js_add_order_file_form');

        modal.find('.modal-title').html('Add order file');
        form.attr('action', storeUrl)
        form.find('.js_order_id').val(orderId);

        modal.modal('show');
    });


    // add
    body.delegate('.js_add_order_file_form', 'submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let modal = form.closest('#add_order_file_modal');
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: new FormData(this),
            dataType: "JSON",
            contentType: false,
            processData: false,
            success: (response) => {
                // console.log('res: ', response)
                if (response.success) {
                    addNewFileTr(response.data);
                    modal.find('input[type="text"]').val('');
                    modal.modal('hide');
                }
            },
            error: (response) => {
                console.log('error: ', response);
                if(typeof response.responseJSON.errors !== 'undefined') {
                    let name = form.find('.js_name');
                    let orderFile = form.find('.js_file');

                    if(response.responseJSON.errors.name) {
                        name.addClass('is-invalid')
                        name.siblings('.invalid-feedback').html(response.responseJSON.errors.name[0])
                    }
                    if(response.responseJSON.errors.file) {
                        orderFile.addClass('is-invalid')
                        orderFile.siblings('.invalid-feedback').html(response.responseJSON.errors.file[0])
                    }
                }
            }
        });
    });


    body.delegate('.js_order_file_delete_btn', 'click', function (e) {
        e.preventDefault();
        let deleteModal = $('#deleteModal');
        let name = $(this).data('name')
        let url = $(this).data('url')
        deleteModal.find('.modal-title').html(name)

        let form = deleteModal.find('#js_modal_delete_form')
        form.attr('action', url)
        deleteModal.modal('show');
    });


    body.delegate('#js_modal_delete_form', 'submit', function (e) {
        e.preventDefault();
        let deleteModal = $('#deleteModal');
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: (response) => {
                if(!response.success) {
                    deleteModal.find('.js_message').addClass('d-none')
                    deleteModal.find('.js_danger').html(response.error)
                }
                // console.log('res', response)
                if(response.success) {
                    let tr = $('.js_order_file_tbody .file-id-'+response.data);
                    tr.nextAll().each(function() {
                        let item = $(this).find('td:first').html() - 1;
                        $(this).find('td:first').html(item);
                    });
                    tr.remove();
                    deleteModal.modal('hide')
                }
            },
            error: (response) => {
                console.log('error:', response);
            }
        });

    });
});
