$(function () {
    $("#p2p-transfer").select2({
        ajax: {
            url: function (params) {
                return APP_URL + '/user/filter/users/' + params.term;
            },
            method: 'POST',
            dataType: 'json',
            delay: 1000,
            processResults: function (data) {
                return {
                    results: data.data
                };
            },
            cache: true
        },
        minimumInputLength: 3,
        placeholder: 'Select an User',
        allowClear: true
    });

    $(document).on('change', '#transfer-amount', function (e) {
        e.preventDefault();
        let amount = parseFloat($('#transfer-amount').val()) || 0;
        if (amount < MINIMUM_PAYOUT_LIMIT) {
            $('#transfer-amount').val(MINIMUM_PAYOUT_LIMIT).change();
            $('#show-receiving-amount').html('USDT ' + (MINIMUM_PAYOUT_LIMIT - P2P_TRANSFER_FEE))
            return false
        }
    })

    $(document).on('click', '#confirm-transfer', function (e) {
        e.preventDefault();
        const receiver = $('#p2p-transfer').val();
        const amount = $('#transfer-amount').val();
        const remark = $('#remark').val();
        const wallet_type = $("input[name='wallet_type']:checked").val();
        const password = $('#password').val();
        const code = $('#code').val();
        if (receiver === null || receiver.length <= 0) {
            Toast.fire({
                icon: 'error', title: "Please Enter a valid username for the receive fund!",
            })
            return false
        } else if (amount.length <= 0 || parseFloat(amount) < MINIMUM_PAYOUT_LIMIT) {
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
                text: "Transfer funds with selected user? Please note that this process cannot be reversed. Please make sure all the provided information's are double checked before proceed.!",
                icon: "info",
                showCancelButton: true,
            }).then((transfer) => {
                if (transfer.isConfirmed) {
                    loader()
                    axios.post(APP_URL + '/user/wallet/transfer/p2p', {
                        receiver,
                        amount,
                        remark,
                        password,
                        wallet_type,
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
