$(function () {

    let selectedPackageAmount = 0;

    $(document).ready(function () {
        $('.form-check-packages').change(function () {
            if (this.checked) {
                selectedPackageAmount += parseFloat($(this).data('amount'));
            } else {
                selectedPackageAmount -= parseFloat($(this).data('amount'));
            }
            $('#selected_package_amount').text(selectedPackageAmount.toFixed(2));
            if (selectedPackageAmount >= REQUIRED_PACKAGE_AMOUNT) {
                $('#req-status').html(`<div class="alert alert-success">
                                Required amount reached!
                            </div>`);
            } else {
                $('#req-status').html(`<div class="alert alert-warning">
                                ${(REQUIRED_PACKAGE_AMOUNT - selectedPackageAmount).toFixed(2)} Need to reech the requirement
                            </div>`);
            }
        });
    });

    $(document).on('click', '#issue', function (e) {
        e.preventDefault();

        // Assuming you have an array to store the checked ids
        let checkedPackageIds = [];

        let checkboxes = document.querySelectorAll('.form-check-packages');

        checkboxes.forEach(function (checkbox) {
            // Check if the checkbox is checked
            if (checkbox.checked) {
                // Add the checked checkbox value (package id) to the array
                checkedPackageIds.push(checkbox.value);
            }
        });

        console.log(checkedPackageIds);

        let bonus_id = parseInt($('#bonus').val()) || 0;
        if (bonus_id === 0 || bonus_id.length <= 0 || bonus_id !== parseInt(BONUS)) {
            Toast.fire({
                icon: 'error', title: "Something not right, Please reload the page and try again.",
            })
            return false
        } else if (checkedPackageIds.length <= 0 || selectedPackageAmount < REQUIRED_PACKAGE_AMOUNT) {
            Toast.fire({
                icon: 'error', title: "Please choose packages that need to reach the required amount!",
            })
            return false
        } else {
            Swal.fire({
                title: "Are You Sure?",
                text: "Issue the bonus for this user?. Please note this process cannot be reversed.",
                icon: "info",
                showCancelButton: true,
            }).then((issue) => {
                if (issue.isConfirmed) {
                    loader()
                    let form_data = new FormData($('#issue-bonus-form')[0]);

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
