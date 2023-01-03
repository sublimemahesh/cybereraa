$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#transactions').DataTable({
        language: {
            paginate: {
                next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
            }
        },
        lengthMenu: [[25, 50, 100, 250, 500, -1], [25, 50, 100, 250, 500, "All"],],
        responsive: true,
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        stateSave: false,
        ajax: location.href,
        order: [[1, 'desc']],
        columns: [
            {data: "type", searchable: false},
            {data: "amount", name: 'amount', searchable: false},
            {data: "paid", name: 'paid', searchable: false},
            {data: "next_payment_date", searchable: false},
            {data: "status", searchable: false},
            {data: "created_at", searchable: false},
            {data: "package", searchable: false},
        ],
    })

    flatpickr("#date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#search", function (e) {
        e.preventDefault();

        urlParams.set("date-range", $("#date-range").val());
        urlParams.set("status", $("#status").val());
        urlParams.set("type", $("#commission-type").val());

        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });
})