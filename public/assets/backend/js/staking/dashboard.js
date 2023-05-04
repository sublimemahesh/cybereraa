$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");
    const package_id = urlParams.get("package_id");

    let table = $('#transactions').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        order: [[6, 'desc']], //stateSave: true,
        ajax: location.href,
        columns: [
            {data: "actions", searchable: false, orderable: false},
            {data: "trx_id", name: 'transaction_id', searchable: true, orderable: false},
            {data: "user", name: 'user.username', orderable: false},
            {data: "status", searchable: false, orderable: false},
            {data: "maturity_date", searchable: false, orderable: false},
            {data: "interest", searchable: false, orderable: false},
            {data: "created", name: 'created_at', searchable: false, orderable: true},
            {data: "invested", name: 'invested_amount', searchable: false, orderable: false},
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

            let pageTotal = new Intl.NumberFormat().format(sumVal(7));
            $(api.column(7).footer()).html(`Total: USDT ${pageTotal}`);

        },
        columnDefs: [
            {
                render: function (data, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;" > ${data} </div>`;
                },
                targets: [1, 2, 4, 5, 6],
            },
            {
                render: function (data, type, full, meta) {
                    return `<div style="min-width:120px" class="text-center"> ${data} </div>`;
                },
                targets: [3],
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style="min-width:120px" class="text-right"> ${amount} </div>`;
                },
                targets: [3, 7],
            },
        ],
    });

    flatpickr("#transaction-date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    fetchPlans(package_id)
    $(document).on("change", "#package_id", function (e) {
        e.preventDefault();
        fetchPlans($(this).val())
    });

    $(document).on("click", "#transaction-search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#transaction-date-range").val());
        urlParams.set("status", $("#transaction-status").val());
        //urlParams.set("user_id", $("#user_id").val());
        urlParams.set("purchaser_id", $("#purchaser_id").val());
        urlParams.set("package_id", $("#package_id").val());
        urlParams.set("plan_id", $("#plan_id").val());
        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

    function fetchPlans(stake_package) {
        $('#plan_id').html("<option value=''>ALL</option>");
        if (stake_package) {
            axios(`${APP_URL}/staking-packages/${stake_package}/fetch-plans`).then(response => {
                if (response.data.status) {
                    response.data.data.map(plan => {
                        let html = `<option value="${plan.id}" ${parseInt(package_id) === plan.id ? 'selected' : ''}>${plan.name}</option>`
                        $('#plan_id').append(html)
                    })
                }
            }).catch(console.error)
        }
    }
})
