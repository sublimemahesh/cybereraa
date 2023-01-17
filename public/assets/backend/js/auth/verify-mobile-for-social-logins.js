$(function () {
    let itl = intlTelInput.intlTelInput(document.querySelector("#phone"), {
        onlyCountries: ["LK"],
        allowDropdown: false,
        initialCountry: "LK",
        customContainer: "int-phone",
        separateDialCode: true,
    })
    let regex = /^\+94\d{9}$/;
    let phone;
    if (document.getElementById("send-verify-phone")) {
        document
            .getElementById("send-verify-phone")
            .addEventListener("click", function (e) {
                phone = itl.getNumber(intlTelInputUtils.numberFormat.E164);
                e.preventDefault();
                if (!phone.trim()) {
                    let el = `<div class="col-sm-12 alert alert-danger">
                                <ul class="mb-0"> 
                                   <li> The phone field is required. </li>   
                                </ul>
                            </div>`;
                    appendError(el, "#mobile-verify-form");
                } else if (!regex.test(phone) || !itl.isValidNumber()) {
                    let errorCode = itl.getValidationError();
                    itl.setCountry("lk");
                    // itl.setNumber("");
                    let el = `<div class="col-sm-12 alert alert-danger">
                                <ul class="mb-0"> 
                                   <li> ${intlTelInput.errorMap[errorCode]} </li>   
                                </ul>
                            </div>`;
                    appendError(el, "#mobile-verify-form");
                } else {
                    appendError("", "#mobile-verify-form");
                    // document.getElementById("loader-ajax").style.display = "block";
                    loader()
                    axios
                        .post(APP_URL + "/verify/mobile/send-verify-code", {
                            phone,
                            terms: document.getElementById("terms") ? document.getElementById("terms").checked : "no",
                        })
                        .then(function (response) {
                            // document.getElementById('loader-ajax').style.display = 'none'
                            Swal.close()
                            if (response.data.sent_verify_code) {
                                document.getElementById("mobile-verify-form").innerHTML = `
                                        <div class="form-group">
                                           <label for="" class="info-title"> Mobile Number <span>*</span> </label>
                                           <input type="text" disabled class="form-control unicase-form-control text-input" value="${phone}">
                                        </div>
                                        <div class="form-group">
                                           <label for="verify-pin" class="info-title"> Enter Verification PIN sent to your Phone number <span>*</span> </label>
                                           <input type="number" id="verify-pin" name="verify-pin" class="form-control unicase-form-control text-input" placeholder="xxxxxx">
                                        </div>
                                        <div class="radio outer-xs mt-4">
                                           Did not Receive PIN ? 
                                           <a class="underline text-sm text-gray-600 hover:text-gray-900" href="${location.href}">
                                              Resend PIN
                                           </a> 
                                           <div class="d-flex items-center justify-end mt-4">
                                              <button class="btn-upper btn btn-primary checkout-page-button" id="verify-mobile"> Verify Mobile </button>
                                           </div>
                                        </div>`;
                            }
                        })
                        .catch(function (error) {
                            Swal.close()
                            //   document.getElementById("loader-ajax").style.display = "none";
                            if (typeof error.response.data.errors != "undefined") {
                                let errors = error.response.data.errors;
                                let el = `<div class="col-sm-12 alert alert-danger">
                                <ul class="mb-0"> 
                                   ${errors.phone ? `<li> ${errors.phone} </li>` : ""} 
                                   ${errors.terms ? `<li> ${errors.terms} </li>` : ""}
                                </ul>
                            </div>`;
                                appendError(el, "#mobile-verify-form");
                            }
                        });
                }
            });
    }

    function appendError(html, element) {
        if ($(element + " .alert-danger").length) {
            $(element + " .alert-danger").remove();
        }
        $(element).prepend(html);
    }

    $(document).on("click", "#verify-mobile", function (e) {
        e.preventDefault();
        let verify_code = $("#verify-pin").val();
        if (!verify_code.trim().length) {
            Swal.fire({
                icon: "error", title: "Required", text: "Please enter valid PIN", showConfirmButton: false, timer: 1500,
            });
        } else {
            loader()
            axios
                .post(APP_URL + "/verify/mobile", {
                    phone, verify_code,
                })
                .then(function (response) {
                    // document.getElementById('loader-ajax').style.display = 'none'
                    if (response.data.verify_code) {
                        location.href = response.data.redirect;
                    } else {
                        Swal.close()
                        appendError("Verification code is invalid", "#mobile-verify-form");
                    }
                })
                .catch(function (error) {
                    Swal.close()
                    //   document.getElementById("loader-ajax").style.display = "none";
                    if (typeof error.response.data.errors != "undefined") {
                        let errors = error.response.data.errors;
                        let el = `<div class="col-sm-12 alert alert-danger">
                                    <ul class="mb-0"> 
                                       ${errors.phone ? `<li> ${errors.phone} </li>` : ""} 
                                       ${errors.terms ? `<li> ${errors.terms} </li>` : ""}
                                    </ul>
                                </div>`;
                        appendError(el, "#mobile-verify-form");
                    }
                });
        }
    });
});
