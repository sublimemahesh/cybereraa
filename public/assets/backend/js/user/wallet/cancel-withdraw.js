$(function () {

    try {
        document.getElementById('cancel-payout').addEventListener('click', cancelWithdraw)
    } catch (e) {

    }

    function cancelWithdraw(e) {
        e.preventDefault();
        let repudiate_note = $('#repudiate_note').val();
        if (repudiate_note === null || repudiate_note.length <= 0) {
            Toast.fire({
                icon: 'error',
                title: "Please provide the cancel reason!",
            })
            return false
        } else {
            Swal.fire({
                title: "Are You Sure?",
                text: "Cancel The payout?. Please note this process cannot be reversed.",
                icon: "info",
                showCancelButton: true,
            }).then((cancel) => {
                if (cancel.isConfirmed) {
                    loader()
                    const _FORM = $('#cancel-withdrawal-form')
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
                            let errorMap = [];
                            document.querySelectorAll('input[data-input=payout]').forEach(input => {
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

    }

})
