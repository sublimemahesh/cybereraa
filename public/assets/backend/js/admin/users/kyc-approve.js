$(function () {
    const clickable_status = ['approve', 'reject']
    clickable_status.map(status => {
        $(document).on('click', "." + status + "-kyc", function (e) {
            let document = $(this).data('document');
            e.preventDefault();
            Swal.fire({
                title: "Are You Sure?",
                text: status.charAt(0).toUpperCase() + status.slice(1) + " Kyc Document?",
                icon: "info",
                showCancelButton: true,
            }).then((create) => {
                if (create.isConfirmed) {
                    loader()
                    axios.post(`${APP_URL}/admin/users/kyc-documents/${document}/status`, {
                        status
                    }).then(response => {
                        Toast.fire({
                            icon: response.data.icon, title: response.data.message,
                        }).then(res => {
                            if (response.data.status) {
                                location.reload();
                            }
                        })
                    }).catch(error => {
                        console.log(error)
                        Toast.fire({
                            icon: 'error', title: error.response.data.message || "Something went wrong!",
                        })
                    })
                }
            });
        })
    })
})

////////////////////////////////  KYC Image rotation initialize //////////////////////

 $(document).ready(function() {

            ezoom.onInit($('.imgDiv'), {
                hideControlBtn: false,
                onClose: function(result) {
                    console.log(result);
                },
                onRotate: function(result) {
                    console.log(result);
                },

            });

        });
