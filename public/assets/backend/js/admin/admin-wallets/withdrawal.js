$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#withdrawal').DataTable({
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
            {data: "type", searchable: false, orderable: false},
            {data: "remark", searchable: false, orderable: false},
            {data: "proof", searchable: false, orderable: false},
            {data: "date", name: 'created_at', searchable: false},
            {data: "amount", name: 'amount', orderable: false},
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

            // Update footer
            let pageTotal = new Intl.NumberFormat().format(sumVal(5));
            $(api.column(5).footer()).html(`Page Total: USDT ${pageTotal}`);
        },
        columnDefs: [
            {
                render: function (data, type, full, meta) {
                    return `<div style='font-size: 0.76rem !important;'> ${data !== null ? data : '-'} </div>`;
                }, targets: [0, 1, 2, 3, 4],
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style='min-width:120px' class="text-right"> ${amount} </div>`;
                },
                targets: [5],
            },
        ],
    });

    flatpickr("#date-range", {
        mode: "range",
        dateFormat: "Y-m-d H:i",
        defaultDate: date_range && date_range.split("to"),
        enableTime: true,
        time_24hr: true,
    });

    $(document).on("click", "#search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#date-range").val());
        urlParams.set("user_id", $("#user_id").val());
        urlParams.set("type", $("#type").val());
        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

})
