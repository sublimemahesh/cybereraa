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
        order: [[3, 'desc']],
        //stateSave: true,
        ajax: location.href,
        columns: [
            {data: "profile_photo",  name:'id',  searchable: true, orderable: false},
            {data: "user_details", name:'name',searchable: true, orderable: false},
            {data: "contact_details", searchable: true, orderable: false},
            {data: "joined", name: 'created_at', searchable: false},
            {data: "actions", searchable: false, orderable: false},
        ],
        columnDefs: [
            {
                render: function (data, type, full, meta) {
                    return `<div style='width:50px'> ${data} </div>`;
                },
                targets: 0,
            },
            {
                render: function (data, type, full, meta) {
                    return `<div style='min-width:180px'> ${data} </div>`;
                },
                targets: 3,
            },

            {
                render: function (data, type, full, meta) {
                    return `<div style='min-width:180px'> ${data} </div>`;
                },
                targets: 2,
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

    $(document).on("click", ".suspend-user", function (e) {
        e.preventDefault();
        let user = $(this).data('user')
        let url = APP_URL + "/admin/users/" + user + "/suspend"
        userStatusChanged(url, "You want to Suspend selected user?")
    });
    $(document).on("click", ".activate-suspended-user", function (e) {
        e.preventDefault();
        let user = $(this).data('user')
        let url = APP_URL + "/admin/users/" + user + "/activate"
        userStatusChanged(url, "You want to Re-activate suspended user?")
    });

    function userStatusChanged(url, msg) {
        Swal.fire({
            title: "Are You Sure?",
            text: msg,
            icon: "info",
            showCancelButton: true,
        }).then((calculate) => {
            if (calculate.isConfirmed) {
                loader()
                axios.post(url).then(response => {
                    Toast.fire({
                        icon: response.data.icon, title: response.data.message,
                    })
                    table.draw();
                }).catch(error => {
                    console.log(error)
                    Toast.fire({
                        icon: 'error', title: error.response.data.message || "Something went wrong!",
                    })
                })
            }
        });
    }
})
