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
        order: [[6, 'desc']],
        //stateSave: true,
        ajax: location.href,
        columns: [
            {data: "user", name: 'user.username', searchable: true, orderable: false},
            {data: "rank", searchable: false, orderable: false},
            {data: "eligibility", searchable: false, orderable: false},
            {data: "status", searchable: false, orderable: false},
            {data: "total_rankers", searchable: false, orderable: false},
            {data: "activated", searchable: false, name: 'activated_at'},
            {data: "created", searchable: false, name: 'created_at'},
        ],
        columnDefs: [
            {
                render: function (date, type, full, meta) {
                    return `<div style='font-size: 0.76rem !important;' class='text-center'> ${date} </div>`;
                },
                targets: [5, 6],
            },
            {
                render: function (data, type, full, meta) {
                    return `<div style='min-width:100px;' class="text-center"> ${data} </div>`;
                },
                targets: [1],
            }, {
                render: function (data, type, full, meta) {
                    return `<div style='font-size:12px'> ${data} </div>`;
                },
                targets: [0],
            },
        ],
    });

    flatpickr("#date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

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
