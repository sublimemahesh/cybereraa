$(function () {
    const payMethodChooseModal = new bootstrap.Modal('#pay-method-modal', {
        backdrop: 'static',
    })

    // BIND event for only valid packages base on the package
    ALLOWED_PACKAGES.map(package_slug => {
        let element = `#${package_slug}-choose`;
        let wallet_method_element = `#wallet-${package_slug}`;
        let binancepay_method_element = `#binance-pay-${package_slug}`;

        $(document).on("click", element, function (e) {
            e.preventDefault();
            $(".pay-method-wallet").attr('id', `wallet-${package_slug}`)
            $(".pay-method-binance-pay").attr('id', `binance-pay-${package_slug}`)
            payMethodChooseModal.show();
        });

        $(document).on('click', wallet_method_element, function () {
            generateInvoice("wallet", package_slug)
        });

        $(document).on('click', binancepay_method_element, function () {
            generateInvoice("binance-pay", package_slug)
        });
    })

    document.getElementById('pay-method-modal').addEventListener('hidden.bs.modal', event => {
        $(".pay-method-wallet").attr('id', 'wallet')
        $(".pay-method-binance-pay").attr('id', 'binance-pay')
    })

    function generateInvoice(payMethod, package_slug) {
        loader()
        axios.post(`${APP_URL}/user/binancepay/order/create`, {
            method: payMethod,
            package: package_slug
        }).then(response => {
            Swal.fire({
                icon: response.data.icon, text: response.data.message,
            })
            if (response.data.status) {
                loader("Redirecting...")
                setTimeout(() => {
                    location.href = response.data.data.checkoutUrl
                }, 200)
            }
        }).catch(error => {
            let error_msg = error.response.data.message || "Something went wrong!"
            Swal.fire({
                icon: "error",
                text: 'Something went wrong!',
                confirmButtonColor: '#4466f2',
                footer: '<small style="color:red">' + error_msg + '</small>'
            });
        })

    }


    function loader(text = "It may take some time...!") {
        Swal.fire({
            title: "Please wait...!",
            text,
            imageUrl: APP_URL + "/assets/images/loader.svg",
            showConfirmButton: false,
            allowOutsideClick: false,
        });
    }
})