$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#rewards').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        order: [[4, 'desc']],
        //stateSave: true,
        ajax: INCOMES_URL,
        columns: [
            {data: "id", searchable: false, orderable: false},
            {data: "user", name: 'user.username', searchable: true, orderable: false},
            {data: "type", searchable: false, orderable: false},
            /*{data: "next_payment_date", searchable: false, orderable: false},*/
            {data: "status", searchable: false, orderable: false},
            {data: "date", name: 'created_at', searchable: false},
            {data: "package", searchable: false, orderable: false},
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
            let numberFormatOptions = {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }
            let amountTotal = new Intl.NumberFormat('en-US', numberFormatOptions).format(sumVal(6));
            $(api.column(6).footer()).html(`${amountTotal}`);

            let paidTotal8 = new Intl.NumberFormat('en-US', numberFormatOptions).format(sumVal(7));
            $(api.column(7).footer()).html(`${paidTotal8}`);
        },
        columnDefs: [
            {
                render: function (date, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;"> ${date} </div>`;
                },
                targets: [2, 3, 4, 5],
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style="min-width:100px" class="text-right"> ${amount} </div>`;
                },
                targets: [6, 7],
            },
        ],
    });

    flatpickr("#rewards-date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#rewards-search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#rewards-date-range").val());
        urlParams.set("status", $("#rewards-status").val());
        urlParams.set("user_id", $("#user_id").val());
        urlParams.set("type", $("#type").val());
        let url = INCOMES_URL.split(/\?|\#/)[0] + "?" + urlParams.toString();
        HISTORY_STATE && history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

    if (HISTORY_STATE) {
        $(document).on('click', '#calculate-bonus', function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Are You Sure?",
                text: `${$(this).html()} now!`,
                icon: "info",
                showCancelButton: true,
            }).then((calculate) => {
                if (calculate.isConfirmed) {
                    loader()
                    axios.post(APP_URL + "/admin/reports/users/rewards/calculate-bonus").then(response => {
                        Toast.fire({
                            icon: response.data.icon, title: response.data.message,
                        })
                        let url = location.href.split(/\?|\#/)[0];
                        history.replaceState({}, "", url);
                        table.ajax.url(url).load();
                    }).catch(error => {
                        console.log(error)
                        Toast.fire({
                            icon: 'error', title: error.response.data.message || "Something went wrong!",
                        })
                    })
                }
            });
        })
    }

})
