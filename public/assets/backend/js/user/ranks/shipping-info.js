$(function () {

    $(document).on('click', '#save', function (e) {
        e.preventDefault();
        let name = $('#name').val();
        let mobile_number = $('#mobile_number').val();
        let shirt_size = $('#shirt_size').val();
        let address = $('#address').val();
        let gift_id = parseInt($('#gift').val()) || 0;
        if (name === null || name.length <= 0) {
            Toast.fire({
                icon: 'error', title: "Please Enter your contact name!",
            })
            return false
        } else if (mobile_number === null || mobile_number.length <= 0) {
            Toast.fire({
                icon: 'error', title: "Please Enter your contact number!",
            })
            return false
        } else if (address === null || address.length <= 0) {
            Toast.fire({
                icon: 'error', title: "Please Enter your shipping address!",
            })
            return false
        } else {
            Swal.fire({
                title: "Are You Sure?",
                text: "Save shipping information.",
                icon: "info",
                showCancelButton: true,
            }).then((save) => {
                if (save.isConfirmed) {
                    loader()
                    let form = $('#shipping-form')[0]
                    let form_data = new FormData(form);

                    axios.post(location.href, form_data)
                        .then(response => {
                            Toast.fire({
                                icon: response.data.icon, title: response.data.message,
                            }).then(res => {
                                if (response.data.status) {
                                    response.data.redirectUrl ? location.href = response.data.redirectUrl : location.reload();
                                }
                            })
                        })
                        .catch(error => {
                            Toast.fire({
                                icon: 'error', title: error.response.data.message || "Something went wrong!",
                            })
                        })
                }
            });
        }
    })


})
