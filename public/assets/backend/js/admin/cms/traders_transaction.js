$(function () {
    if ($('#traders_transactions').length > 0) {
        const table = $('#traders_transactions').DataTable();
    }

    try {
        document.getElementById('create-transaction').addEventListener('click', createTransaction);
    } catch (e) {

    }
    try {
        document.getElementById('update-transaction').addEventListener('click', updateTransaction);
    } catch (e) {

    }

    // document.getElementById('transaction-form').addEventListener('submit', createTransaction)

    function createTransaction(e) {
        e.preventDefault();
        loader()
        $('#transaction-form').find(".text-danger").remove();
        let formData = $('#transaction-form').serialize();
        axios.post(`${APP_URL}/admin/traders/${TRADER_ID}/transactions`, formData)
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
            let errorMap = ['out_usdt', 'usdt_out_time', 'in_usdt', 'usdt_in_time', 'reference']
            errorMap.map(id => {
                error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
            })
        })

    }

    function updateTransaction(e) {
        e.preventDefault();
        loader()
        $('#transaction-form').find(".text-danger").remove();
        let formData = $('#transaction-form').serialize();
        axios.patch(`${APP_URL}/admin/transactions/${TRANSACTION_ID}`, formData)
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
            let errorMap = ['out_usdt', 'usdt_out_time', 'in_usdt', 'usdt_in_time', 'reference']
            errorMap.map(id => {
                error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
            })
        })

    }

    function appendError(id, html) {
        $(`#${id}`).next(".text-danger").remove();
        $(html).insertAfter(`#${id}`)
    }

    $(document).on("click", ".delete-transaction", function (e) {
        e.preventDefault();
        __this = $(this);
        let transaction_id = $(this).data("transaction");
        Swal.fire({
            title: "Are You Sure?",
            text: "Are you want to delete this transaction?",
            icon: "warning",
            showCancelButton: true,
        }).then((willDelete) => {
            if (willDelete.isConfirmed) {
                loader()
                axios.delete(`${APP_URL}/admin/transactions/${transaction_id}`)
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
