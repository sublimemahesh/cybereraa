$(function () {

    $(document).on('change', '#withdraw-amount', function (e) {
        e.preventDefault();
        let amount = parseFloat($('#withdraw-amount').val()) || 0;
        if (amount < MINIMUM_PAYOUT_LIMIT) {
            $('#withdraw-amount').val(MINIMUM_PAYOUT_LIMIT).change();
            $('#show-receiving-amount').html('USDT ' + (MINIMUM_PAYOUT_LIMIT + P2P_TRANSFER_FEE))
            return false
        }
    })

    $(document).on('click', '#confirm-payout', function (e) {
        e.preventDefault();
        const amount = $('#withdraw-amount').val();
        const remark = $('#remark').val();
        const password = $('#password').val();
        const code = $('#code').val();
        const wallet_type = $("input[name='wallet_type']:checked").val();
            /* || parseFloat(amount) > MAX_WITHDRAW_LIMIT*/
        if (amount.length <= 0 || parseFloat(amount) < MINIMUM_PAYOUT_LIMIT) {
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
                text: "Request a payout?",
                icon: "info",
                showCancelButton: true,
            }).then((transfer) => {
                if (transfer.isConfirmed) {
                    loader()
                    axios.post(APP_URL + '/user/wallet/withdraw/binance', {amount, remark, wallet_type, password, code}).then(response => {
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
