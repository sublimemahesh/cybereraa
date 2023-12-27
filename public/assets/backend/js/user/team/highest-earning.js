$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#earnings').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        //stateSave: true,
        ajax: location.href,
        // scrollY: 200,
        // deferRender: true,
        // scroller: true,
        order: [[3, 'desc']],
        columns: [
            // {data: "user", searchable: false, orderable: false},
            {data: "username", name: 'user.username', searchable: true, orderable: false},
            {data: "email", searchable: false, orderable: false},
            {data: "sponsor", searchable: false, orderable: false},
            //{data: "earnable_type", searchable: false, orderable: false},
            //{data: "package", searchable: false, orderable: false},
            // {data: "status", searchable: false, orderable: false},
            //{data: "date", name: "created_at", searchable: false, orderable: false},
            {data: "amount", name: 'earnings', searchable: false, orderable: true},
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

            let total = new Intl.NumberFormat().format(sumVal(3));
            $(api.column(3).footer()).html(`${total}`);
        },
        columnDefs: [
            {
                render: function (date, type, full, meta) {
                    return `<div style="font-size: 0.9rem !important;"> ${date} </div>`;
                }, targets: [0, 1, 2],
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style="font-size: 0.9rem !important" class="text-right"> ${amount} </div>`;
                }, targets: [3],
            }
        ]
    });

    flatpickr("#date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#search", function (e) {
        e.preventDefault();

        urlParams.set("date-range", $("#date-range").val());
        // urlParams.set("status", $("#status").val());
        urlParams.set("earning-type", $("#earning-type").val());

        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });
})
