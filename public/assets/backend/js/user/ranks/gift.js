$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#rewards').DataTable({
        lengthMenu: [[-1], ["7 rows"]],
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        order: [[3, 'desc']],
        //stateSave: true,
        ajax: location.href,
        columns: [
            {data: "image", searchable: false, orderable: false},
            {data: "rank", searchable: false, orderable: false},
            {data: "status", searchable: false, orderable: false},
            {data: "created_at", searchable: false},
            {data: "gift_requirement", searchable: false, orderable: false},
            {data: "total_investment", searchable: false, orderable: false},
            {data: "total_team_investment", searchable: false, orderable: false},
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

            let total_investment = new Intl.NumberFormat().format(sumVal(5));
            $(api.column(6).footer()).html(`Current Page Total investment: USDT ${total_investment}`);

            let total_team_investment = new Intl.NumberFormat().format(sumVal(6));
            $(api.column(6).footer()).append(`<br><br>Current Page Total Team investment: USDT ${total_team_investment}`);
        },
        columnDefs: [
            {
                render: function (date, type, full, meta) {
                    return `<div style='font-size: 0.76rem !important;'> ${date} </div>`;
                },
                targets: [3],
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style='min-width:100px' class="text-right"> ${amount} </div>`;
                },
                targets: [5, 6],
            },
            {
                render: function (data, type, full, meta) {
                    return `<div style='min-width:100px' class="text-left"> ${data} </div>`;
                },
                targets: [1],
            },
        ],
    });

})