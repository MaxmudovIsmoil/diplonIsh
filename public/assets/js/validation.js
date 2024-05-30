
/** modal close inputs in clear **/
$('#add_edit_modal button[data-dismiss="modal"]').click(function () {

    let form = $('.js_add_edit_form')

    let username = form.find('.js_username')
    if(username) {
        username.val('')
        username.removeClass('is-invalid')
        username.siblings('.invalid-feedback').addClass('valid-feedback')
    }

    let password = form.find('.js_password')
    if(password) {
        password.val('')
        password.removeClass('is-invalid')
        password.siblings('.invalid-feedback').addClass('valid-feedback')
    }

    // plan ru
    let name_ru = form.find('.js_name_ru')
    if(name_ru) {
        name_ru.val('')
        name_ru.removeClass('is-invalid')
        name_ru.siblings('.invalid-feedback').addClass('valid-feedback')
    }

    let name_uz = form.find('.js_name_uz')
    if(name_uz) {
        name_uz.val('')
        name_uz.removeClass('is-invalid')
        name_uz.siblings('.invalid-feedback').addClass('valid-feedback')
    }

    let name = form.find('.js_name')
    if(name) {
        name.val('')
        name.removeClass('is-invalid')
        name.siblings('.invalid-feedback').addClass('valid-feedback')
    }

})


$('#add_order_modal button[data-dismiss="modal"]').click(function () {

    let form = $('.js_add_form')

    // theme
    let theme = form.find('.js_theme')
    if(theme) {
        theme.val('')
        theme.removeClass('is-invalid')
        theme.siblings('.invalid-feedback').addClass('valid-feedback')
    }

    let inputs = form.find('input[type="text"]')
    inputs.val('')

});

$('#order_reply_modal button[data-dismiss="modal"]').click(function () {
    let comment = $('.js_reply_comment')
    if(comment) {
        comment.val('')
        comment.removeClass('is-invalid')
        comment.siblings('.invalid-feedback').addClass('valid-feedback')
    }
});

$('#add_order_detail_modal button[data-dismiss="modal"]').click(function () {

    let form = $('.js_add_order_detail_form')

    let name = form.find('.js_name')
    if(name) {
        name.val('')
        name.removeClass('is-invalid')
        name.siblings('.invalid-feedback').addClass('valid-feedback')
    }


    let count = form.find('.js_count')
    if(count) {
        count.val('')
        count.removeClass('is-invalid')
        count.siblings('.invalid-feedback').addClass('valid-feedback')
    }

    let pcs = form.find('.js_pcs')
    if(pcs) {
        pcs.val('')
        pcs.removeClass('is-invalid')
        pcs.siblings('.invalid-feedback').addClass('valid-feedback')
    }

    let address = form.find('.js_address')
    if(address) {
        address.val('')
        address.removeClass('is-invalid')
        address.siblings('.invalid-feedback').addClass('valid-feedback')
    }

    let approximate_price = form.find('.js_approximate_price')
    if(approximate_price) {
        approximate_price.val('')
        approximate_price.removeClass('is-invalid')
        approximate_price.siblings('.invalid-feedback').addClass('valid-feedback')
    }

})


$('input').on('input', function () {
    $(this).removeClass('is-invalid')
    $(this).siblings('.invalid-feedback').addClass('valid-feedback')
})

$('.js_photo').on('change', function () {
    $(this).removeClass('is-invalid')
    $(this).siblings('.invalid-feedback').addClass('valid-feedback')
});

$('.js_instance').on('change', function () {
    $(this).removeClass('is-invalid')
    $(this).siblings('.invalid-feedback').addClass('valid-feedback')
});
