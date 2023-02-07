$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#p2p-trx').DataTable({
        language: {
            paginate: {
                next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
            }
        },
        lengthMenu: [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "All"],],
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        order: [[4, 'desc']],
        stateSave: true,
        ajax: P2P_URL,
        columns: [
            {data: "sender", name: 'user.username', searchable: true},
            {data: "receiver", name: 'receiver.username', searchable: true},
            {data: "type", searchable: false},
            {data: "status", searchable: false},
            {data: "created_at", searchable: false},
            {data: "remark", searchable: false},
            {data: "amount", name: 'amount', searchable: false},
            {data: "transaction_fee", name: 'transaction_fee', searchable: false},
            {data: "total", searchable: false}
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

            let amount = new Intl.NumberFormat().format(sumVal(6));
            $(api.column(8).footer()).html(`Current page total amount: USDT ${amount}`);

            let transaction_fee = new Intl.NumberFormat().format(sumVal(7));
            $(api.column(8).footer()).append(`<br><br>Current Page Trx fees: USDT ${transaction_fee}`);

            let total = new Intl.NumberFormat().format(sumVal(8));
            $(api.column(8).footer()).append(`<br><br>Current Page Total: USDT ${total}`);
        },
        columnDefs: [{
            render: function (date, type, full, meta) {
                return `<div style='font-size: 0.76rem !important;'> ${date} </div>`;
            }, targets: 4,
        }, {
            render: function (amount, type, full, meta) {
                return `<div style='min-width:100px' class="text-right"> ${amount} </div>`;
            }, targets: [6, 7, 8],
        },],
    });

    flatpickr("#p2p-trx-date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#p2p-trx-search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#p2p-trx-date-range").val());
        urlParams.set("status", $("#p2p-trx-status").val());
        urlParams.set("user_id", $("#user_id").val());
        urlParams.set("receiver_id", $("#p2p-trx-receiver_id").val());
        let url = P2P_URL.split(/\?|\#/)[0] + "?" + urlParams.toString();
        HISTORY_STATE && history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

})
