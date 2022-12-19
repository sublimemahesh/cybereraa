$(function () {
    $("#assign-position").select2({
        placeholder: 'Select an User', allowClear: true
    });

    $(document).on('click', '#confirm-assign', function (e) {
        e.preventDefault();
        let pending_user = $('#assign-position').val();
        if (pending_user.length <= 0) {
            Toast.fire({
                icon: 'error', title: "Choose an user from the list!",
            })
            return false
        } else {
            Swal.fire({
                title: "Are You Sure?", text: "Assign user to selected position?", icon: "info", showCancelButton: true,
            }).then((create) => {
                if (create.isConfirmed) {
                    loader()
                    axios.post(location.href, {pending_user}).then(response => {
                        Toast.fire({
                            icon: response.data.icon, title: response.data.message,
                        }).then(res => {
                            if (response.data.status) {
                                response.data.redirectUrl ? location.href = response.data.redirectUrl : location.reload();
                            }
                        })
                    }).catch(error => {
                        Toast.fire({
                            icon: 'error', title: error.response.data.message || "Something went wrong!",
                        })
                    })
                }
            });
        }
    })
})