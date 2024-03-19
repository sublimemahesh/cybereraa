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

    const SELECT_ALL_PENDING_BTN = 0;
    const SELECT_ALL_PROCESSING_BTN = 1;
    const SELECT_NONE_BTN = 2;
    const PROCESS_SELECTED_BTN = 3;
    const APPROVE_SELECTED_BTN = 4;
    const REJECT_SELECTED_BTN = 5;
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
            {data: null, defaultContent: '', searchable: false, orderable: false},
            {data: "actions", searchable: true, orderable: false},
            {data: "user", name: 'user.username', searchable: true, orderable: false},
            {data: "type_n_wallet", name: 'type', searchable: false, orderable: false},
            {data: "status_formatted", name: 'status', searchable: false, orderable: false},
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
            let amount = new Intl.NumberFormat('en-US', numberFormatOptions).format(sumVal(10));
            $(api.column(10).footer()).html(`${amount}`);

            let transaction_fee = new Intl.NumberFormat('en-US', numberFormatOptions).format(sumVal(11));
            $(api.column(11).footer()).html(`${transaction_fee}`);

            let total = new Intl.NumberFormat('en-US', numberFormatOptions).format(sumVal(12));
            $(api.column(12).footer()).html(`${total}`);
        }, select: {
            style: 'multi',// api,single
            selector: 'td:first-child',
            headerCheckbox: false
        },
        buttons: [
            {
                text: 'Select All PENDING',
                action: function (e, dt, node, config) {
                    dt.rows().deselect();
                    // dt.rows().select();
                    let rows = dt.rows((idx, data) => {
                        // console.log(data, data.status)
                        return data.status === 'PENDING'
                    });
                    // console.log(rows)
                    rows.select()
                    // table.button(3).enable(rows[0].length > 0);
                    // table.button(4).disable();
                    // table.button(5).disable();
                }
            },
            {
                text: 'Select All PROCESSING',
                action: function (e, dt, node, config) {
                    dt.rows().deselect();
                    // dt.rows().select();
                    let rows = dt.rows((idx, data) => data.status === 'PROCESSING');
                    rows.select()
                    // console.log(rows)
                    // table.button(3).disable();
                    // table.button(4).enable(rows[0].length > 0);
                    // table.button(5).enable(rows[0].length > 0);
                }
            },
            {
                text: 'Select none',
                action: function (e, dt, node, config) {
                    dt.rows().deselect();
                    dt.button(PROCESS_SELECTED_BTN).enable(false);
                    dt.button(APPROVE_SELECTED_BTN).enable(false);
                    dt.button(REJECT_SELECTED_BTN).enable(false);
                }
            },
            {
                text: 'Process Selected',
                action: function (e, dt, node, config) {
                    let count = table.rows({selected: true}).count();
                    let selectedRaws = dt.rows({selected: true}).data();
                    let data = [];
                    selectedRaws.map(record => {
                        data.push(record.id);
                    })
                    // console.log(data)
                    bulkWithdrawalAction('process', data)
                },
                enabled: false
            },
            {
                text: 'Approve Selected',
                action: function (e, dt, node, config) {
                    let selectedRaws = dt.rows({selected: true}).data();
                    let data = [];
                    selectedRaws.map(record => {
                        data.push(record.id);
                    })
                    // console.log(data)
                    bulkWithdrawalAction('approve', data)
                },
                enabled: false
            },
            {
                text: 'Reject Selected',
                // className: 'd-none', // TODO: ADD REJECT REASON SELECTION AND REMOVE THIS CLASS
                action: function (e, dt, node, config) {
                    let selectedRaws = dt.rows({selected: true}).data();
                    let data = [];
                    selectedRaws.map(record => {
                        data.push(record.id);
                    })
                    // console.log(data)
                    bulkWithdrawalAction('reject', data)
                },
                enabled: false
            },
            {
                extend: 'pdfHtml5',
                footer: true, // TODO: Remove all the colspan="" in the table footer and add footer columns to the table ex: if colspan=2 add <th></th> <th></th>
                //split: ['csv', 'excel'],
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    stripNewlines: false,
                    columns: [":visible"],
                },
            },
            {
                extend: 'excelHtml5',
                footer: true,
                //split: ['csv', 'excel'],
                orientation: 'landscape',
                pageSize: 'LEGAL',
                exportOptions: {
                    columns: [":visible"],
                    stripNewlines: false,
                },
            },
            "colvis",
            "pageLength",
        ],
        columnDefs: [
            {
                orderable: false,
                className: 'select-checkbox',
                // render: DataTable.render.select(),
                targets: 0
            },
            {
                render: function (date, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;"> ${date} </div>`;
                }, targets: [2, 3, 4, 6, 7, 8, 9],
            },
            {
                render: function (data, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;" class="text-truncate copy-to-clipboard cursor-pointer"  data-clipboard-text="${data}">
                                <i class="fa fa-clone" style="font-size: 17px;"></i>
                                ${data}
                            </div>`;
                }, targets: [5],
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style="min-width:100px" class="text-right"> ${amount} </div>`;
                }, targets: [10, 11, 12],
            },
        ],
    });
    table.on('select deselect', function () {
        let selectedRows = table.rows({selected: true}).count();
        let selectedPendingRows = table.rows((idx, data) => data.status === 'PENDING', {selected: true});
        let selectedProcessingRows = table.rows((idx, data) => data.status === 'PROCESSING', {selected: true});
        let selectedOtherRows = table.rows((idx, data) => (data.status !== 'PENDING' && data.status !== 'PROCESSING'), {selected: true});

        console.log(selectedPendingRows.count(), selectedProcessingRows.count(), selectedOtherRows.count())

        if (selectedOtherRows.count() > 0 || selectedRows <= 0) {
            table.button(PROCESS_SELECTED_BTN).disable();
            table.button(APPROVE_SELECTED_BTN).disable();
            table.button(REJECT_SELECTED_BTN).disable();
            return;
        }

        if (selectedPendingRows.count() > 0 && selectedProcessingRows.count() > 0) {
            table.button(PROCESS_SELECTED_BTN).disable();
            table.button(APPROVE_SELECTED_BTN).disable();
            table.button(REJECT_SELECTED_BTN).enable();
            return;
        }

        if (selectedPendingRows.count() > 0) {
            table.button(PROCESS_SELECTED_BTN).enable();
            table.button(APPROVE_SELECTED_BTN).disable();
            table.button(REJECT_SELECTED_BTN).enable();
        }

        if (selectedProcessingRows.count() > 0) {
            table.button(PROCESS_SELECTED_BTN).disable();
            table.button(APPROVE_SELECTED_BTN).enable();
            table.button(REJECT_SELECTED_BTN).enable();
        }
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

    async function bulkWithdrawalAction(action, withdrawalRequests) {
        let html = '';
        if (action === 'reject') {
            const {value: repudiate_note} = await Swal.fire({
                title: "Reject Withdrawal Requests",
                input: "select",
                html: `<div><p>Reject Reason will apply to all selected withdrawals</p></div>`,
                inputOptions: REJECT_REASONS,
                inputPlaceholder: "Select a reject reason",
                showCancelButton: true,
                inputValidator: (value) => {
                    return new Promise((resolve) => {
                        if (value === null || value.length <= 0) {
                            resolve("Please provide the reject reason!");
                        }
                        resolve();
                    });
                }
            });
            if (typeof repudiate_note == 'undefined') {
                return false
            }


            if (repudiate_note === null) {
                await Toast.fire({
                    icon: 'error',
                    title: "Please provide the reject reason!",
                });
                return false
            }
            html = `<div class="swal2-html-container mt-0 mb-2">
                                Reject The payout?. Please note this process cannot be reversed.
                                </div>
                                <span class="text-danger">Reason: ${repudiate_note}</span>`
        }
        Swal.fire({
            title: "Are You Sure?",
            text: `${action.toUpperCase()} This payout?. Please note this process cannot be reversed.`,
            html: html,
            icon: "info",
            showCancelButton: true,
        }).then((process) => {
            if (process.isConfirmed) {
                loader()
                axios
                    .post(`${APP_URL}/admin/reports/users/transfers/bulk/withdrawals/${action}`, {
                        ids: withdrawalRequests
                    })
                    .then(response => {
                        Toast.fire({
                            icon: response.data.icon, title: response.data.message,
                        })
                        table.draw();
                    })
                    .catch((error) => {
                        console.log(error)
                        Toast.fire({
                            icon: 'error', title: error.response.data.message || "Something went wrong!",
                        })
                    })
            }
        });
    }
})
