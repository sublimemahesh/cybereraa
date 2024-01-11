$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");
    let data_url = TRANSACTION_URL;

    let table = $('#transactions').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        // order: [[7, 'desc']],
        //stateSave: true,
        ajax: data_url,
        columns: [
            {data: "actions", searchable: false, orderable: false},
            {data: "trx_id", name: 'id', searchable: true, orderable: false},
            {data: "user", name: 'user.username', searchable: true, orderable: false},
            {data: "purchaser", name: 'purchaser.username', searchable: true, orderable: false},
            {data: "package", searchable: false, orderable: false},
            {data: "type", searchable: false, orderable: false},
            {data: "status", searchable: false, orderable: false},
            {data: "paid_at", name: 'created_at', searchable: false},
            {data: "gas_fee", name: 'gas_fee', searchable: false, orderable: false},
            {data: "trx_amount", name: 'amount', searchable: false, orderable: true},
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

            let pageTotal = new Intl.NumberFormat().format(sumVal(8));
            $(api.column(8).footer()).html(`${pageTotal}`);

            let paidTotal8 = new Intl.NumberFormat().format(sumVal(9));
            $(api.column(9).footer()).html(`${paidTotal8}`);
        },
        columnDefs: [
            {
                render: function (data, type, full, meta) {
                    return `<div style="font-size: 0.74rem !important;" > ${data} </div>`;
                },
                targets: [1, 2, 3, 4, 5, 6, 7],
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style="min-width:120px" class="text-right"> ${amount} </div>`;
                },
                targets: [8, 9],
            },
        ],
    });


    const approveModal = new bootstrap.Modal('#approveModal', {
        backdrop: 'static',
    })

    window.TRANSACTION_TABLE = table;
    window.TRANSACTION_MODAL = approveModal;


// Handle click event for the action button
    $('#transactions').on('click', '.btn-review-actions', function (e) {
        e.preventDefault();
        loader();
        // Get the URL from the data-url attribute
        let url = $(this).data('url');

        // Load content from the specified route
        $.get(url, function (data) {
            // console.log(data)
            // Create a modal with the loaded content
            $('#modalContent').html(data.html);
            window.transaction_review_actions_url = url;
            window.transaction_approve_url = data.approve_url;
            window.transaction_reject_url = data.reject_url;
            approveModal.show();
            Swal.close()
        });
    });

    $(document).on('click', '#edit-transaction-amount', function (e) {
        e.preventDefault();
        $('#actions-container').empty()
        const total_amount_el = $('#transaction-total-amount');
        const transaction_amount = total_amount_el.data('transaction-amount');

        total_amount_el.empty()
        total_amount_el.html(`
                    <div class="alert alert-info">Please note: Gas Fee will be also changed according to current percentage.</div>
                    <label for="transaction-amount">Amount</label>
                    <input id="transaction-amount" value="${transaction_amount}" type="number" name="amount" data-input="payout" class="form-control" autocomplete="transaction-amount">
                    <div class="d-flex justify-content-evenly mt-2" id="edit-transaction-amount-actions-container">
                        <button type="button" id="change-transaction-amount" class="btn btn-sm btn-success">Confirm</button>
                        <button type="button" id="cancel-edit-transaction" class="btn btn-sm btn-danger">Cancel</button>
                    </div>`)
    });

    $(document).on("click", "#change-transaction-amount", function (e) {
        e.preventDefault()
        const total_amount_el = $('#transaction-total-amount');
        const transaction_edit_url = total_amount_el.data('edit-url');
        let new_transaction_amount = $('#transaction-amount').val()
        Swal.fire({
            title: "Are You Sure?",
            text: "Edit The transaction?. Gas Will not be change according to the entered amount",
            footer: 'New Amount: <small style="color:green"> USDT ' + new_transaction_amount + '</small>',
            icon: "info",
            showCancelButton: true,
        }).then((approve) => {
            if (approve.isConfirmed) {
                loader()
                axios.post(transaction_edit_url, {amount: new_transaction_amount})
                    .then(response => {
                        if (response.data.status) {
                            TRANSACTION_TABLE.ajax.reload();
                            loadReviewAction(transaction_review_actions_url);
                        }
                        Toast.fire({
                            icon: response.data.icon, title: response.data.message,
                        }).then(res => {
                        })
                    })
                    .catch((error) => {
                        Toast.fire({
                            icon: 'error', title: error.response.data.message || "Something went wrong!",
                        })
                        console.error(error.response.data)
                        let errorMap = [];
                        document.querySelectorAll('input[data-input=payout]').forEach(input => {
                            errorMap.push(input.id)
                        })
                        errorMap.map(id => {
                            error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
                        })
                    })
            }
        });
    });

    $(document).on("click", "#cancel-edit-transaction", function (e) {
        e.preventDefault()
        loader()
        loadReviewAction(transaction_review_actions_url);
    });

    document.getElementById('approveModal').addEventListener('hidden.bs.modal', event => {
        $('#modalContent').empty();
        window.transaction_review_actions_url = null;
        window.transaction_approve_url = null;
        window.transaction_reject_url = null;
    })

    flatpickr("#transaction-date-range", {
        mode: "range",
        dateFormat: "Y-m-d H:i",
        defaultDate: date_range && date_range.split("to"),
        enableTime: true,
        time_24hr: true,
    });

    $(document).on("click", "#transaction-search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#transaction-date-range").val());
        urlParams.set("status", $("#transaction-status").val());
        urlParams.set("purchaser_id", $("#purchaser_id").val());
        urlParams.set("user_id", $("#user_id").val());
        urlParams.set("currency-type", $("#currency-type").val());
        urlParams.set("product-type", $("#product-type").val());
        urlParams.set("pay-method", $("#pay-method").val());
        urlParams.set("amount-start", $("#amount-start").val());
        urlParams.set("amount-end", $("#amount-end").val());
        let url = data_url.split(/\?|\#/)[0] + "?" + urlParams.toString();
        HISTORY_STATE && history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

    function loadReviewAction(url) {
        $.get(url, function (data) {
            // console.log(data)
            // Create a modal with the loaded content
            $('#modalContent').html(data.html);
            window.transaction_review_actions_url = url;
            window.transaction_approve_url = data.approve_url;
            window.transaction_reject_url = data.reject_url;
            Swal.close()
        });
    }

    function appendError(id, html) {
        try {
            let el = $(document.getElementById(id));
            $(el).next(".text-danger").remove();
            $(html).insertAfter(el)
        } catch (e) {

        }
    }

})

