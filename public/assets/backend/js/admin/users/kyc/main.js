$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#users').DataTable({
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
            {data: "profile_photo", searchable: false, orderable: false},
            {data: "id", name: 'id', searchable: true},
            {data: "username", name: 'username', searchable: true, orderable: false},
            {data: "name", name: 'id', searchable: true},
            {data: "phone", name: 'phone', searchable: true, orderable: false},
            {data: "email", name: 'email', searchable: true, orderable: false},
            {data: "joined", name: 'created_at', searchable: false},
            {data: "actions", searchable: false, orderable: false},
        ],
        columnDefs: [
            {
                render: function (data, type, full, meta) {
                    return `<div style='max-width:60px' > ${data} </div>`;
                },
                targets: 0,
            },
            {
                render: function (data, type, full, meta) {
                    return `<div style='min-width:180px' > ${data} </div>`;
                },
                targets: 6,
            },
        ],
    });

    flatpickr("#date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#date-range").val());
        urlParams.set("kyc-status", $("#kyc-status").val());
        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

})