$(function () {
    $(document).on("click", ".create-kyc-entry", function (e) {
        let kyc_type = $(this).data('kyc-type');
        Swal.fire({
            title: "Are You Sure?",
            text: "This will create a new kyc entry?",
            icon: "info",
            showCancelButton: true,
        }).then((create) => {
            if (create.isConfirmed) {
                axios.post(`${APP_URL}/user/kyc/new-entry`, {
                    kyc_type
                }).then(function (response) {
                    if (response.data.status) {
                        location.reload();
                    }
                }).catch(function (error) {
                    console.log(error)
                    Toast.fire({
                        icon: 'error',
                        title: error.response.data.message || "Something went wrong!",
                    })
                })
            }
        });
    })
})