$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");
    let data_url = TRANSACTION_URL;

    let table = $('#transactions').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        order: [[7, 'desc']],
        //stateSave: true,
        ajax: data_url,
        columns: [
            {data: "actions", searchable: false, orderable: false},
            {data: "trx_id", name: 'id', searchable: true, orderable: false},
            {data: "user", name: 'user.username', searchable: true, orderable: false},
            {data: "purchaser", name: 'purchaser.username', searchable: true, orderable: false},
            {data: "package", searchable: false, orderable: false},
            {data: "type", searchable: false, orderable: false},
            {data: "status", searchable: false, orderable: false},
            {data: "paid_at", name: 'created_at', searchable: false},
            {data: "gas_fee", name: 'gas_fee', searchable: false, orderable: false},
            {data: "trx_amount", name: 'amount', searchable: false, orderable: true},
        ],
        footerCallback: function (row, data, start, end, display) {
            let api = this.api();

            // Remove the formatting to get integer data for summation
            let intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

            let sumVal = function (column, page = 'current') {
                return api
                    .column(column, page)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            }

            let pageTotal = new Intl.NumberFormat().format(sumVal(8));
            $(api.column(9).footer()).html(`Gas Fee Total: USDT ${pageTotal}`);

            let paidTotal8 = new Intl.NumberFormat().format(sumVal(9));
            $(api.column(9).footer()).append(`<br><br>Amount Total: USDT ${paidTotal8}`);
        },
        columnDefs: [
            {
                render: function (data, type, full, meta) {
                    return `<div style="font-size: 0.74rem !important;" > ${data} </div>`;
                },
                targets: [1, 2, 3, 4, 5, 6, 7],
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style="min-width:120px" class="text-right"> ${amount} </div>`;
                },
                targets: [8, 9],
            },
        ],
    });

    flatpickr("#transaction-date-range", {
        mode: "range",
        dateFormat: "Y-m-d H:i",
        defaultDate: date_range && date_range.split("to"),
        enableTime: true,
        time_24hr: true,
    });

    $(document).on("click", "#transaction-search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#transaction-date-range").val());
        urlParams.set("status", $("#transaction-status").val());
        urlParams.set("purchaser_id", $("#purchaser_id").val());
        urlParams.set("user_id", $("#user_id").val());
        urlParams.set("currency-type", $("#currency-type").val());
        urlParams.set("product-type", $("#product-type").val());
        urlParams.set("pay-method", $("#pay-method").val());
        urlParams.set("amount-start", $("#amount-start").val());
        urlParams.set("amount-end", $("#amount-end").val());
        let url = data_url.split(/\?|\#/)[0] + "?" + urlParams.toString();
        HISTORY_STATE && history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

})
