$(document).ready(function () {

    $(document).on('click', '#save-transaction-strategies', function (e) {
        loader()
        e.preventDefault();

        let __form = $('#transaction-strategies-form');

        __form.find(".text-danger").remove();
        let formData = __form.serialize();

        axios.patch(`${APP_URL}/admin/strategies/withdrawal/fees`, formData).then(response => {
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
            let errorMap = ['payout_transfer_fee', 'p2p_transfer_fee']
            errorMap.map(id => {
                error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
            })
        })
    })

    function appendError(id, html) {
        $(`#${id}`).next(".text-danger").remove();
        $(html).insertAfter(`#${id}`)
    }
});
