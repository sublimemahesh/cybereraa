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
    ALLOWED_PACKAGES.map(package_slug => {
        let element = `#${package_slug}-choose`;
        let wallet_method_element = `#wallet-${package_slug}`;
        let binancepay_method_element = `#binance-pay-${package_slug}`;

        $(document).on("click", element, function (e) {
            e.preventDefault();
            $(".pay-method-wallet").attr('id', `wallet-${package_slug}`)
            $(".pay-method-binance-pay").attr('id', `binance-pay-${package_slug}`)
            payMethodChooseModal.show();
        });

        $(document).on('click', wallet_method_element, function () {
            generateInvoice("wallet", package_slug)
        });

        $(document).on('click', binancepay_method_element, function () {
            payMethodChooseModal.hide()
            tempBinancePay.show()
            //generateInvoice("binance-pay", package_slug)
        });
    })

    document.getElementById('pay-method-modal').addEventListener('hidden.bs.modal', event => {
        $(".pay-method-wallet").attr('id', 'wallet')
        $(".pay-method-binance-pay").attr('id', 'binance-pay')
        $('#purchase_for').val(null).trigger('change')
        $('#purchase_for').empty()
    })

    function generateInvoice(payMethod, package_slug) {
        Swal.fire({
            title: "Are You Sure?",
            text: "Purchase selected package?. Please note that you cannot reverse this order after completing the purchase!",
            icon: "info",
            showCancelButton: true,
        }).then((purchase) => {
            if (purchase.isConfirmed) {
                loader()
                let purchase_for = $('#purchase_for').val()
                axios.post(`${APP_URL}/user/binancepay/order/create`, {
                    method: payMethod, purchase_for, package: package_slug
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