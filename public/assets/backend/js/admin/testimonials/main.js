$(function () {
    let testimonial_table = null;
    if ($("#testimonial-table").length) {
        testimonial_table = $("#testimonial-table").DataTable({
            language: {
                paginate: {
                    next: '<i class="fa fa-angle-double-right" aria-hidden="true"></i>',
                    previous: '<i class="fa fa-angle-double-left" aria-hidden="true"></i>'
                }
            },
        });
    }

    $(document).on("click", ".delete-testimonial", function (e) {
        e.preventDefault();
        let __this = $(this);
        let testimonial = $(this).data("testimonial");
        Swal.fire({
            title: "Are You Sure?",
            text: "Are you want to delete this testimonial?",
            icon: "warning",
            showCancelButton: true,
        }).then((willDelete) => {
            if (willDelete.isConfirmed) {
                axios.delete(`${APP_URL}/admin/testimonials/${testimonial}`).then(response => {
                    Toast.fire({
                        icon: response.data.icon, title: response.data.message,
                    })
                    if (response.data.status) {
                        testimonial_table
                            .rows("#testimonial-record-" + testimonial)
                            .remove()
                            .draw();
                    }
                }).catch((error) => {
                    Toast.fire({
                        icon: 'error', title: error.response.data.message || "Something went wrong!",
                    })
                })
            }
        });
    });

});
