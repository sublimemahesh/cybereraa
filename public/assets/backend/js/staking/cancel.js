$(function () {

    try {
        document.getElementById('cancel-request').addEventListener('click', cancelStaking)
    } catch (e) {

    }

    function cancelStaking(e) {
        e.preventDefault();
        let remark = $('#remark').val().trim();
        if (remark === null || remark.length <= 0) {
            Toast.fire({
                icon: 'error',
                title: "Please provide the cancel letter!",
            })
            return false
        } else {
            Swal.fire({
                title: "Are You Sure?",
                text: "Cancel The staking?. Please note this process may take several business days approve",
                icon: "info",
                showCancelButton: true,
            }).then((cancel) => {
                if (cancel.isConfirmed) {
                    loader()
                    const _FORM = $('#cancel-form')
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
