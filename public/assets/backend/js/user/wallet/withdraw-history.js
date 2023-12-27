$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");
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
        order: [[5, 'desc']],
        //stateSave: true,
        ajax: location.href,
        columns: [
            {data: "actions", searchable: false, orderable: false},
            {data: "withdraw_id", name: 'id', searchable: false, orderable: false},
            {data: "type_n_wallet", 'name': 'type', searchable: false, orderable: false},
            {data: "wallet_address", searchable: false, orderable: false},
            {data: "status", searchable: false, orderable: false},
            {data: "date", name: 'created_at', searchable: false},
            {data: "amount", name: 'amount', searchable: false, orderable: false},
            {data: "fee", name: 'transaction_fee', searchable: false, orderable: false},
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
            let amount = new Intl.NumberFormat('en-US', numberFormatOptions).format(sumVal(6));
            $(api.column(6).footer()).html(`${amount}`);

            let transaction_fee = new Intl.NumberFormat('en-US', numberFormatOptions).format(sumVal(7));
            $(api.column(7).footer()).html(`${transaction_fee}`);

            let total = new Intl.NumberFormat('en-US', numberFormatOptions).format(sumVal(8));
            $(api.column(8).footer()).html(`${total}`);
        },
        columnDefs: [
            {
                render: function (date, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;"> ${date} </div>`;
                }, targets: [1, 2, 4, 5],
            },
            {
                render: function (data, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;" class="text-truncate copy-to-clipboard cursor-pointer"  data-clipboard-text="${data}">
                                <i class="fa fa-clone" style="font-size: 17px;"></i>
                                ${data}
                            </div>`;
                }, targets: [3],
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;" class="text-right"> ${amount} </div>`;
                }, targets: [6, 7, 8],
            },
        ],
    });

    flatpickr("#date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#date-range").val());
        urlParams.set("status", $("#status").val());
        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

})
