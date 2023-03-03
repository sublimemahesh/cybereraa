$(document).ready(function () {

    $(document).on('click', '#save-rank-level', function (e) {
        loader()
        e.preventDefault();

        let __form = $('#rank-level-form');

        __form.find(".text-danger").remove();
        let formData = __form.serialize();

        axios.patch(`${APP_URL}/admin/strategies/rank/levels`, formData).then(response => {
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
            let errorMap = ['rank_level_count', 'rank_offset_levels', 'rank_bonus_levels']
            errorMap.map(id => {
                error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
            })
        })
    })

    function appendError(id, html) {
        $(`#${id}`).next(".text-danger").remove();
        $(html).insertAfter(`#${id}`)
    }

    $("#rank_offset_levels").change(function () {

        let __rank_level_count = $('#rank_level_count');
        let __rank_gift_level_count = $('#rank_offset_levels');
        let __rank_bonus_level_count = $('#rank_bonus_levels');

        let rank_level_count_val = parseInt(__rank_level_count.val()) || 0;
        let rank_gift_level_count_val = parseInt(__rank_gift_level_count.val()) || 0;
        let rank_bonus_level_count_val = parseInt(__rank_bonus_level_count.val()) || 0;

        let total_levels = rank_gift_level_count_val + rank_bonus_level_count_val

        if (rank_gift_level_count_val <= 0) {
            rank_gift_level_count_val = 1;
            __rank_gift_level_count.val(1)
        }

        if (total_levels > rank_level_count_val) {
            rank_bonus_level_count_val = rank_level_count_val - rank_gift_level_count_val;
            if (rank_bonus_level_count_val <= 0) {
                __rank_gift_level_count.val(2)
                __rank_bonus_level_count.val(5)
            } else {
                __rank_bonus_level_count.val(rank_bonus_level_count_val)
            }
        }

        if (total_levels < rank_level_count_val) {
            rank_bonus_level_count_val += rank_level_count_val - total_levels;
            __rank_bonus_level_count.val(rank_bonus_level_count_val)
        }

        let rank_level_offset = parseInt($("#rank_offset_levels").val()) || 0;
        let html = '';
        for (let i = (rank_level_offset + 1); i <= rank_level_count_val; i++) {
            html += `<div class="form-group row mb-2">
                                <label class="col-sm-3 col-form-label" for="rank_package_requirement_${i}" >Rank ${i}</label>
                                <div class="col-sm-9">
                                    <input class="form-control" id="rank_package_requirement_${i}" name="rank_package_requirement[${i}]" placeholder="" type="text">
                                </div>
                            </div>`;
        }
        $('#package-requirement-inputs').html(html);
    });
});
