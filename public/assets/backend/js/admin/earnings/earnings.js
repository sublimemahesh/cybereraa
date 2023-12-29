$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#earnings').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        order: [[5, 'desc']],
        //stateSave: true,
        ajax: EARNING_URL,
        columns: [
            {data: "earnable_type", searchable: false, orderable: false},
            {data: "user_id", searchable: false, orderable: false},
            {data: "user", name: 'user.username', searchable: true, orderable: false},
            //{data: "username"},
            {data: "package", searchable: false, orderable: false},
            {data: "status", searchable: false, orderable: false},
            {data: "date", name: 'created_at', searchable: false},
            {data: "amount_formatted", name: 'amount', orderable: true},
        ],
        footerCallback: function (row, data, start, end, display) {
            let api = this.api();

            // Remove the formatting to get integer data for summation
            let intVal = function (i) {
                return typeof i === 'string' ? i.replace(/[\$,]/g, '') * 1 : typeof i === 'number' ? i : 0;
            };

            // Total over this page
            let pageTotal = api
                .column(6, {page: 'current'})
                .data()
                .reduce(function (a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            let numberFormatOptions = {
                minimumFractionDigits: 2,
                maximumFractionDigits: 2,
            }
            // Update footer
            pageTotal = new Intl.NumberFormat('en-US', numberFormatOptions).format(pageTotal);
            $(api.column(6).footer()).html(`${pageTotal}`);
        },
        columnDefs: [
            {
                render: function (amount, type, full, meta) {
                    return `<div style="font-size:0.76rem" > ${amount} </div>`;
                },
                targets: [0, 1, 2, 3, 4, 5,],
            }, {
                render: function (amount, type, full, meta) {
                    return `<div style="font-size:0.76rem"  class="text-right"> ${amount} </div>`;
                },
                targets: [6],
            },
        ],
    });

    flatpickr("#earnings-date-range", {
        mode: "range",
        dateFormat: "Y-m-d H:i",
        defaultDate: date_range && date_range.split("to"),
        enableTime: true,
        time_24hr: true,
    });

    $(document).on("click", "#earnings-search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#earnings-date-range").val());
        urlParams.set("status", $("#earnings-status").val());
        urlParams.set("user_id", $("#user_id").val());
        urlParams.set("earning-type", $("#earning-type").val());
        urlParams.set("amount-start", $("#amount-start").val());
        urlParams.set("amount-end", $("#amount-end").val());
        let url = EARNING_URL.split(/\?|\#/)[0] + "?" + urlParams.toString();
        HISTORY_STATE && history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

    if (HISTORY_STATE) {
        $(document).on('click', '#calculate-profit', function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Are You Sure?",
                text: `Calculate profit for today(${moment().format('Y-MM-D')}) now!`,
                icon: "info",
                showCancelButton: true,
            }).then((calculate) => {
                if (calculate.isConfirmed) {
                    loader()
                    axios.post(APP_URL + "/admin/reports/users/earnings/calculate-profit").then(response => {
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
        $(document).on('click', '#calculate-commission', function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Are You Sure?",
                text: `Calculate commission allowance for today(${moment().format('Y-MM-D')}) now!`,
                icon: "info",
                showCancelButton: true,
            }).then((calculate) => {
                if (calculate.isConfirmed) {
                    loader()
                    axios.post(APP_URL + "/admin/reports/users/earnings/calculate-commission").then(response => {
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
        $(document).on('click', '#release-staking-interest', function (e) {
            e.preventDefault();
            Swal.fire({
                title: "Are You Sure?",
                text: `Release the staking interest for maturity date (${moment().format('Y-MM-D')})!`,
                icon: "info",
                showCancelButton: true,
            }).then((calculate) => {
                if (calculate.isConfirmed) {
                    loader()
                    axios.post(APP_URL + "/admin/reports/users/earnings/release-staking-interest")
                        .then(response => {
                            Toast.fire({
                                icon: response.data.icon, title: response.data.message,
                            })
                            let url = location.href.split(/\?|\#/)[0];
                            history.replaceState({}, "", url);
                            table.ajax.url(url).load();
                        })
                        .catch(error => {
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
