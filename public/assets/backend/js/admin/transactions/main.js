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
        order: [[6, 'desc']],
        //stateSave: true,
        ajax: data_url,
        columns: [
            {data: "user_id", searchable: false},
            {data: "username", name: 'user.username'},
            {data: "trx_id", name: 'id', searchable: true},
            {data: "package", searchable: false},
            {data: "type", searchable: false},
            {data: "status", searchable: false},
            {data: "paid_at", name: 'created_at', searchable: true},
            {data: "gas_fee", name: 'gas_fee', searchable: false},
            {data: "trx_amount", name: 'amount', searchable: false},
        ],
        footerCallback: function (row, data, start, end, display) {
            let api = this.api();

            // Remove the formatting to get integer data for summation
            let intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

            // Total over this page
            let pageTotal = api
                .column(7, {page: 'current'})
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);

            // Update footer


            let sumVal = function (column, page = 'current') {
                return api
                    .column(column, page)
                    .data()
                    .reduce(function (a, b) {
                        return intVal(a) + intVal(b);
                    }, 0);
            }

            pageTotal = new Intl.NumberFormat().format(pageTotal);
            $(api.column(7).footer()).html(`Gas Fee Total: USDT ${pageTotal}`);

            let paidTotal8 = new Intl.NumberFormat().format(sumVal(8));
            $(api.column(7).footer()).append(`<br><br>Amount Total: USDT ${paidTotal8}`);
        },
        columnDefs: [
            {
                render: function (data, type, full, meta) {
                    return `<div style='min-width:180px' > ${data} </div>`;
                },
                targets: 6,
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style='min-width:120px' class="text-right"> ${amount} </div>`;
                },
                targets: [7, 8],
            },
        ],
    });

    flatpickr("#transaction-date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#transaction-search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#transaction-date-range").val());
        urlParams.set("status", $("#transaction-status").val());
        urlParams.set("user_id", $("#user_id").val());
        urlParams.set("currency-type", $("#currency-type").val());
        let url = data_url.split(/\?|\#/)[0] + "?" + urlParams.toString();
        HISTORY_STATE && history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

})