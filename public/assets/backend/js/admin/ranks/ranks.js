$(function () {
    const queryString = window.location.search;
    const urlParams = new URLSearchParams(queryString);
    const date_range = urlParams.get("date-range");

    let table = $('#rewards').DataTable({
        scrollX: true,
        destroy: true,
        processing: true,
        serverSide: true,
        fixedHeader: true,
        responsive: true,
        order: [[7, 'desc']],
        //stateSave: true,
        ajax: location.href,
        columns: [
            {data: "actions", searchable: false, orderable: false},
            {data: "user", name: 'user.username', searchable: true, orderable: false},
            {data: "rank", searchable: false, orderable: false},
            {data: "requirement", searchable: false, orderable: false},
            {data: "eligibility", searchable: false, orderable: false},
            {data: "status", searchable: false, orderable: false},
            // {data: "total_rankers", searchable: false, orderable: false},
            {data: "activated", searchable: false, name: 'activated_at'},
            {data: "created", searchable: false, name: 'created_at'},
        ],
        columnDefs: [
            {
                render: function (date, type, full, meta) {
                    return `<div style="font-size: 0.76rem !important;" > ${date} </div>`;
                },
                targets: [1, 2, 3, 4, 5, 6, 7],
            },

        ],
    });

    flatpickr("#date-range", {
        mode: "range", dateFormat: "Y-m-d", defaultDate: date_range && date_range.split("to"),
    });

    $(document).on("click", "#search", function (e) {
        e.preventDefault();
        urlParams.set("user_id", $("#user_id").val());
        urlParams.set("rank", $("#rank").val());
        urlParams.set("date-range", $("#date-range").val());
        urlParams.set("status", $("#status").val());
        let url = location.href.split(/\?|\#/)[0] + "?" + urlParams.toString();
        history.replaceState({}, "", url);
        table.ajax.url(url).load();
    });

    $(document).on("click", ".issue-bonus", function (e) {
        e.preventDefault();
        let rank = parseInt($(this).data('rank'))
        let amount = rank === 1 ? 250 : 1250;
        Swal.fire({
            title: "Are You Sure?",
            text: "Issue $" + amount + " Bonus for this user?. Please note this process cannot be reversed.",
            icon: "info",
            showCancelButton: true,
        }).then((process) => {
            if (process.isConfirmed) {
                loader()
                let rankId = $(this).data('id')
                // formData.append(proof_document, proof_document)
                axios.post(`${APP_URL}/admin/reports/ranks/${rankId}/issue-bonus`)
                    .then(response => {
                        Toast.fire({
                            icon: response.data.icon, title: response.data.message,
                        })
                        table.draw();
                    })
                    .catch((error) => {
                        Toast.fire({
                            icon: 'error', title: error.response.data.message || "Something went wrong!",
                        })
                    })
            }
        });
    });
})
