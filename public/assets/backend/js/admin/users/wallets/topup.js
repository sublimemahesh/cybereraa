$(function () {
    $("#topup-user").select2({
        ajax: {
            url: function (params) {
                return APP_URL + '/admin/filter/users/' + params.term;
            }, method: 'POST', dataType: 'json', delay: 1000, processResults: function (data) {
                return {
                    results: data.data
                };
            }, cache: true
        }, minimumInputLength: 3, placeholder: 'Select an User', allowClear: true
    });

    $(document).on('click', '#confirm-topup', function (e) {
        e.preventDefault();
        let receiver = $('#topup-user').val();
        let amount = $('#transfer-amount').val();
        let proof_documentation = $('#proof-documentation').val();
        let password = $('#password').val();
        let code = $('#code').val();
        if (receiver === null || receiver.length <= 0) {
            Toast.fire({
                icon: 'error', title: "Please Enter a valid username for the receive fund!",
            })
            return false
        } else if (amount === null || amount.length <= 0) {
            Toast.fire({
                icon: 'error', title: "Topup amount is required!",
            })
            return false
        } else if (proof_documentation === null || proof_documentation.length <= 0) {
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
                text: "Transfer funds with selected user?",
                icon: "info",
                showCancelButton: true,
            }).then((transfer) => {
                if (transfer.isConfirmed) {
                    loader()

                    let form = $('#topup-form')[0]
                    let form_data = new FormData(form);

                    axios.post(APP_URL + '/admin/topup/wallet', form_data).then(response => {
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
