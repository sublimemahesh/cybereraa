$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#transactions').DataTable({
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
        order: [[6, 'desc']],
        stateSave: true,
        ajax: location.href,
        columns: [
            {data: "user_id", searchable: false},
            {data: "username", name: 'user.username'},
            {data: "trx_id", name: 'id', searchable: true},
            {data: "package", searchable: false},
            {data: "type", searchable: false},
            {data: "status", searchable: false},
            {data: "paid_at", searchable: false},
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

            pageTotal = new Intl.NumberFormat().format(pageTotal);
            $(api.column(7).footer()).html(`Page Total: USDT ${pageTotal}`);
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
                targets: 7,
            },
        ],
    });

    flatpickr("#date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#date-range").val());
        urlParams.set("status", $("#status").val());
        urlParams.set("user_id", $("#user_id").val());
        urlParams.set("currency-type", $("#currency-type").val());
        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

})