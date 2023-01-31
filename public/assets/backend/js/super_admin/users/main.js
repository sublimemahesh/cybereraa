$(function () {

    let table = $('#users').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        order: [[1, 'asc']],
        //stateSave: true,
        ajax: location.href,
        columns: [
            {data: "actions", searchable: false, orderable: false},
            {data: "id", name: 'id', searchable: true},
            {data: "username", name: 'username', searchable: true, orderable: false},
            {data: "name", name: 'id', searchable: true},
            {data: "phone", name: 'phone', searchable: true, orderable: false},
            {data: "email", name: 'email', searchable: true, orderable: false},
            {data: "roles", searchable: false, orderable: false},
        ]
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