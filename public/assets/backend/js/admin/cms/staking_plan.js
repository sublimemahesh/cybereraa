$(function () {
    if ($('#packages').length > 0) {
        const table = $('#packages').DataTable({
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            }
        });
    }

    try {
        document.getElementById('create-package').addEventListener('click', createPackage)
    } catch (e) {

    }
    try {
        document.getElementById('update-package').addEventListener('click', updatePackage)
    } catch (e) {

    }

    // document.getElementById('package-form').addEventListener('submit', createPackage)

    function createPackage(e) {
        e.preventDefault();
        loader()
        $('#package-form').find(".text-danger").remove();
        let formData = $('#package-form').serialize();
        axios.post(`${APP_URL}/admin/staking-packages/${PACKAGE_ID}/plans`, formData)
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
            let errorMap = ['name', 'duration', 'interest_rate', 'is_active']
            errorMap.map(id => {
                error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
            })
        })

    }


    function updatePackage(e) {
        e.preventDefault();
        loader()
        $('#package-form').find(".text-danger").remove();
        let formData = $('#package-form').serialize();
        axios.patch(`${APP_URL}/admin/plans/${PLAN_ID}`, formData)
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
            let errorMap = ['name', 'duration', 'interest_rate', 'is_active']
            errorMap.map(id => {
                error.response.data.errors[id] && appendError(id, `<span class="text-danger">${error.response.data.errors[id]}</span>`)
            })
        })

    }

    function appendError(id, html) {
        $(`#${id}`).next(".text-danger").remove();
        $(html).insertAfter(`#${id}`)
    }

    $(document).on("click", ".delete-package", function (e) {
        e.preventDefault();
        __this = $(this);
        let package_id = $(this).data("package");
        Swal.fire({
            title: "Are You Sure?",
            text: "Are you want to delete this package?",
            icon: "warning",
            showCancelButton: true,
        }).then((willDelete) => {
            if (willDelete.isConfirmed) {
                loader()
                axios.delete(`${APP_URL}/admin/plans/${package_id}`)
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
                })
            }
        });
    });
})
