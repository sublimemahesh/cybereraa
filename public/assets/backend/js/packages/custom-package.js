$(function () {
    const payMethodChooseModal = new bootstrap.Modal('#pay-method-modal', {
        backdrop: 'static',
    })
    const tempBinancePay = new bootstrap.Modal('#temp-binance-pay', {
        backdrop: 'static',
    })

    $("#purchase_for").select2({
        ajax: {
            url: function (params) {
                return APP_URL + '/user/filter/users/' + params.term;
            }, method: 'POST', dataType: 'json', delay: 1000, processResults: function (data) {
                return {
                    results: data.data
                };
            }, cache: true
        },
        dropdownParent: $('#pay-method-modal'),
        minimumInputLength: 3,
        placeholder: 'Select an User',
        allowClear: true
    });


    // BIND event for only valid packages base on the package

    const element = `#custom-choose`;

    const wallet_method_element = `#wallet-custom`;
    const topup_wallet_method_element = `#topup-wallet-custom`;
    const binancepay_method_element = `#binance-pay-custom`;
    const coinpayment_method_element = `#coinpayment-custom`;
    const manual_method_element = `#manual-pay-custom`;

    $(document).on("click", element, function (e) {
        e.preventDefault();
        $(".pay-method-wallet").attr('id', `wallet-custom`)
        $(".pay-method-topup-wallet").attr('id', `topup-wallet-custom`)
        $(".pay-method-manual-pay").attr('id', `manual-pay-custom`)
        $(".pay-method-binance-pay").attr('id', `binance-pay-custom`)
        $(".pay-method-coinpayment").attr('id', `coinpayment-custom`)
        payMethodChooseModal.show();
    });

    $(document).on('click', topup_wallet_method_element, function () {
        // generateInvoice("topup", 'custom')
    });

    $(document).on('click', wallet_method_element, function () {
        // generateInvoice("main", 'custom')
    });

    $(document).on('click', binancepay_method_element, function () {
        // payMethodChooseModal.hide()
        tempBinancePay.show()
        //generateInvoice("binance", 'custom')
    });

    $(document).on('click', coinpayment_method_element, function () {
        // payMethodChooseModal.hide()
        generateInvoice("coin_payment", 'custom')
    });

    $(document).on('click', manual_method_element, function () {
        loader()
        let purchase_for = $('#purchase_for').val()
        let pkg_amount = parseFloat($('#custom-deposit-amount').val())
        location.href = `${APP_URL}/user/packages/custom/${pkg_amount}/${purchase_for !== null ? purchase_for : ''}`;
    });

    document.getElementById('pay-method-modal').addEventListener('hidden.bs.modal', event => {
        $(".pay-method-wallet").attr('id', 'wallet')
        $(".pay-method-topup-wallet").attr('id', 'topup-wallet')
        $(".pay-method-manual-pay").attr('id', 'manual-pay')
        $(".pay-method-binance-pay").attr('id', 'binance-pay')
        $('#purchase_for').val(null).trigger('change')
        $('#purchase_for').empty()
    })

    function generateInvoice(payMethod, package_slug) {
        let purchase_for_user_info = 'Yourself';
        try {
            let el = document.getElementById("purchase_for")
            purchase_for_user_info = el.options[el.selectedIndex].text
        } catch (e) {
        }
        let footer = purchase_for_user_info.length > 0 && 'Package Purchase for: ' + purchase_for_user_info;
        Swal.fire({
            title: "Are You Sure?",
            text: "Purchase selected package?. Please note that you cannot reverse this order after completing the purchase!",
            icon: "info",
            showCancelButton: true,
            footer: '<small style="color:green">' + footer + '</small>'
        }).then((purchase) => {
            if (purchase.isConfirmed) {
                loader()
                let purchase_for = $('#purchase_for').val()
                axios.post(`${APP_URL}/user/binancepay/order/create`, {
                    method: payMethod,
                    purchase_for,
                    package: package_slug,
                    amount: parseFloat($('#custom-deposit-amount').val()),
                }).then(response => {
                    payMethodChooseModal.hide()
                    Swal.fire({
                        icon: response.data.icon, text: response.data.message,
                    })
                    if (response.data.status) {
                        loader("Redirecting...")
                        setTimeout(() => {
                            location.href = response.data.data.checkoutUrl
                        }, 200)
                    }
                }).catch(error => {
                    let error_msg = error.response.data.message || "Something went wrong!"
                    payMethodChooseModal.hide()
                    Swal.fire({
                        icon: "error",
                        text: 'Something went wrong!',
                        confirmButtonColor: '#4466f2',
                        footer: '<small style="color:red">' + error_msg + '</small>'
                    });
                })
            }
        });
    }

})
