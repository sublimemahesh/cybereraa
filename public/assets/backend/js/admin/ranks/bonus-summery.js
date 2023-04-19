$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#rewards-summery').DataTable({
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
            {data: "period", name: 'start_date', searchable: false},
            {data: "eligible_rankers_str", searchable: false, orderable: false},
            {data: "total_rank_bonus_percentage", searchable: false, orderable: false},
            {data: "date", name: 'created_at', searchable: false},
            {data: "monthly_total_sale", searchable: false, orderable: false},
            {data: "total_bonus_amount", searchable: false, orderable: false},
            {data: "one_rank_bonus_amount", searchable: false, orderable: false},
            {data: "remaining_bonus_amount", searchable: false, orderable: false},
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
            const monthly_total_sale = 4;
            const total_bonus_amount = 5;
            const one_rank_bonus_amount = 6;
            const remaining_bonus_amount = 7;

            let amountTotal = new Intl.NumberFormat().format(sumVal(monthly_total_sale));
            $(api.column(monthly_total_sale).footer()).html(`Monthly Total Sale: USDT ${amountTotal}`);

            let total_bonus_amount_sum = new Intl.NumberFormat().format(sumVal(total_bonus_amount));
            $(api.column(monthly_total_sale).footer()).append(`<br/><br/>Total Allocated: USDT ${total_bonus_amount_sum}`);

            let one_rank_bonus_amount_sum = new Intl.NumberFormat().format(sumVal(one_rank_bonus_amount));
            $(api.column(monthly_total_sale).footer()).append(`<br/><br/>Total Allocated For One Rank: USDT ${one_rank_bonus_amount_sum}`);

            let remaining_bonus_amount_sum = new Intl.NumberFormat().format(sumVal(remaining_bonus_amount));
            $(api.column(monthly_total_sale).footer()).append(`<br/><br/>Remaining Total: USDT ${remaining_bonus_amount_sum}`);
        },
        columnDefs: [
            {
                render: function (date, type, full, meta) {
                    return `<div class="text-center" style='font-size: 0.76rem !important;'> ${date} </div>`;
                },
                targets: [0, 1, 2, 3],
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style='min-width:100px' class="text-right"> ${amount} </div>`;
                },
                targets: [4, 5, 6, 7],
            },
        ],
    });

})
