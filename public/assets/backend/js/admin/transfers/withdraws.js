$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#binance-trx').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        order: [[4, 'desc']],
        //stateSave: true,
        ajax: WITHDRAW_REPORT_URL,
        columns: [
            {data: "actions", searchable: true, orderable: false},
            {data: "user", name: 'user.username', searchable: true, orderable: false},
            {data: "type_n_wallet", name: 'type', searchable: false, orderable: false},
            {data: "status", searchable: false, orderable: false},
            {data: "date", name: 'created_at', searchable: false},
            {data: "amount", name: 'amount', searchable: false, orderable: false},
            {data: "transaction_fee", name: 'transaction_fee', searchable: false, orderable: false},
            {data: "total", searchable: false, orderable: false}
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

            let amount = new Intl.NumberFormat().format(sumVal(5));
            $(api.column(7).footer()).html(`Current page total amount: USDT ${amount}`);

            let transaction_fee = new Intl.NumberFormat().format(sumVal(6));
            $(api.column(7).footer()).append(`<br><br>Current Page Trx fees: USDT ${transaction_fee}`);

            let total = new Intl.NumberFormat().format(sumVal(7));
            $(api.column(7).footer()).append(`<br><br>Current Page Total: USDT ${total}`);
        },
        columnDefs: [{
            render: function (date, type, full, meta) {
                return `<div style='font-size: 0.76rem !important;'> ${date} </div>`;
            }, targets: 4,
        }, {
            render: function (amount, type, full, meta) {
                return `<div style='min-width:100px' class="text-right"> ${amount} </div>`;
            }, targets: [5, 6, 7],
        },],
    });

    flatpickr("#binance-trx-date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", ".process-withdraw", function (e) {
        e.preventDefault();
        Swal.fire({
            title: "Are You Sure?",
            text: "Process This payout?. Please note this process cannot be reversed.",
            icon: "info",
            showCancelButton: true,
        }).then((process) => {
            if (process.isConfirmed) {
                loader()
                let withdraw = $(this).data('id')
                // formData.append(proof_document, proof_document)
                axios.post(`${APP_URL}/admin/reports/users/transfers/withdrawals/${withdraw}/process`)
                    .then(response => {
                        Toast.fire({
                            icon: response.data.icon, title: response.data.message,
                        }).then(res => {
                            table.draw();
                        })
                    })
                    .catch((error) => {
                        Toast.fire({
                            icon: 'error', title: error.response.data.message || "Something went wrong!",
                        })
                    })
            }
        });
    });

    $(document).on("click", "#binance-trx-search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#binance-trx-date-range").val());
        urlParams.set("status", $("#binance-trx-status").val());
        urlParams.set("user_id", $("#user_id").val());
        let url = WITHDRAW_REPORT_URL.split(/\?|\#/)[0] + "?" + urlParams.toString();
        HISTORY_STATE && history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

})
