$(function () {

    try {
        // document.getElementById('reject-trx').addEventListener('click', rejectTrx)
        $(document).on('click', '#reject-trx', rejectTrx);
    } catch (e) {

    }

    async function rejectTrx(e) {
        e.preventDefault();
        // let repudiate_note = $('#repudiate_note').val();

        const {value: repudiate_note} = await Swal.fire({
            title: "Reject Transaction",
            html: `<div>
                        <p>Please Select the reason for rejection.</p>
                    </div> `,
            input: "select",
            inputOptions: REJECT_REASONS,
            inputPlaceholder: "Select a reject reason",
            showCancelButton: true,
            inputValidator: (value) => {
                return new Promise((resolve) => {
                    if (value === null || value.length <= 0) {
                        resolve("Please provide the reject reason!");
                    }
                    resolve();
                });
            }
        });

        if (repudiate_note === null) {
            Toast.fire({
                icon: 'error',
                title: "Please provide the reject reason!",
            })
            return false
        } else {
            Swal.fire({
                title: "Are You Sure?",
                text: "Reject The payout?. Please note this process cannot be reversed.",
                html: `<div class="swal2-html-container mt-0 mb-2">Reject The Transaction?. Please note this process cannot be reversed.</div> <span class="text-danger">Reason: ${repudiate_note}</span>`,
                icon: "info",
                confirmButtonText: 'REJECT',
                confirmButtonColor: '#ee7070',
                showCancelButton: true,
            }).then((reject) => {
                if (reject.isConfirmed) {
                    loader()
                    const _FORM = $('#approval-form')
                    _FORM.find(".text-danger").remove();
                    let formData = new FormData(_FORM[0]);
                    formData.set('repudiate_note', repudiate_note)
                    // formData.append(proof_document, proof_document)
                    axios.post(transaction_reject_url, formData)
                        .then(response => {
                            Toast.fire({
                                icon: response.data.icon, title: response.data.message,
                            }).then(res => {
                            })
                            if (response.data.status) {
                                // response.data.redirectUrl ? location.href = response.data.redirectUrl : location.reload();
                                TRANSACTION_TABLE.ajax.reload();
                                TRANSACTION_MODAL.hide()
                            }
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
