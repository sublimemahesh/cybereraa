$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#wallet-trx').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        order: [[4, 'desc']],
        //stateSave: true,
        ajax: location.href,
        columns: [
            {data: "user", name: 'user.username', searchable: true, orderable: false},
            {data: "from", name: 'from', searchable: false, orderable: false},
            {data: "to", name: 'to', searchable: false, orderable: false},
            {data: "remark", name: 'remark', searchable: false, orderable: false},
            {data: "date", name: 'created_at', searchable: false, orderable: true},
            {data: "amount", name: 'amount', searchable: false, orderable: false},
            {data: "fee", name: 'fee', searchable: false, orderable: false},
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

            let amount = new Intl.NumberFormat().format(sumVal(5));
            $(api.column(6).footer()).html(`Current page total amount: USDT ${amount}`);

            let transaction_fee = new Intl.NumberFormat().format(sumVal(6));
            $(api.column(6).footer()).append(`<br><br>Current Page Trx fees: USDT ${transaction_fee}`);

        },
        columnDefs: [{
            render: function (date, type, full, meta) {
                return `<div style='font-size: 0.76rem !important;'> ${date} </div>`;
            }, targets: 4,
        }, {
            render: function (amount, type, full, meta) {
                return `<div style='min-width:100px' class="text-right"> ${amount} </div>`;
            }, targets: [5, 6],
        },],
    });

    flatpickr("#wallet-trx-date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });


    $(document).on("click", "#wallet-trx-search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#wallet-trx-date-range").val());
        urlParams.set("user_id", $("#user_id").val());
        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

})
