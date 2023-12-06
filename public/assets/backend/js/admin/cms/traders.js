$(function () {
    if ($('#traders').length > 0) {
        const table = $('#traders').DataTable();
    }

    try {
        document.getElementById('create-trader').addEventListener('click', createTrader);
    } catch (e) {

    }
    try {
        document.getElementById('update-trader').addEventListener('click', updateTrader);
    } catch (e) {

    }

    // document.getElementById('trader-form').addEventListener('submit', createTrader)

    function createTrader(e) {
        e.preventDefault();
        loader()
        $('#trader-form').find(".text-danger").remove();
        let formData = $('#trader-form').serialize();
        axios.post(`${APP_URL}/admin/traders`, formData)
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
            let errorMap = ['name', 'amount', 'gas_fee', 'month_of_period', 'daily_leverage', 'is_active']
            errorMap.map(id => {
                error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
            })
        })

    }

    function updateTrader(e) {
        e.preventDefault();
        loader()
        $('#trader-form').find(".text-danger").remove();
        let formData = $('#trader-form').serialize();
        axios.patch(`${APP_URL}/admin/traders/${TRADER_ID}`, formData)
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
            let errorMap = ['name', 'amount', 'gas_fee', 'month_of_period', 'daily_leverage', 'is_active']
            errorMap.map(id => {
                error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
            })
        })

    }

    function appendError(id, html) {
        $(`#${id}`).next(".text-danger").remove();
        $(html).insertAfter(`#${id}`)
    }

    $(document).on("click", ".delete-trader", function (e) {
        e.preventDefault();
        __this = $(this);
        let trader_id = $(this).data("trader");
        Swal.fire({
            title: "Are You Sure?",
            text: "Are you want to delete this trader?",
            icon: "warning",
            showCancelButton: true,
        }).then((willDelete) => {
            if (willDelete.isConfirmed) {
                loader()
                axios.delete(`${APP_URL}/admin/traders/${trader_id}`)
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
