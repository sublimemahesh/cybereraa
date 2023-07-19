$(function () {


    $("#assign-position").select2({
        placeholder: 'Select an User', allowClear: true
    });

    $(document).on('click', '#confirm-assign', function (e) {
        e.preventDefault();
        let pending_user = $('#assign-position').val();
        if (pending_user === null || pending_user.length <= 0) {
            Toast.fire({
                icon: 'error',background: '#252a3d', title: "Choose an user from the list!",
            })
            return false
        } else {
            Swal.fire({
                title: "Are You Sure?",
                text: "Assign user to selected position? This will cannot be undone. Please make sure you have double check your selections!",
                icon: "info",
                background: '#252a3d',
                confirmButtonColor: '#111111',
                showCancelButton: true,
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
