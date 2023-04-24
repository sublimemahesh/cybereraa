$(function () {

    $(document).on('click', '#confirm-topup', function (e) {
        e.preventDefault();
        let amount = $('#amount').val();
        let proof_document = $('#proof-document').val();
        let password = $('#password').val();
        let code = $('#code').val();
        if (amount === null || amount.length <= 0) {
            Toast.fire({
                icon: 'error', title: "Withdraw amount is required!",
            })
            return false
        } else if (proof_document === null || proof_document.length <= 0) {
            Toast.fire({
                icon: 'error', title: "Please provide proof documentation of the receive fund!",
            })
            return false
        } else if (password === null || password.length <= 0) {
            Toast.fire({
                icon: 'error', title: "Please Enter a your account password!",
            })
            return false
        } else {
            Swal.fire({
                title: "Are You Sure?",
                text: "Withdraw from admin wallet?",
                icon: "info",
                showCancelButton: true,
            }).then((withdraw) => {
                if (withdraw.isConfirmed) {
                    loader()
                    let form = $('#withdraw-form')[0]
                    let form_data = new FormData(form);

                    axios.post(location.href, form_data).then(response => {
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
