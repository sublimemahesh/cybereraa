$(document).ready(function () {

    $(".withdrawal_limits").keyup(function () {
        let packages = parseInt($("#withdrawal_limits_package").val()) || 0;
        let commission = parseInt($("#withdrawal_limits_commission").val()) || 0;
        let max_withdraw_limit = packages + commission;
        $("#max_withdraw_limit").val(max_withdraw_limit);
    });

    $(document).on('click', '#save-withdraw-strategies', function (e) {
        loader()
        e.preventDefault();

        let __form = $('#withdraw-strategies-form');

        __form.find(".text-danger").remove();
        let formData = __form.serialize();

        axios.patch(`${APP_URL}/admin/strategies/withdrawal`, formData)
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
            let errorMap = ['withdrawal_limits_package', 'withdrawal_limits_commission', 'max_withdraw_limit', 'minimum_payout_limit', 'daily_max_withdrawal_limits', 'withdrawal_days_of_week']
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
