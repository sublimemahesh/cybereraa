$(function () {
    if ($('#currencies').length > 0) {
        const table = $('#currencies').DataTable({
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            }
        });
    }

    try {
        document.getElementById('create-currency').addEventListener('click', saveCurrency)
    } catch (e) {

    }
    try {
        document.getElementById('update-currency').addEventListener('click', updateCurrency)
    } catch (e) {

    }

    // document.getElementById('currency-form').addEventListener('submit', saveCurrency)

    function saveCurrency(e) {

        e.preventDefault();

        loader()
        let __el = $('#currency-form');
        __el.find(".text-danger").remove();

        if ($("#name").val().length <= 0) {
            Toast.fire({
                icon: 'error', title: "Name is required",
            })
        } else if ($("#value").val().length <= 0) {
            Toast.fire({
                icon: 'error', title: "Value is required",
            })
        } else if ($("#change").val().length <= 0) {
            Toast.fire({
                icon: 'error', title: "Change is required",
            })
        } else if ($("#image_data").val().length <= 0) {
            Toast.fire({
                icon: 'error', title: "Image is required",
            })
        } else {

            let image_name = $('#image_data').val();
            let name = $('#name').val()
            let value = $('#value').val()
            let change = $('#change').val()

            axios.post(`${APP_URL}/admin/currencies`, {
                image_name, name, value, change
            }).then(response => {
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
                let errorMap = ['name', 'value', 'change', 'image_name']
                errorMap.map(id => {
                    error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
                })
            })

        }
    }

    function updateCurrency(e) {
        e.preventDefault();
        loader()
        let __el = $('#currency-form');
        __el.find(".text-danger").remove();

        let image_name = $('#image_data').val();
        let name = $('#name').val()
        let value = $('#value').val()
        let change = $('#change').val()

        axios.patch(`${APP_URL}/admin/currencies/${CURRENCY_ID}`, {
            image_name, name, value, change
        }).then(response => {
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
            let errorMap = ['name', 'value', 'change', 'image_name']
            errorMap.map(id => {
                error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
            })
        })

    }

    function appendError(id, html) {
        $(`#${id}`).next(".text-danger").remove();
        $(html).insertAfter(`#${id}`)
    }

    $(document).on("click", ".delete-currency", function (e) {
        e.preventDefault();
        let __this = $(this);
        let currency_id = $(this).data("currency");
        Swal.fire({
            title: "Are You Sure?",
            text: "Are you want to delete this currency?",
            icon: "warning",
            showCancelButton: true,
        }).then((willDelete) => {
            if (willDelete.isConfirmed) {
                loader()
                axios.delete(`${APP_URL}/admin/currencies/${currency_id}`).then(response => {
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


    $("#image_name").change(function () {
        let __this = $(this)
        canvasResize(this.files[0], {
            width: 600, height: 600, crop: false, quality: 80, //rotate: 90,
            callback: function (data, width, height) {
                __this.val(null)
                $('#image_data').val(data)
                $('.preview-image').remove()
                let htmlPreview = '<img class="preview-image img-thumbnail mt-2 preview-image w-25" alt="preview-image" src="' + data + '" />';
                $(htmlPreview).insertAfter(__this)
            }
        });
    });
})
