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
        order: [[4, 'desc']],
        columns: [
            {data: "type", searchable: false, orderable: false},
            {data: "status", name: 'status', searchable: false, orderable: false},
            {data: "package", searchable: false, orderable: false},
            {data: "referer", searchable: true, name: 'purchasedPackage.user.username', orderable: false},
            {data: "created_date", name: 'created_at', searchable: false},
            // {data: "next_payment_date", searchable: false, orderable: false},
            {data: "amount", name: 'amount', searchable: false, orderable: false},
            {data: "paid", name: 'paid', searchable: false, orderable: false},
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

            let amountTotal = new Intl.NumberFormat().format(sumVal(5));
            $(api.column(5).footer()).html(`${amountTotal}`);

            let paidTotal8 = new Intl.NumberFormat().format(sumVal(6));
            $(api.column(6).footer()).append(`${paidTotal8}`);
        },
        columnDefs: [
            {
                render: function (date, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;"> ${date} </div>`;
                },
                targets: [0, 1, 2, 3, 4],
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;" class="text-right"> ${amount} </div>`;
                },
                targets: [5, 6],
            },
        ],
    })

    flatpickr("#date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#search", function (e) {
        e.preventDefault();

        urlParams.set("date-range", $("#date-range").val());
        urlParams.set("status", $("#status").val());
        urlParams.set("type", $("#type").val());

        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });
})
