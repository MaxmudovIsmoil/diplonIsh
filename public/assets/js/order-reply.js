$(document).on('click', '.js_reply_btn', function () {

    let replyModal = $('#order_reply_modal');
    let orderId = $(this).closest('#order_show_modal').data('orderId');
    replyModal.find('.js_order_id').val(orderId);
    let status = $(this).data('status');
    let text = $(this).data('text');

    let b_text = replyModal.find('.js_text');
    if (status === 2) {
        if (b_text.hasClass('text-danger'))
            b_text.removeClass('text-danger');

        b_text.addClass('text-success');
        b_text.html(text);

        replyModal.find('.js_status').val(status);
    }
    else {
        if (b_text.hasClass('text-success'))
            b_text.removeClass('text-success');

        b_text.addClass('text-danger');
        b_text.html(text);

        replyModal.find('.js_status').val(status);
    }
    replyModal.modal('show');
});

$(document).on('submit', '.js_reply_form', function(e) {
    e.preventDefault();
    let orderId = $(this).find('.js_order_id').val();
    let showModal = $("#order_show_modal");

    let form = $(this)
    $.ajax({
        type: "POST",
        url: form.attr('action'),
        data: form.serialize(),
        dataType: "JSON",
        success: (response) => {
            //console.log('res: ', response)
            if (response.success === true) {
                getOrderActions(orderId, showModal);
                showModal.find('.action-div').addClass('d-none');
                $(this).find('.js_reply_comment').val('');
                $(this).closest('#order_reply_modal').modal('hide');
            }
        },
        error: (response) => {
            console.log('reply-error: ', response)
            if(typeof response.responseJSON !== "undefined") {
                if (response.responseJSON.errors.comment[0] === 'The comment field is required.') {
                    let comment = $(this).find('.js_reply_comment');
                    comment.addClass('is-invalid')
                    comment.siblings('.invalid-feedback').html(response.errors.comment[0])
                }
            }
        }
    })
});
