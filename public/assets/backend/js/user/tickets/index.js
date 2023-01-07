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
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            },
            lengthMenu: [10, 25, 50, 100, 250, 500, "All"],
            scrollX: true,
            destroy: true,
            processing: true,
            serverSide: true,
            stateSave: true,
            ajax: location.href,
            columns: [
                {data: "actions", name: "actions", searchable: false},
                {data: "id", name: "id", searchable: false},
                {data: "category", name: "ticket_category_id", searchable: false},
                {data: "priority", name: "ticket_priority_id", searchable: false},
                {data: "status", name: "ticket_status_id", searchable: false},
                {data: "subject", name: "subject", searchable: true},
                {data: "attachment", name: "attachment", searchable: false},
                {data: "created_at", name: "created_at", searchable: false},
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
                        .delete(`${APP_URL}/user/support/tickets/${ticket}/delete`)
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
                text: "Are you want to reopen this ticket?",
                icon: "warning",
                showCancelButton: true,
            }).then((willDelete) => {
                if (willDelete.isConfirmed) {
                    axios
                        .patch(
                            `${APP_URL}/user/support/tickets/${ticket}/close`
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
                            `${APP_URL}/user/support/tickets/${ticket}/reopen`
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
    });
})();
