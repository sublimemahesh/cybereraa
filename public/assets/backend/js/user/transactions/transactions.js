$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#transactions').DataTable({
        responsive: true,
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        //stateSave: false,
        ajax: location.href,
        order: [[1, 'desc']],
        columns: [
            {data: "action", sortable: false, searchable: false, orderable: false},
            {data: "trx_id", name: 'id', searchable: true, orderable: false},
            {data: "package", searchable: false, orderable: false},
            {data: "type", searchable: false, orderable: false},
            {data: "status", searchable: false, orderable: false},
            {data: "paid_at", searchable: false, orderable: false},
            {data: "trx_amount", name: 'amount', searchable: true, orderable: false},
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
            let total = new Intl.NumberFormat().format(sumVal(6));
            $(api.column(6).footer()).html(`<br><br>Current Page Total: USDT ${total}`);
        },
        columnDefs: [
            {
                render: function (date, type, full, meta) {
                    return `<div style='font-size: 0.76rem !important;'> ${date} </div>`;
                }, targets: 5,
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style='min-width:100px' class="text-right"> ${amount} </div>`;
                }, targets: [6],
            }
        ]
    })

    flatpickr("#date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#search", function (e) {
        e.preventDefault();

        urlParams.set("date-range", $("#date-range").val());
        urlParams.set("status", $("#status").val());
        urlParams.set("currency-type", $("#currency-type").val());

        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });
})
