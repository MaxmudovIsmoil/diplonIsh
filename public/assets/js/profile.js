$(document).ready(function() {

    $(document).on('click', '#js_profile_btn', function (e) {
        e.preventDefault();

        let modal = $('#profile_modal');
        modal.modal('show');
    });


    $(document).on('submit', '.js_profile_form', function (e) {
        e.preventDefault();
        let form = $(this);
        let modal = form.closest('#profile_modal');
        let name = form.find('.js_name')
        let phone = form.find('.js_phone')
        let photo = form.find('.js_photo')
        let username = form.find('.js_username')
        let password = form.find('.js_password')

        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: new FormData(this),
            dataType: "JSON",
            contentType: false,
            cache: false,
            processData: false,
            success: (response) => {
                console.log(response);
                if (response.success) {
                    modal.modal('hide');
                    window.location.reload();
                }
            },
            error: (e) => {
                console.log('error: ', e)
                if (typeof response.responseJSON.errors !== 'undefined') {
                    if (e.responseJSON.errors.name) {
                        name.addClass('is-invalid')
                        name.siblings('.invalid-feedback').html(e.responseJSON.errors.name[0])
                    }
                    if (e.responseJSON.errors.phone) {
                        phone.addClass('is-invalid')
                        phone.siblings('.invalid-feedback').html(e.responseJSON.errors.phone[0])
                    }
                    if (e.responseJSON.errors.username) {
                        username.addClass('is-invalid')
                        username.siblings('.invalid-feedback').html(e.responseJSON.errors.username[0])
                    }
                    if (e.responseJSON.errors.password) {
                        password.addClass('is-invalid')
                        password.siblings('.invalid-feedback').html(e.responseJSON.errors.password[0])
                    }
                    if (e.responseJSON.errors.photo) {
                        photo.addClass('is-invalid')
                        photo.siblings('.invalid-feedback').html(e.responseJSON.errors.photo[0])
                    }
                }
            }
        });
    });

});
