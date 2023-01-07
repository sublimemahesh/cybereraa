$(function () {
    if ($('#currencies').length > 0) {
        const table = $('#currencies').DataTable({
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            }
        });
    }

    try {
        document.getElementById('create-currency').addEventListener('click', saveCurrency)
    } catch (e) {

    }
    try {
        document.getElementById('update-currency').addEventListener('click', updateCurrency)
    } catch (e) {

    }

    // document.getElementById('currency-form').addEventListener('submit', saveCurrency)

    function saveCurrency(e) {
        e.preventDefault();
        loader()
        $('#currency-form').find(".text-danger").remove();
        let formData = $('#currency-form').serialize();
        axios.post(`${APP_URL}/admin/currencies`, formData)
            .then(response => {
                Toast.fire({
                    icon: response.data.icon, title: response.data.message,
                }).then(res => {
                    if (response.data.status) {
                        location.reload();
                    }
                })
            }).catch((error) => {
            Toast.fire({
                icon: 'error', title: error.response.data.message || "Something went wrong!",
            })
            console.error(error.response.data)
            let errorMap = ['name', 'iso']
            errorMap.map(id => {
                error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
            })
        })

    }

    function updateCurrency(e) {
        e.preventDefault();
        loader()
        $('#currency-form').find(".text-danger").remove();
        let formData = $('#currency-form').serialize();
        axios.patch(`${APP_URL}/admin/currencies/${CURRENCY_ID}`, formData)
            .then(response => {
                Toast.fire({
                    icon: response.data.icon, title: response.data.message,
                }).then(res => {
                    if (response.data.status) {
                        location.reload();
                    }
                })
            }).catch((error) => {
            Toast.fire({
                icon: 'error', title: error.response.data.message || "Something went wrong!",
            })
            console.error(error.response.data)
            let errorMap = ['name', 'iso']
            errorMap.map(id => {
                error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
            })
        })

    }

    function appendError(id, html) {
        $(`#${id}`).next(".text-danger").remove();
        $(html).insertAfter(`#${id}`)
    }

    $(document).on("click", ".delete-currency", function (e) {
        e.preventDefault();
        __this = $(this);
        let currency_id = $(this).data("currency");
        Swal.fire({
            title: "Are You Sure?",
            text: "Are you want to delete this currency?",
            icon: "warning",
            showCancelButton: true,
        }).then((willDelete) => {
            if (willDelete.isConfirmed) {
                loader()
                axios.delete(`${APP_URL}/admin/currencies/${currency_id}`)
                    .then(response => {
                        Toast.fire({
                            icon: response.data.icon, title: response.data.message,
                        }).then(res => {
                            if (response.data.status) {
                                location.reload();
                            }
                        })
                    }).catch((error) => {
                    Toast.fire({
                        icon: 'error', title: error.response.data.message || "Something went wrong!",
                    })
                    console.error(error.response.data)
                })
            }
        });
    });
})
