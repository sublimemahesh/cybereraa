$(function () {

    try {
        document.getElementById('approveRequest').addEventListener('click', confirm)
    } catch (e) {

    }

    function confirm(e) {
        e.preventDefault();
        let password = $('#password').val();
        if (password === null || password.length <= 0) {
            Toast.fire({
                icon: 'error',
                title: "Please provide Your Password!",
            })
            return false
        } else {
            Swal.fire({
                title: "Are You Sure?",
                text: "Confirm The topup request?. Please note this process cannot be reversed.",
                icon: "info",
                showCancelButton: true,
            }).then((confirm) => {
                if (confirm.isConfirmed) {
                    loader()
                    const _FORM = $('#approval-form')
                    _FORM.find(".text-danger").remove();
                    let formData = new FormData(_FORM[0]);
                    // formData.append(proof_document, proof_document)
                    axios.post(location.href, formData)
                        .then(response => {
                            Toast.fire({
                                icon: response.data.icon, title: response.data.message,
                            }).then(res => {
                                if (response.data.status) {
                                    response.data.redirectUrl ? location.href = response.data.redirectUrl : location.reload();
                                }
                            })
                        })
                        .catch((error) => {
                            Toast.fire({
                                icon: 'error', title: error.response.data.message || "Something went wrong!",
                            })
                            console.error(error.response.data)
                            if (error.response.data.errors) {
                                let errorMap = [];
                                document.querySelectorAll('input[data-input=payout]').forEach(input => {
                                    errorMap.push(input.id)
                                })
                                errorMap.map(id => {
                                    error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
                                })
                            }
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
