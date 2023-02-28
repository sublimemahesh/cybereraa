$(function () {
    $("#to-wallet").select2({
        placeholder: 'Select an User',
        allowClear: true
    });

    $(document).on('click', '#confirm-transfer', function (e) {
        e.preventDefault();
        let to_wallet = $('#to-wallet').val();
        let amount = $('#transfer-amount').val();
        let remark = $('#remark').val();
        let password = $('#password').val();
        let code = $('#code').val();
        if (to_wallet === null || to_wallet.length <= 0) {
            Toast.fire({
                icon: 'error', title: "Select where to transfer USDT!",
            })
            return false
        } else if (amount.length <= 0 || parseFloat(amount) > MAX_WITHDRAW_LIMIT) {
            Toast.fire({
                icon: 'error', title: "Please Enter a valid amount to transfer!",
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
                text: "Transfer funds to selected wallet? Please note that this process cannot be reversed. Please make sure all the provided information's are double checked before proceed.!",
                icon: "info",
                showCancelButton: true,
            }).then((transfer) => {
                if (transfer.isConfirmed) {
                    loader()
                    axios.post(location.href, {
                        to_wallet,
                        amount,
                        remark,
                        password,
                        code
                    }).then(response => {
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
