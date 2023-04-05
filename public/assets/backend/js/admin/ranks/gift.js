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
        order: [[5, 'desc']],
        stateSave: true,
        ajax: location.href,
        columns: [
            {data: "actions", searchable: true, orderable: false},
            {data: "user_id", name: 'user.username', searchable: true, orderable: false},
            {data: "rank", searchable: false, orderable: false},
            {data: "image", searchable: false, orderable: false},
            {data: "status", searchable: false, orderable: false},
            {data: "created_at", searchable: false, name: 'rank_gifts.created_at', orderable: false},
            {data: "gift_requirement", searchable: false, orderable: false},
            {data: "total_investment", searchable: false, orderable: false},
            {data: "total_team_investment", searchable: false, orderable: false},
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

            let total_investment = new Intl.NumberFormat().format(sumVal(7));
            $(api.column(8).footer()).html(`Current Page Total investment: USDT ${total_investment}`);

            let total_team_investment = new Intl.NumberFormat().format(sumVal(8));
            $(api.column(8).footer()).append(`<br><br>Current Page Total Team investment: USDT ${total_team_investment}`);
        },
        columnDefs: [
            {
                render: function (date, type, full, meta) {
                    return `<div style='font-size: 0.76rem !important;'> ${date} </div>`;
                },
                targets: [5],
            },
            {
                render: function (amount, type, full, meta) {
                    return `<div style='min-width:100px' class="text-right"> ${amount} </div>`;
                },
                targets: [7, 8],
            },
            {
                render: function (data, type, full, meta) {
                    return `<div style='min-width:100px' class="text-center"> ${data} </div>`;
                },
                targets: [2],
            },
        ],
    });

    flatpickr("#date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on('click', ".make-qualify-gift", function (e) {
        let gift = $(this).data('gift');
        e.preventDefault();
        Swal.fire({
            title: "Are You Sure?",
            text: "This will Qualify selected gift? This process cannot be undone!",
            icon: "info",
            showCancelButton: true,
        }).then((qualify) => {
            if (qualify.isConfirmed) {
                loader()
                axios.post(`${APP_URL}/admin/ranks/gifts/${gift}/qualify`)
                    .then(response => {
                        Toast.fire({
                            icon: response.data.icon, title: response.data.message,
                        })
                        table.draw()
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

    $(document).on("click", "#search", function (e) {
        e.preventDefault();
        urlParams.set("user_id", $("#user_id").val());
        urlParams.set("rank", $("#rank").val());
        urlParams.set("date-range", $("#date-range").val());
        urlParams.set("status", $("#status").val());
        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

})
