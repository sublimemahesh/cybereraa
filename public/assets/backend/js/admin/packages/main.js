$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#transactions').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        order: [[6, 'desc']],
        //stateSave: true,
        ajax: location.href,
        columns: [
            {data: "trx_id", name: 'transaction_id', searchable: true, orderable: false},
            {data: "user", name: 'user.username', orderable: false},
            {data: "status", searchable: false, orderable: false},
            {data: "last_earned", name: 'last_earned_at', searchable: false, orderable: false},
            {data: "commission_issued", name: 'commission_issued_at', searchable: false, orderable: true},
            {data: "expired", name: 'expired_at', searchable: false, orderable: false},
            {data: "created", name: 'created_at', searchable: false, orderable: true},
            {data: "invested", name: 'invested_amount', searchable: false, orderable: true},
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
            $(api.column(7).footer()).html(`Total: USDT ${pageTotal}`);

        },
        columnDefs: [
            {
                render: function (data, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;" > ${data} </div>`;
                },
                targets: [0, 1, 3, 4, 5, 6],
            },
            {
                render: function (data, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;" class="text-center"> ${data} </div>`;
                },
                targets: [2],
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style="min-width:120px" class="text-right"> ${amount} </div>`;
                },
                targets: [7],
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
        urlParams.set("user_id", $("#user_id").val());
        urlParams.set("purchaser_id", $("#purchaser_id").val());
        urlParams.set("amount-start", $("#amount-start").val());
        urlParams.set("amount-end", $("#amount-end").val());
        urlParams.set("commission-issued", $("#commission-issued").val());
        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

})
