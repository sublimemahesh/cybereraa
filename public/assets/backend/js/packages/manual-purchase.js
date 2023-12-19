$(function () {

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

    try {
        document.getElementById('requestManualPurchase').addEventListener('click', sendRequest)
    } catch (e) {

    }

    function sendRequest(e) {
        e.preventDefault();
        let purchase_for_user_info = 'Yourself';
        try {
            let el = document.getElementById("purchase_for")
            purchase_for_user_info = el.options[el.selectedIndex].text
        } catch (e) {
        }
        let footer = purchase_for_user_info.length > 0 && 'Package Purchase for: ' + purchase_for_user_info;

        let transaction_id = $('#transaction_id').val();
        let proof_document = $('#proof_document').val();
        let purchase_for = $('#purchase_for').val()
        let package_slug = $('#package_slug').val()
        if (transaction_id === null || transaction_id.length <= 0) {
            Toast.fire({
                icon: 'error',
                title: "Please Enter Transaction ID!",
            })
            return false
        } else if (proof_document === null || proof_document.length <= 0) {
            Toast.fire({
                icon: 'error',
                title: "Please provide the payment slip / Screenshot!",
            })
            return false
        } else {
            Swal.fire({
                title: "Are You Sure?",
                text: "You want to purchase?. Please note this process cannot be reversed.",
                icon: "info",
                showCancelButton: true,
                footer: '<small style="color:green">' + footer + '</small>'
            }).then((request) => {
                if (request.isConfirmed) {
                    loader()
                    const _FORM = $('#manual-purchase-form')
                    _FORM.find(".text-danger").remove();
                    let formData = new FormData(_FORM[0]);
                    if (purchase_for !== null) {
                        formData.append('purchase_for', purchase_for)
                    }
                    formData.append('method', 'manual')
                    axios.post(`${APP_URL}/user/binancepay/order/create`, formData).then(response => {
                        Toast.fire({
                            icon: response.data.icon, title: response.data.message,
                        }).then(res => {
                            if (response.data.status) {
                                loader("Redirecting...")
                                setTimeout(() => {
                                    location.href = response.data.data.checkoutUrl
                                }, 200)
                            }
                        })
                    }).catch((error) => {
                        Toast.fire({
                            icon: 'error', title: error.response.data.message || "Something went wrong!",
                        })
                        console.error(error.response.data)
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

        function appendError(id, html) {
            try {
                let el = $(document.getElementById(id));
                $(el).next(".text-danger").remove();
                $(html).insertAfter(el)
            } catch (e) {

            }
        }

    }

})
