$(function () {
    function isFloat(n) {
        return Number(n) === n && n % 1 !== 0;
    }

    setTimeout(() => {
        $('#withdraw-amount').val(MINIMUM_PAYOUT_LIMIT).change();
    }, 500)

    $(document).on('change', '#withdraw-amount, #main, #topup, #staking', function (e) {
        e.preventDefault();
        appendError("withdraw-amount", ``);
        const wallet_type = $("input[name='wallet_type']:checked").val();
        let amount = parseFloat($('#withdraw-amount').val()) || 0;
        if (isFloat(amount)) {
            console.log("isFloat " + amount);
            appendError("withdraw-amount", `<span class="text-danger">Please enter a valid integer amount for withdrawal. </span>`);
        }
        let trx_fee = (amount * parseFloat(P2P_TRANSFER_FEE)) / 100;
        console.log(trx_fee, wallet_type, wallet_type === 'staking')
        if (wallet_type === 'staking') {
            trx_fee = parseFloat(STAKING_TRANSFER_FEE);
        }
        if (amount < MINIMUM_PAYOUT_LIMIT) {
            $('#withdraw-amount').val(MINIMUM_PAYOUT_LIMIT).change();
            $('#show-receiving-amount').html('USDT ' + (MINIMUM_PAYOUT_LIMIT + trx_fee))
            return
        }

        $('#show-receiving-amount').html('USDT ' + (new Intl.NumberFormat().format(amount + trx_fee)))
    })

    $(document).on('click', '#send-2ft-code', function (e) {
        e.preventDefault();
        const amount = $('#withdraw-amount').val();
        const remark = $('#remark').val();
        const password = $('#password').val();
        const code = $('#code').val();
        const wallet_type = $("input[name='wallet_type']:checked").val();

        loader()
        axios.post(APP_URL + '/user/wallet/withdraws/2ft-verify', {
            amount,
            remark,
            password,
            wallet_type,
            code,
            minimum_payout_limit: MINIMUM_PAYOUT_LIMIT
        }).then(response => {
            Toast.fire({
                icon: response.data.icon, title: response.data.message,
            })
            if (response.data.status) {
                $('#2ft-section').html(`
                     <div class="mb-3 mt-2">
                        <label for="code">OTP Code </label>
                        <input id="otp" data-input="form-input" type="password" class="form-control" autocomplete="one-time-password" placeholder="OTP code">
                        <div class="text-info cursor-pointer" id="send-2ft-code">Resend OTP </div>
                    </div>
                    <button type="submit" id="confirm-payout" class="btn btn-sm btn-success mb-2">Confirm & Withdraw</button>
                `)
                try {
                    $('#2ft-section').find('.text-danger').remove()
                    if (response.data.sms_error !== null) {
                        $('#2ft-section').after(`<div class="text-danger">${response.data.sms_error}</div>`)
                    }
                } catch (e) {
                }
            }
        }).catch(error => {
            Toast.fire({
                icon: 'error', title: error.response.data.message || "Something went wrong!",
            });
            let errorMap = [];
            document.querySelectorAll('input[data-input=form-input]').forEach(input => {
                console.log(input.id)
                errorMap.push(input.id === 'withdraw-amount' ? 'withdraw-amount' : input.id)
            })
            console.log(errorMap)
            errorMap.map(id => {
                try {
                    let errorMsg = id === 'withdraw-amount' ? error.response.data.errors['amount'] : error.response.data.errors[id];
                    console.log(id, errorMsg)
                    errorMsg && appendError(id, `<span class="text-danger">${errorMsg}</span>`)
                } catch (e) {

                }
            })
        })
    })

    $(document).on('click', '#confirm-payout', function (e) {
        e.preventDefault();
        const amount = $('#withdraw-amount').val();
        const remark = $('#remark').val();
        const password = $('#password').val();
        const code = $('#code').val();
        const wallet_type = $("input[name='wallet_type']:checked").val();
        const otp = $('#otp').val();

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
        } else if (otp === null || otp.length <= 0) {
            Toast.fire({
                icon: 'error', title: "Please Enter a OTP that sent to your email or mobile!",
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
                    axios.post(APP_URL + '/user/wallet/withdraw/binance', {
                        amount,
                        remark,
                        wallet_type,
                        password,
                        otp,
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
                        let errorMap = [];
                        document.querySelectorAll('input[data-input=form-input]').forEach(input => {
                            errorMap.push(input.id === 'withdraw-amount' ? 'withdraw-amount' : input.id)
                        })
                        errorMap.map(id => {
                            try {
                                let errorMsg = id === 'withdraw-amount' ? error.response.data.errors['amount'] : error.response.data.errors[id];
                                console.log(id, errorMsg)
                                errorMsg && appendError(id, `<span class="text-danger">${errorMsg}</span>`)
                            } catch (e) {

                            }
                        })
                    })
                }
            });
        }
    })


    function appendError(id, html) {
        try {
            let el = $(document.getElementById(id));
            $(el).next(".text-danger").remove();
            $(html).insertAfter(el)
        } catch (e) {

        }
    }
})

