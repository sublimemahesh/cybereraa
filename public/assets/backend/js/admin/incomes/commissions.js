$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#rewards').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        order: [[5, 'desc']],
        //stateSave: true,
        ajax: INCOMES_URL,
        columns: [
            {data: "user_id", searchable: false},
            {data: "username", name: 'user.username', searchable: true},
            {data: "type", searchable: false},
            {data: "next_payment_date", searchable: false},
            {data: "status", searchable: false},
            {data: "created_at", searchable: false},
            {data: "package", searchable: false},
            {data: "amount", name: 'amount', searchable: false},
            {data: "paid", name: 'paid', searchable: false},
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

            let amountTotal = new Intl.NumberFormat().format(sumVal(7));
            $(api.column(7).footer()).html(`Current Page Amount Total: USDT ${amountTotal}`);

            let paidTotal8 = new Intl.NumberFormat().format(sumVal(8));
            $(api.column(7).footer()).append(`<br><br>Current Paid Total: USDT ${paidTotal8}`);
        },
        columnDefs: [
            {
                render: function (date, type, full, meta) {
                    return `<div style='font-size: 0.76rem !important;'> ${date} </div>`;
                },
                targets: [3, 5],
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style='min-width:100px' class="text-right"> ${amount} </div>`;
                },
                targets: [7, 8],
            },
        ],
    });

    flatpickr("#rewards-date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#rewards-search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#rewards-date-range").val());
        urlParams.set("status", $("#rewards-status").val());
        urlParams.set("user_id", $("#user_id").val());
        urlParams.set("type", $("#type").val());
        let url = INCOMES_URL.split(/\?|\#/)[0] + "?" + urlParams.toString();
        HISTORY_STATE && history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

})