(() => {
    $(function () {
        const queryString = window.location.search;
        const urlParams = new URLSearchParams(queryString);
        const current_url = location.href;

        const period = urlParams.get("period");
        $.ajaxSetup({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
        });
        let ticket_table = $("#tickets").DataTable({
            scrollX: true,
            destroy: true,
            processing: true,
            serverSide: true,
            // stateSave: true,
            ajax: location.href,
            order: [[7, 'asc']],
            columns: [
                {data: "actions", name: "actions", searchable: false, orderable: false},
                {data: "user.username", name: "user.username", orderable: false},
                {data: "id", name: "id", searchable: false, orderable: false},
                {data: "subject", name: "subject", searchable: false, orderable: false},
                {data: "category", name: "ticket_category_id", searchable: false, orderable: false},
                {data: "priority", name: "ticket_priority_id", searchable: false, orderable: false},
                {data: "status", name: "ticket_status_id", searchable: false, orderable: false},
                {data: "created_at_formatted", name: "created_at", searchable: false, orderable: true},
            ],
            columnDefs: [
                {
                    render: function (date, type, full, meta) {
                        return `<div style="font-size: 0.76rem !important;"> ${date} </div>`;
                    }, targets: [0, 1, 2, 3, 5, 6, 7],
                },
            ],
        });

        //   Search
        $(document).on("click", "#search", function (e) {
            e.preventDefault();
            urlParams.set("category", $("#input_category").val() || "");
            urlParams.set("priority", $("#input_priority").val() || "");
            urlParams.set("status", $("#input_status").val() || "");
            let url =
                location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
            history.replaceState({}, "", url);
            ticket_table.ajax.url(url).load();
        });

        $(document).on("click", ".delete-ticket", function (e) {
            e.preventDefault();
            let ticket = $(this).data("id");
            Swal.fire({
                title: "Are You Sure?",
                text: "Are you want to delete this ticket?",
                icon: "warning",
                showCancelButton: true,
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    axios
                        .delete(
                            `${APP_URL}/admin/support/tickets/${ticket}/delete`
                        )
                        .then(function (response) {
                            ticket_table.draw();
                        })
                        .catch(function (err) {
                            alert(err.response.data.message);
                        });
                }
            });
        });
        $(document).on("click", ".close-ticket", function (e) {
            e.preventDefault();
            let ticket = $(this).data("id");
            Swal.fire({
                title: "Are You Sure?",
                text: "Are you want to close this ticket?",
                icon: "warning",
                showCancelButton: true,
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    axios
                        .patch(
                            `${APP_URL}/admin/support/tickets/${ticket}/close`
                        )
                        .then(function (response) {
                            ticket_table.draw();
                        })
                        .catch(function (err) {
                            alert(err.response.data.message);
                        });
                }
            });
        });
        $(document).on("click", ".reopen-ticket", function (e) {
            e.preventDefault();
            let ticket = $(this).data("id");
            Swal.fire({
                title: "Are You Sure?",
                text: "Are you want to reopen this ticket?",
                icon: "info",
                showCancelButton: true,
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    axios
                        .patch(
                            `${APP_URL}/admin/support/tickets/${ticket}/reopen`
                        )
                        .then(function (response) {
                            ticket_table.draw();
                        })
                        .catch(function (err) {
                            alert(err.response.data.message);
                        });
                }
            });
        });
        $(document).on("click", ".priority-ticket", function (e) {
            e.preventDefault();
            let ticket = $(this).data("id");
            let priority = $(this).data("priority");
            axios
                .patch(
                    `${APP_URL}/admin/support/tickets/${ticket}/priority-ticket/${priority}/`
                )
                .then(function (response) {
                    ticket_table.draw();
                })
                .catch(function (err) {
                    alert(err.response.data.message);
                });
        });
    });
})();
