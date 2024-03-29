$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#topup-history').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        order: [[5, 'desc']],
        //stateSave: true,
        ajax: TOPUP_HISTORY_URL,
        columns: [
            {data: "actions", searchable: false, orderable: false},
            {data: "sender", name: 'user.username', searchable: true, orderable: false},
            {data: "receiver", name: 'receiver.username', searchable: true, orderable: false},
            // {data: "proof", searchable: false, orderable: false},
            {data: "remark", searchable: false, orderable: false},
            {data: "status", searchable: false, orderable: false},
            {data: "created", name: 'created_at', searchable: false},
            {data: "amount", name: 'amount', searchable: false, orderable: false},
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
            $(api.column(6).footer()).html(`Current page total amount: USDT ${amount}`);

        },
        columnDefs: [{
            render: function (date, type, full, meta) {
                return `<div style="font-size: 0.76rem !important;"> ${date} </div>`;
            }, targets: [1, 2, 3, 4, 5],
        }, {
            render: function (amount, type, full, meta) {
                return `<div style="min-width:100px" class="text-right"> ${amount} </div>`;
            }, targets: [6],
        },],
    });

    flatpickr("#topup-history-date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#topup-history-search", function (e) {
        e.preventDefault();
        urlParams.set("sender_id", $("#sender_id").val());
        urlParams.set("user_id", $("#user_id").val());
        urlParams.set("status", $("#status").val());
        urlParams.set("date-range", $("#topup-history-date-range").val());
        let url = TOPUP_HISTORY_URL.split(/\?|\#/)[0] + "?" + urlParams.toString();
        HISTORY_STATE && history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

})
