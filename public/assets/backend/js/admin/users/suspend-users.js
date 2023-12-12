$(function () {

    $(document).on("click", ".suspend-user", async function (e) {
        e.preventDefault();
        let user = $(this).data('user')
        let url = APP_URL + "/admin/users/" + user + "/suspend"

        const {value: text} = await Swal.fire({
            input: "textarea",
            inputLabel: "Reason",
            inputPlaceholder: "Type your reason to suspend...",
            inputAttributes: {
                "aria-label": "Type your reason to suspend"
            },
            title: "Are You Sure?",
            text: "You want to Suspend selected user?",
            icon: "info",
            showCancelButton: true,
        });
        if (text) {
            loader()
            axios.post(url, {reason: text})
                .then(response => {
                    Toast.fire({
                        icon: response.data.icon, title: response.data.message,
                    })
                    admin_users_table.draw();
                })
                .catch(error => {
                    console.log(error)
                    Toast.fire({
                        icon: 'error', title: error.response.data.message || "Something went wrong!",
                    })
                })
        }
        //userStatusChanged(url, "You want to Suspend selected user?")
    });

    $(document).on("click", ".activate-suspended-user", function (e) {
        e.preventDefault();
        let user = $(this).data('user')
        let reason = $(this).data('reason')
        let url = APP_URL + "/admin/users/" + user + "/activate"
        Swal.fire({
            title: "Are You Sure?",
            text: "You want to Re-activate suspended user?",
            html: `<strong><b>Suspend Reason:</b> <code>${reason}</code></strong>`,
            icon: "info",
            confirmButtonText: `<i class="fa fa-thumbs-up"></i> Activate!`,
            showCancelButton: true,
        }).then((activate) => {
            if (activate.isConfirmed) {
                loader()
                axios.post(url).then(response => {
                    Toast.fire({
                        icon: response.data.icon, title: response.data.message,
                    })
                    admin_users_table.draw();
                }).catch(error => {
                    console.log(error)
                    Toast.fire({
                        icon: 'error', title: error.response.data.message || "Something went wrong!",
                    })
                })
            }
        });
        // userStatusChanged(url, "You want to Re-activate suspended user?")
    });
})
