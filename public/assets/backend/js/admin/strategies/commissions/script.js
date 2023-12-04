let count = 0;
$(document).ready(function () {

    $(document).on('click', '#save-commissions', function (e) {
        loader()
        e.preventDefault();

        let __form = $('#commissions-form');

        __form.find(".text-danger").remove();
        let formData = __form.serialize();

        axios.patch(`${APP_URL}/admin/strategies/commissions`, formData).then(response => {
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
            let errorMap = ['rank_gift', 'rank_bonus', 'commission_level_count']
            document.querySelectorAll('input[data-input=commissions]').forEach(input => {
                errorMap.push(input.id)
            })
            errorMap.map(id => {
                error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
            })
        })
    })

    $(document).on('change', '#commission_level_count', function (e) {
        let __this = $(this)
        let commission_level_count = __this.val()

        $('#level-commission-inputs').empty()
        for (let i = 1; i <= commission_level_count; i++) {
            let label = '';
            if (i === 1) {
                label = `<label class="col-sm-3 col-form-label" for="commissions.${i}">Direct Commissions (Lvl ${i})</label>`
            } else {
                label = `<label class="col-sm-3 col-form-label" for="commissions.${i}">Indirect Commissions (Lvl ${i})</label>`
            }
            let html = `<div class="form-group row mb-2" id="commissions-level-${i}">
                ${label}
                <div class="col-sm-9">
                    <input class="form-control" data-input="commissions" id="commissions.${i}" name="commissions[${i}]" placeholder="Commissions" type="text">
                </div>
            </div>`
            $('#level-commission-inputs').append(html)
        }
        updateSum()
    })

    $(document).on('change', 'input[data-input=commissions]', updateSum)
    updateSum()

    function updateSum() {
        let total_percentage = 0;
        let inputElements = document.querySelectorAll('input[data-input=commissions]');

        inputElements.forEach(input => total_percentage += (parseFloat(input.value) || 0))
        $('#total-percentage').html(total_percentage)
        console.log(total_percentage)
    }

    function appendError(id, html) {
        try {
            let el = $(document.getElementById(id));
            $(el).next(".text-danger").remove();
            $(html).insertAfter(el)
        } catch (e) {

        }
    }
});







