$(function () {

    try {
        $(document).on('click', ".reject-kyc", rejectKyc)
        // document.getElementById('reject-kyc').addEventListener('click', rejectKyc)
    } catch (e) {

    }

    async function rejectKyc(e) {
        e.preventDefault();
        // let repudiate_note = $('#repudiate_note').val();
        // let document = $('#document').val();
        let document = $(this).data('document');
        let kyc = $('#kyc').val();
        const {value: repudiate_note} = await Swal.fire({
            title: "Reject reason",
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

        if (repudiate_note === null || repudiate_note.length <= 0) {
            Toast.fire({
                icon: 'error',
                title: "Please provide the reject reason!",
            })
            return false
        } else {
            Swal.fire({
                title: "Are You Sure?",
                text: "Reject Kyc Document??. Please note this will informed the user via email.",
                html: `<div class="swal2-html-container mt-0 mb-2">Reject Kyc Document??. Please note, this will inform the user via email.</div> <span class="text-danger">Reason: ${repudiate_note}</span>`,
                icon: "info",
                showCancelButton: true,
                confirmButtonText: 'REJECT',
                confirmButtonColor: '#ee7070',
            }).then((reject) => {
                if (reject.isConfirmed) {
                    loader()
                    const _FORM = $('#reject-kyc-form')
                    _FORM.find(".text-danger").remove();
                    let formData = new FormData(_FORM[0]);
                    // formData.append(proof_document, proof_document)
                    axios.post(`${APP_URL}/admin/users/kyc-documents/${document}/status`, {
                        status: 'reject',
                        repudiate_note
                    }).then(response => {
                        $.get(location.href).then(function (page) {
                            $("#kyc-details-page").html(
                                $(page).find("#kyc-details-page").html()
                            );
                        });
                        Toast.fire({
                            icon: response.data.icon, title: response.data.message,
                        }).then(res => {
                            if (response.data.status) {
                                // location.href = APP_URL + '/admin/users/kycs/' + kyc;
                                // location.reload();
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
