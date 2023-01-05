$(function () {

    $(document).on('click', '#save-rank-package', function (e) {
        loader()
        e.preventDefault();

        let __form = $('#rank-package-form');

        __form.find(".text-danger").remove();
        let formData = __form.serialize();

        axios.patch(`${APP_URL}/admin/strategies/rank/package-requirements`, formData).then(response => {
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
            error.response.data.message &&
            appendError('save-rank-package', `<span class="text-danger">${error.response.data.message}</span>`)
        })
    })

    function appendError(id, html) {
        $(`#${id}`).next(".text-danger").remove();
        $(html).insertAfter(`#${id}`)
    }
})