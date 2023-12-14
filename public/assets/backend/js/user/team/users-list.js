$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");
    const depth = urlParams.get("depth");

    let table = $('#team-users').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        //fixedHeader: true,
        responsive: true,
        order: [[2, 'asc']],
        //stateSave: true,
        ajax: location.href,
        columns: [
            //{data: "profile_photo", name: 'id', searchable: true, orderable: false},
            {data: "user_details", name: 'username', searchable: true, orderable: false},
            {data: "contact_details", name: 'email', searchable: true, orderable: false},
            // {data: "sponsor", name: 'super_parent_id', searchable: false, orderable: false},
            // {data: "parent", name: 'parent_id', searchable: false, orderable: false},
            {data: "joined", name: 'created_at', searchable: false},
            // {data: "suspended", name: 'suspended_at', searchable: false},
            {data: "profit", searchable: false, orderable: false},
            {data: "account_investments", searchable: false},
        ],
        columnDefs: [

            {
                render: function (data, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;"> ${data} </div>`;
                },
                targets: [0, 1, 2, 3, 4 ],
            }
        ],
    });

    flatpickr("#date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#date-range").val());
        urlParams.set("status", $("#status").val());
        // let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        let url = TEAM_URL + "/" + $("#depth").val() + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

    $(document).on("click", ".view-downline-user", function (e) {
        e.preventDefault();
        let depth = parseInt(urlParams.get("depth")) || 1;
        urlParams.set("date-range", $("#date-range").val());
        urlParams.set("status", $("#status").val());
        // urlParams.set("depth", depth + 1);
        // let username = $(this).data('username');
        let url = TEAM_URL + "/" + $("#depth").val() + "?" + urlParams.toString();
        history.pushState({}, "", url);
        table.ajax.url(url).load();
    });

})
