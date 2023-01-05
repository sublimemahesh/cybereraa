$(function () {

    $(document).on('click', '#save-payable-percentage', function (e) {
        loader()
        e.preventDefault();

        let __form = $('#payable-percentage-form');

        __form.find(".text-danger").remove();
        let formData = __form.serialize();

        axios.patch(`${APP_URL}/admin/strategies/daily-leverages`, formData).then(response => {
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
            let errorMap = ['direct', 'indirect', 'rank_bonus']
            errorMap.map(id => {
                error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
            })
        })
    })

    function appendError(id, html) {
        $(`#${id}`).next(".text-danger").remove();
        $(html).insertAfter(`#${id}`)
    }
})