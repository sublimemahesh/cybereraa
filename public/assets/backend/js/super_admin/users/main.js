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

    window.admin_users_table = table;
})
