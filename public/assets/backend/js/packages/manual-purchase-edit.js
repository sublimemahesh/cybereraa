$(function () {

    try {
        document.getElementById('updateTransaction').addEventListener('click', sendRequest)
    } catch (e) {

    }

    function sendRequest(e) {
        e.preventDefault();

        let footer = 'Package Purchase for Yourself';

        let custom_deposit_amount = $('#custom-deposit-amount').val();
        let transaction_id = $('#transaction_id').val();
        // let proof_document = $('#proof_document').val();

        if (custom_deposit_amount === null || custom_deposit_amount.length <= 0) {
            Toast.fire({
                icon: 'error',
                title: "Please Enter the amount!",
            });
            return false
        } else if (transaction_id === null || transaction_id.length <= 0) {
            Toast.fire({
                icon: 'error',
                title: "Please Enter Transaction ID!",
            })
            return false
        }
        /*else if (proof_document === null || proof_document.length <= 0) {
            Toast.fire({
                icon: 'error',
                title: "Please provide the payment slip / Screenshot!",
            })
            return false
        } */
        else {
            Swal.fire({
                title: "Are You Sure?",
                text: "Are You want to update this transaction?. Please note this process cannot be reversed.",
                icon: "info",
                showCancelButton: true,
                footer: '<small style="color:green">' + footer + '</small>'
            }).then((request) => {
                if (request.isConfirmed) {
                    loader()
                    const _FORM = $('#manual-purchase-edit-form')
                    _FORM.find(".text-danger").remove();
                    let formData = new FormData(_FORM[0]);

                    axios.post(location.href, formData).then(response => {
                        Toast.fire({
                            icon: response.data.icon, title: response.data.message,
                        }).then(res => {
                        })
                        if (response.data.status) {
                            loader("Redirecting...")
                            setTimeout(() => {
                                location.href = response.data.data.checkoutUrl
                            }, 200)
                        }
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
