$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#special_bonuses').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        order: [[5, 'desc']],
        stateSave: true,
        ajax: location.href,
        columns: [
            {data: "actions", searchable: true, orderable: false},
            {data: "user", name: 'user.username', searchable: true, orderable: false},
            {data: "bonus", searchable: false, orderable: false},
            {data: "bonus_date", searchable: false, orderable: false},
            {data: "status", searchable: false, orderable: false},
            {data: "created_at_format", searchable: false, name: 'created_at', orderable: false},
            {data: "requirement", searchable: false, orderable: false},
            {data: "eligibility", searchable: false, orderable: false},
            {data: "amount", searchable: false, orderable: false},
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
            let numberFormatOptions = {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }
            let total_amount = new Intl.NumberFormat('en-US', numberFormatOptions).format(sumVal(8));
            $(api.column(8).footer()).html(`${total_amount}`);

        },
        columnDefs: [
            {
                render: function (date, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;"> ${date} </div>`;
                },
                targets: [0, 1, 2, 3, 4, 5, 6, 7],
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style="min-width:100px" class="text-right"> ${amount} </div>`;
                },
                targets: [8],
            },
        ],
    });

    flatpickr("#date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });


    $(document).on("click", "#search", function (e) {
        e.preventDefault();
        urlParams.set("user_id", $("#user_id").val());
        urlParams.set("bonus-type", $("#bonus_type").val());
        urlParams.set("date-range", $("#date-range").val());
        urlParams.set("status", $("#status").val());
        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

})
