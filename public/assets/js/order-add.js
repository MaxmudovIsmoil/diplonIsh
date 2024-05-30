$(document).on('click', '.js_add_tr_btn', function(e) {
    e.preventDefault();

    let tbody = $('.js_tbody');
    let number = tbody.find('tr').length + 1;
    let tr = '<tr>\n' +
                        '<td>' + number + '</td>\n' +
                        '<td><input type="text" name="name[]" class="form-control js_od_name"/></td>\n' +
                        '<td><input type="number" name="count[]" class="form-control js_od_count"/></td>\n' +
                        '<td><input type="text" name="pcs[]" class="form-control js_od_pcs"/></td>\n' +
                        '<td><input type="text" name="price_source[]" class="form-control"/></td>\n' +
                        '<td><input type="text" name="address[]" class="form-control"/></td>\n' +
                    '</tr>'+
                '</tr>';

    tbody.append(tr);
});

$(document).on('click', '.js_remove_tr_btn', function(e) {
    e.preventDefault();

    let tbody = $('.js_tbody');
    let number = tbody.find('tr').length;
    if (number > 1)
        tbody.find('tr').last().remove();

});


// every 10 minutes page refresh
let setTime = setTimeout(function(){
    window.location.reload();
}, 600000);

let modal = $('#order_add_modal');
modal.on('show.bs.modal', function() {
    clearTimeout(setTime);
});
modal.on('hidden.bs.modal', function() {
    setTime = setTimeout(function(){
        window.location.reload();
    }, 600000);
});
