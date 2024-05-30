function addNewTr(data) {
    const length = $('.js_order_detail_tbody tr').length + 1;
    const href = window.location.href;
    const updateUrl = `${href}-detail/update/${data.id}`;
    const deleteUrl = `${href}-detail/delete/${data.id}`;

    const tr = `<tr class="js_this_tr order-detail-id-${data.id}" data-id="${data.id}">
                    <td>${length}</td>
                    <td>${data.name}</td>
                    <td>${data.count}</td>
                    <td>${data.pcs}</td>
                    <td>${data.price_source}</td>
                    <td class="link-td">
                        <a href='${data.address}' target="_blank"  data-content="${data.address}">Link</a>
                        <div class="popover custom-show bs-popover-top" role="tooltip" id="popover-${data.id}" x-placement="right">
                            <div class="popover-header"><i class="fas fa-copy js_copy_link"> copy </i></div>
                            <div class="popover-body">${data.address}</div>
                        </div>
                    </td>
                    <td class="text-right d-flex justify-content-end">
                        <a class="text-primary mr-1 js_edit_order_detail_btn" data-url="${updateUrl}"><i class="fas fa-pen"></i></a>
                        <a class="text-danger js_delete_order_detail_btn" data-name="${data.name}" data-url="${deleteUrl}"><i class="fas fa-trash"></i></a>
                    </td>
                </tr>`;

    $('.js_order_detail_tbody').append(tr);
}


function editThisTr(id, data) {
    $('tr.order-detail-id-' + id + ' td:nth-child(2)').html(data.name);
    $('tr.order-detail-id-' + id + ' td:nth-child(3)').html(data.count);
    $('tr.order-detail-id-' + id + ' td:nth-child(4)').html(data.pcs);
    $('tr.order-detail-id-' + id + ' td:nth-child(5)').html(data.price_source);
    $('tr.order-detail-id-' + id + ' td:nth-child(6)').html(data.address);
}

$(document).ready(function() {

    var body = $('body');

    body.delegate('.js_add_order_detail_btn', 'click', function (e) {
        e.preventDefault();
        let storeUrl = $(this).data('url')
        let modal = $('#add_edit_order_detail_modal');
        let orderId = $('#order_show_modal').data('orderId');
        let form = modal.find('.js_add_edit_order_detail_form');

        modal.find('.modal-title').html('Add order detail');
        form.attr('action', storeUrl)
        form.attr('data-action-type', 1);
        form.find('.js_order_id').val(orderId);

        modal.modal('show');
    });

    // edit
    body.delegate('.js_edit_order_detail_btn', 'click', function (e) {
        e.preventDefault();
        let modal = $('#add_edit_order_detail_modal');
        let orderId = $('#order_show_modal').data('orderId');

        let updateUrl = $(this).data('url');
        let form = modal.find('.js_add_edit_order_detail_form');
        form.attr('action', updateUrl);
        form.attr('data-action-type', 2);

        let tr = $(this).closest('.js_this_tr');
        let id = tr.data('id');
        form.attr('data-order-detail-id', id);

        let name = tr.find('td:nth-child(2)').html();
        let count = tr.find('td:nth-child(3)').html();
        let pcs = tr.find('td:nth-child(4)').html();
        let price_source = tr.find('td:nth-child(5)').html();
        let address = tr.find('td:nth-child(6)').html();

        form.find('.js_order_id').val(orderId);
        form.find('.js_name').val(name);
        form.find('.js_count').val(count);
        form.find('.js_pcs').val(pcs);
        form.find('.js_price_source').val(price_source);
        form.find('.js_address').val(address);

        modal.find('.modal-title').html('Edit order detail ')
        modal.modal('show');
    });


    // add or edit
    body.delegate('.js_add_edit_order_detail_form', 'submit', function (e) {
        e.preventDefault();
        let form = $(this);
        let modal = form.closest('#add_edit_order_detail_modal');
        let actionType = form.attr('data-action-type');
        $.ajax({
            type: "POST",
            url: form.attr('action'),
            data: form.serialize(),
            dataType: "JSON",
            success: (response) => {
                // console.log('res: ', response);
                if (response.success) {
                    if (actionType == 1) {
                        // store
                        addNewTr(response.data);
                    }
                    else {
                        // update 2
                        let orderDetailId = form.attr('data-order-detail-id');
                        editThisTr(orderDetailId, response.data);
                    }
                    modal.find('input[type="text"]').val('');
                    modal.find('input[type="number"]').val('');
                    modal.modal('hide');
                }
            },
            error: (response) => {
                console.log('error: ', response);
                if(typeof response.responseJSON.errors !== 'undefined') {
                    let name = form.find('.js_name');
                    let count = form.find('.js_count');
                    let pcs = form.find('.js_pcs');
                    let price_source = form.find('.js_price_source');
                    let address = form.find('.js_address');

                    if(response.responseJSON.errors.name) {
                        name.addClass('is-invalid')
                        name.siblings('.invalid-feedback').html(response.responseJSON.errors.name[0])
                    }
                    if(response.responseJSON.errors.count) {
                        count.addClass('is-invalid')
                        count.siblings('.invalid-feedback').html(response.responseJSON.errors.count[0])
                    }
                    if(response.responseJSON.errors.price_source) {
                        price_source.addClass('is-invalid')
                        price_source.siblings('.invalid-feedback').html(response.responseJSON.errors.price_source[0])
                    }
                    if(response.responseJSON.errors.address) {
                        address.addClass('is-invalid')
                        address.siblings('.invalid-feedback').html(response.responseJSON.errors.address[0])
                    }
                    if(response.responseJSON.errors.pcs) {
                        pcs.addClass('is-invalid')
                        pcs.siblings('.invalid-feedback').html(response.responseJSON.errors.pcs[0])
                    }
                }
            }
        });
    });


    body.delegate('.js_delete_order_detail_btn', 'click', function (e) {
        e.preventDefault();
        let deleteModal = $('#deleteOrderDetailModal');
        let name = $(this).data('name');
        let url = $(this).data('url');
        deleteModal.find('.modal-title').html(name);

        let form = deleteModal.find('.js_delete_order_detail_form');
        form.attr('action', url);
        deleteModal.modal('show');
    });


    body.delegate('.js_delete_order_detail_form', 'submit', function (e) {
        e.preventDefault();
        let deleteModal = $('#deleteOrderDetailModal');
        $.ajax({
            type: "POST",
            url: $(this).attr('action'),
            data: $(this).serialize(),
            success: (response) => {
                if(!response.success) {
                    deleteModal.find('.js_message').addClass('d-none');
                    deleteModal.find('.js_danger').html(response.error);
                }
                console.log('res', response)
                if(response.success) {
                    let tr = $('.js_order_detail_tbody .order-detail-id-'+response.data);
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
