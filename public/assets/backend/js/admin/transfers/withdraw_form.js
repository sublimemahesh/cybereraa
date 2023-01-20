$(function () {

    try {
        document.getElementById('create-withdraw-form').addEventListener('click', createWithdraw)
    } catch (e) {

    }

    function createWithdraw(e) {
        e.preventDefault();
        loader()
        $('#withdraw-form').find(".text-danger").remove();
        let formData = $('#withdraw-form').serialize();
        axios.post(`${APP_URL}/admin/user/transfers`, formData)
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
            let errorMap = ['amount', 'proof']
            errorMap.map(id => {
                error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
            })
        })

    }

})
