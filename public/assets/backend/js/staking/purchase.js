$(function () {

    const manualPayMethodModal = new bootstrap.Modal('#manual-pay-method-modal', {
        backdrop: 'static',
    })

    const tempBinancePay = new bootstrap.Modal('#temp-binance-pay', {
        backdrop: 'static',
    })

    $("#staking-plan").select2()

    $("#purchase_for").select2({
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
            }, cache: true
        },
        minimumInputLength: 3,
        placeholder: 'Select an User',
        allowClear: true
    });


    const wallet_method_element = `#main-wallet`;
    const topup_wallet_method_element = `#topup-wallet`;
    const binancepay_method_element = `#binance-pay`;
    const manual_method_element = `#manual-pay`;


    $(document).on('click', wallet_method_element, function () {
        generateInvoice("main")
    });

    $(document).on('click', topup_wallet_method_element, function () {
        generateInvoice("topup")
    });

    $(document).on('click', binancepay_method_element, function () {
        tempBinancePay.show()
    });

    $(document).on('click', manual_method_element, function () {
        const staking_plan = $('#staking-plan').val()
        console.log(staking_plan)
        if (staking_plan !== null && staking_plan !== '') {
            let purchase_for_user_info = 'Yourself';
            let manual_staking_plan_info = 'Not Selected';
            try {
                let purchase_for_user_el = document.getElementById("purchase_for")
                purchase_for_user_info = purchase_for_user_el.options[purchase_for_user_el.selectedIndex].text
            } catch (e) {
            }
            try {
                let staking_plan_el = document.getElementById("staking-plan")
                manual_staking_plan_info = staking_plan_el.options[staking_plan_el.selectedIndex].text
            } catch (e) {
            }
            $('#manual_purchase_for').html(purchase_for_user_info)
            $('#manual_staking_plan').html(manual_staking_plan_info)
            manualPayMethodModal.show()
        } else {
            Swal.fire({
                icon: 'error', text: "Please select a plan to purchase",
            })
        }
    });


    try {
        document.getElementById('requestManualPurchase').addEventListener('click', function (e) {
            e.preventDefault();
            generateInvoice('manual');
        })
    } catch (e) {

    }

    function generateInvoice(payMethod) {
        const manual_pay = payMethod === 'manual'
        let proof_document = $('#proof_document').val();
        const staking_plan = $('#staking-plan').val()

        if (staking_plan === null || staking_plan === '') {
            Swal.fire({
                icon: 'error', text: "Please select a plan to purchase",
            })
        } else if (manual_pay && (proof_document === null || proof_document.length <= 0)) {
            Swal.fire({
                icon: 'error', text: "Please provide the payment slip / Screenshot!",
            })
            return false
        } else {
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
                    const _FORM = manual_pay ? $('#manual-purchase-form') : undefined
                    let formData = new FormData();

                    if (_FORM) {
                        formData = new FormData(_FORM[0]);
                    }

                    const staking_plan = $('#staking-plan').val()
                    const purchase_for = $('#purchase_for').val()
                    if (purchase_for !== null && purchase_for !== '') {
                        formData.append('purchase_for', purchase_for)
                    }
                    formData.append('method', payMethod)
                    formData.append('staking_plan', staking_plan)

                    axios.post(`${APP_URL}/user/staking-packages/order/create`, formData)
                        .then(response => {
                            Swal.fire({
                                icon: response.data.icon, text: response.data.message,
                            })
                            if (response.data.status) {
                                loader("Redirecting...")
                                setTimeout(() => {
                                    location.href = response.data.data.checkoutUrl
                                }, 200)
                            }
                        })
                        .catch(error => {
                            console.error(error.response.data)
                            let error_msg = error.response.data.message || "Something went wrong!"
                            Swal.fire({
                                icon: "error",
                                text: 'Something went wrong!',
                                confirmButtonColor: '#4466f2',
                                footer: '<small style="color:red">' + error_msg + '</small>'
                            });
                            let errorMap = [];
                            document.querySelectorAll('input[data-input=payout]').forEach(input => {
                                errorMap.push(input.id)
                            })
                            errorMap.map(id => {
                                error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
                            })
                        })
                }
            });
        }

    }

    function appendError(id, html) {
        try {
            let el = $(document.getElementById(id));
            $(el).next(".text-danger").remove();
            $(html).insertAfter(el)
        } catch (e) {

        }
    }

})
