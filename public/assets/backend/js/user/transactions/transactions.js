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
            {data: "action", sortable:false, searchable: false},
            {data: "trx_id", name: 'id', searchable: true},
            {data: "package", searchable: false},
            {data: "type", searchable: false},
            {data: "trx_amount", name: 'amount', searchable: true},
            {data: "status", searchable: false},
            {data: "paid_at", searchable: false},
        ],
    })

    flatpickr("#date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#search", function (e) {
        e.preventDefault();

        urlParams.set("date-range", $("#date-range").val());
        urlParams.set("status", $("#status").val());
        urlParams.set("currency-type", $("#currency-type").val());

        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });
})