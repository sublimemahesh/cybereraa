$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");
    const date_approve = urlParams.get("date-approve");

    let clipboard = new ClipboardJS('.copy-to-clipboard');

    // Handle copy success
    clipboard.on('success', function (e) {
        Toast.fire({
            icon: 'success', title: 'Address copied to clipboard!',
        })
        e.clearSelection();
    });

    let table = $('#binance-trx').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        // order: [[5, 'desc']],
        //stateSave: true,
        ajax: WITHDRAW_REPORT_URL,
        columns: [
            {data: "actions", searchable: true, orderable: false},
            {data: "user", name: 'user.username', searchable: true, orderable: false},
            {data: "type_n_wallet", name: 'type', searchable: false, orderable: false},
            {data: "status", searchable: false, orderable: false},
            {data: "wallet_address", searchable: false, orderable: false},
            {data: "date", name: 'created_at', searchable: false},
            {data: "processed_date", name: 'processed_at', searchable: false},
            {data: "approved_date", name: 'approved_at', searchable: false},
            {data: "rejected_date", name: 'rejected_at', searchable: false},
            {data: "amount_formatted", name: 'amount', searchable: false, orderable: true},
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
            let numberFormatOptions = {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }
            let amount = new Intl.NumberFormat('en-US', numberFormatOptions).format(sumVal(9));
            $(api.column(9).footer()).html(`USDT ${amount}`);

            let transaction_fee = new Intl.NumberFormat('en-US', numberFormatOptions).format(sumVal(10));
            $(api.column(10).footer()).html(`USDT ${transaction_fee}`);

            let total = new Intl.NumberFormat('en-US', numberFormatOptions).format(sumVal(11));
            $(api.column(11).footer()).html(`USDT ${total}`);
        },
        columnDefs: [
            {
                render: function (date, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;"> ${date} </div>`;
                }, targets: [1, 2, 3, 5, 6, 7, 8],
            },
            {
                render: function (data, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;" class="text-truncate copy-to-clipboard cursor-pointer"  data-clipboard-text="${data}">
                                <i class="fa fa-clone" style="font-size: 17px;"></i>
                                ${data}
                            </div>`;
                }, targets: [4],
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style="min-width:100px" class="text-right"> ${amount} </div>`;
                }, targets: [9, 10, 11],
            },
        ],
    });

    let prevDate = null;
    flatpickr("#binance-trx-date-range", {
        mode: "range",
        dateFormat: "Y-m-d H:i",
        defaultDate: date_range && date_range.split("to"),
        enableTime: true,
        time_24hr: true,
        onClose: function (selectedDates, dateStr, instance) {
            // Check if only one date is selected
            if (selectedDates.length === 1) {
                // Switch to single mode
                instance.set("mode", "single");
                // Deselect the second date in the range
                //instance.clear();
            }
        },
        onOpen: function (selectedDates, dateStr, instance) {
            // Switch back to range mode
            instance.set("mode", "range");
        },
        /*onChange: function (selectedDates, dateStr, instance) {
            if (selectedDates.length === 1) {
                if (prevDate !== null) {
                    instance.setDate(null, false);
                    prevDate = null;
                } else {
                    prevDate = selectedDates;
                }
            }
        }*/
    });

    let prevApproveDate = null;
    flatpickr("#binance-trx-date-approve", {
        mode: "range",
        dateFormat: "Y-m-d H:i",
        defaultDate: date_approve && date_approve.split("to"),
        enableTime: true,
        time_24hr: true,
        onClose: function (selectedDates, dateStr, instance) {
            // Check if only one date is selected
            if (selectedDates.length === 1) {
                // Switch to single mode
                instance.set("mode", "single");
                // Deselect the second date in the range
                //instance.clear();
            }
        },
        onOpen: function (selectedDates, dateStr, instance) {
            // Switch back to range mode
            instance.set("mode", "range");
        },
        /*onChange: function (selectedDates, dateStr, instance) {
            if (selectedDates.length === 1) {
                if (prevApproveDate !== null) {
                    instance.setDate(null, false);
                    prevApproveDate = null;
                } else {
                    prevApproveDate = selectedDates;
                }
            }
        }*/
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
        urlParams.set("date-approve", $("#binance-trx-date-approve").val());
        urlParams.set("status", $("#binance-trx-status").val());
        urlParams.set("user_id", $("#user_id").val());
        urlParams.set("amount-start", $("#amount-start").val());
        urlParams.set("amount-end", $("#amount-end").val());
        let url = WITHDRAW_REPORT_URL.split(/\?|\#/)[0] + "?" + urlParams.toString();
        HISTORY_STATE && history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

})
