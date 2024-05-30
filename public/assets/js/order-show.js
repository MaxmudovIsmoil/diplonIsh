/**** ############################## Order detail ############################# **/
function drawTrOrderDetails(detailData, checkBtn) {
    const href = window.location.href;
    let tr = ``;
    const trs = detailData.map((data, i) => {
        const { id, name, count, pcs, address, price_source } = data;
        const updateUrl = `${href}-detail/update/${id}`;
        const deleteUrl = `${href}-detail/delete/${id}`;

        tr += `<tr class="js_this_tr order-detail-id-${id}" data-id="${id}">
                    <td>${i + 1}</td>
                    <td>${name}</td>
                    <td>${count}</td>
                    <td>${pcs}</td>
                    <td>${price_source}</td>
                    <td class="link-td">
                        <a href='${address}' target="_blank"  data-content="${address}">Link</a>
                        <div class="popover custom-show bs-popover-top" role="tooltip" id="popover-${id}" x-placement="right">
                            <div class="popover-header"><i class="fas fa-copy js_copy_link"> copy </i></div>
                            <div class="popover-body">${address}</div>
                        </div>
                    </td>`;

        if(checkBtn) {
            tr += `<td class="text-right d-flex justify-content-end">
                       <a class="text-primary mr-1 js_edit_order_detail_btn" data-url="${updateUrl}"><i class="fas fa-pen"></i></a>
                       <a class="text-danger js_delete_order_detail_btn" data-name="${name}" data-url="${deleteUrl}"><i class="fas fa-trash"></i></a>
                   </td>`;
        }
        tr += `</tr>`;

        return tr;
    });

    $('.js_order_detail_tbody').html(trs.join(''));
}



function getOrderDetails(url, checkBtn) {
    $.ajax({
        type: "GET",
        url: url,
        dataType: "JSON",
        success: (response) => {
            // console.log('getOrderDetails: ', response)
            if (response.success) {
                drawTrOrderDetails(response.data, checkBtn);
            }
        },
        error: (response) => {
            console.log('order-detail-error: ', response);
        }
    })
}
/**** ############################## ./Order detail ############################# **/


/**** ############################## Order file ############################## **/

function drawTrOrderFiles(detailData) {
    const href = window.location.href;
    let trs = '';

    detailData.forEach((data, i) => {
        const deleteUrl = `${href}-file/delete/${data.id}`;
        trs += `
            <tr class="js_this_tr file-id-${data.id}" data-id="${data.id}">
                <td>${i + 1}</td>
                <td>${data.name}</td>
                <td><a href="/storage/upload/files/${data.file}" target="_blank">${data.file}</a></td>
                <td class="text-center">
                    <a class="text-danger js_order_file_delete_btn" data-url="${deleteUrl}">
                        <i class="fas fa-trash"></i>
                    </a>
                </td>
            </tr>`;
    });

    $('.js_order_file_tbody').html(trs);
}


function getOrderFiles(url) {
    $.ajax({
        type: "GET",
        url: url,
        dataType: "JSON",
        success: (response) => {
            // console.log('getOrderFiles: ', response)
            if (response.success) {
                drawTrOrderFiles(response.data);
            }
        },
        error: (response) => {
            console.log('file error: ', response);
        }
    })
}
/**** ############################## ./Order file ############################## **/


/**** ############################## Order action ############################# **/

function drawTrOrderAction(data) {
    const tbody = $('.js_order_action_tbody');
    const trArray = data.map((action, i) => `
        <tr>
            <td>${i + 1}</td>
            <td>${action.created_at}</td>
            <td>${action.user}</td>
            <td>${action.instance}</td>
            <td>${action.status}</td>
            <td>${action.comment}</td>
        </tr>`
    );
    tbody.html(trArray.join(''));
}


function getOrderActions(url) {
    $.ajax({
        type: "GET",
        url: url,
        dataType: "JSON",
        success: (response) => {
            console.log("getOrderAction: ", response);
            if (response.success) {
                drawTrOrderAction(response.data);
            }
        },
        error: (response) => {
            console.log('order-action-error: ', response);
        }
    })
}
/**** ############################## ./Order action ############################# **/


/**** ############################## Order plan ############################# **/

function drawOrderPlanTr(data, modal) {
    let tr = data.map(plan => {
        let users = plan.users.map(userOne => userOne.name).join(', ');
        return `<tr>
                    <td>${plan.instance}</td>
                    <td>${plan.stage}</td>
                    <td>${users}</td>
                </tr>`;
    }).join('\n');

    modal.find('.js_order_plan_tbody').html(tr);
}
function getOrderPlan(url, modal) {
    $.ajax({
        type: "GET",
        url: url,
        dataType: "JSON",
        success: (response) => {
            console.log('getOrderPlan: ', response);
            if (response.success) {
                drawOrderPlanTr(response.data, modal);
                modal.modal('show');
            }
        },
        error: (response) => {
            console.log('order-plan-error: ', response);
        }
    })
}
/**** ############################## ./Order plan ############################# **/


$(document).ready(function () {

    var showModal = $(document).find('#order_show_modal');

    $('.js_show_btn').on('click', function (e) {
        e.preventDefault();
        let this_tr = $(this).closest('.js_this_tr');
        let orderId = this_tr.data('orderId');
        showModal.attr('data-order-id', orderId);
        let checkBtn = 0;
        if (this_tr.hasClass('js_action_btn_check')) {
            showModal.find('.action-div').removeClass('d-none');
            showModal.find('.js_detail_table_th').removeClass('d-none');
            showModal.find('.js_add_order_detail_btn').removeClass('d-none');
            checkBtn = 1;
        }
        else {
            showModal.find('.action-div').addClass('d-none');
            showModal.find('.js_detail_table_th').addClass('d-none');
            showModal.find('.js_add_order_detail_btn').addClass('d-none');
        }
        showModal.find('.modal-title').html('Show order');

        let detailUrl = $(this).data('detailUrl');
        getOrderDetails(detailUrl, checkBtn);

        let fileUrl = $(this).data('fileUrl');
        getOrderFiles(fileUrl);

        let actionUrl = $(this).data('actionUrl')
        getOrderActions(actionUrl);

        let planUrl = $(this).data('planUrl')
        getOrderPlan(planUrl, showModal);

    });


});

/**** create order detail **/
$('body').delegate('.js_copy_link', 'click', function() {
    let $this = $(this);
    let text = $this.closest('.popover').find('.popover-body').text();
    navigator.clipboard.writeText(text);
    $this.removeClass('fas');
    $this.addClass('far');

    setTimeout(function () {
        $this.removeClass('far');
        $this.addClass('fas');
    }, 1000);
});


$('#order_show_modal button[data-dismiss="modal"]').click(function () {

    window.location.reload();
})

