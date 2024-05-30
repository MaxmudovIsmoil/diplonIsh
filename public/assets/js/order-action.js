
$(document).on('click', '.js_accordion_btn', function () {
    let this_tr = $(this).closest('.js_this_tr');
    let orderCollapse = this_tr.next('tr').find('.js_order_collapse');
    let url = $(this).data('url');

    orderCollapse.slideToggle("slow", function()
    {
        if (orderCollapse.is(":hidden")) {
            orderCollapse.slideUp();
            // console.log('slide Up')
        }
        else {
            // console.log('Slide Down')
            $.ajax({
                type: "GET",
                url: url,
                dataType: "JSON",
                success: (response) => {
                    // console.log('res: ', response)
                    if (response.success) {
                        let div = $($.parseHTML(response.data));
                        div.last().find('.fas').remove();
                        orderCollapse.find('.card-body').html(div);
                        orderCollapse.slideDown();
                    }
                },
                error: (response) => {
                    console.log('error: ', response)
                }
            })
        }
    });
});

