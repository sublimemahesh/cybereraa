$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#earnings').DataTable({
        language: {
            paginate: {
                next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
            }
        },
        lengthMenu: [[100, 250, 500, -1], [100, 250, 500, "All"],],
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        order: [[6, 'desc']],
        stateSave: true,
        ajax: location.href,
        columns: [
            {data: "type", searchable: false},
            {data: "user_id", searchable: false},
            {data: "username", name: 'user.username'},
            {data: "package", name: "purchasedPackage.package.name"},
            {data: "amount"},
            {data: "status", searchable: false},
            {data: "created_at", searchable: false},
        ],
    });

    flatpickr("#date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#search", function (e) {
        e.preventDefault();
        urlParams.set("date-range", $("#date-range").val());
        urlParams.set("status", $("#status").val());
        urlParams.set("user_id", $("#user_id").val());
        urlParams.set("earning-type", $("#earning-type").val());
        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

    $(document).on('click', '#calculate-profit', function (e) {
        e.preventDefault();
        Swal.fire({
            title: "Are You Sure?",
            text: `Calculate profit for today(${moment().format('Y-MM-d')}) now!`,
            icon: "info",
            showCancelButton: true,
        }).then((calculate) => {
            if (calculate.isConfirmed) {
                loader()
                axios.post(APP_URL + "/admin/users/earnings/calculate-profit").then(response => {
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
})