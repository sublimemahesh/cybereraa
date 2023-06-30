$(function () {

    $(document).on('click', '#confirm-topup', function (e) {
        e.preventDefault();
        let amount = $('#transfer-amount').val();
        let proof_documentation = $('#proof-documentation').val();

        if (amount === null || amount.length <= 0) {
            Toast.fire({
                icon: 'error', title: "Topup amount is required!",
            })
            return false
        } else if (proof_documentation === null || proof_documentation.length <= 0) {
            Toast.fire({
                icon: 'error', title: "Please provide proof documentation of the receive fund!",
            })
            return false
        } else {
            Swal.fire({
                title: "Are You Sure?",
                text: "Request top up amount?",
                icon: "info",
                showCancelButton: true,
            }).then((request) => {
                if (request.isConfirmed) {
                    loader()

                    let form = $('#topup-form')[0]
                    let form_data = new FormData(form);

                    axios.post(location.href, form_data).then(response => {
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
                            errorMap.push(input.id)
                        })
                        errorMap.map(id => {
                            error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
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
    })
})
