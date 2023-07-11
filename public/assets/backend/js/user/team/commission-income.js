$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#team-commisions').DataTable({
        responsive: true,
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        //stateSave: false,
        ajax: location.href,
        order: [[6, 'desc']],
        columns: [
            {data: "user", searchable: false, orderable: false},
            {data: "username", searchable: false, orderable: false},
            {data: "name", searchable: false, orderable: false},
            {data: "sponsor", searchable: false, orderable: false},
            {data: "rank", searchable: false, orderable: false},
            {data: "total_amount_format", name: 'total_amount', searchable: false, orderable: false},
            {data: "total_paid_format", name: 'total_paid', searchable: false, orderable: true},
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
            $(api.column(6).footer()).html(`Current Page Amount Total: USDT ${amountTotal}`);

            let paidTotal8 = new Intl.NumberFormat().format(sumVal(6));
            $(api.column(6).footer()).append(`<br><br>Current Paid Total: USDT ${paidTotal8}`);
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
                    return `<div style="min-width:100px" class="text-right"> ${amount} </div>`;
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
        //urlParams.set("status", $("#status").val());
        urlParams.set("type", $("#type").val());

        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });
})
