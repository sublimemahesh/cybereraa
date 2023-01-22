$(function () {

    $(document).on('click', '#issue', function (e) {
        e.preventDefault();
        let gift_image = $('#issued-gift').val();
        let gift_id = parseInt($('#gift').val()) || 0;
        if (gift_id === 0 || gift_id.length <= 0 || gift_id !== parseInt(GIFT)) {
            Toast.fire({
                icon: 'error', title: "Something not right, Please reload the page and try again.",
            })
            return false
        } else if (gift_image === null || gift_image.length <= 0) {
            Toast.fire({
                icon: 'error', title: "Please provide the gift image that was issued for this rank!",
            })
            return false
        } else {
            Swal.fire({
                title: "Are You Sure?",
                text: "Issue the gift for this rank?. Please note this process cannot be reversed.",
                icon: "info",
                showCancelButton: true,
            }).then((issue) => {
                if (issue.isConfirmed) {
                    loader()
                    let form = $('#issue-gift-form')[0]
                    let form_data = new FormData(form);

                    axios.post(location.href, form_data).then(response => {
                        Toast.fire({
                            icon: response.data.icon, title: response.data.message,
                        }).then(res => {
                            if (response.data.status) {
                                response.data.redirectUrl ? location.href = response.data.redirectUrl : location.reload();
                            }
                        })
                    }).catch(error => {
                        Toast.fire({
                            icon: 'error', title: error.response.data.message || "Something went wrong!",
                        })
                    })
                }
            });
        }
    })


})
