$(function () {

    // Use this method to overcome dom manipulation
    const REQUIRED_DOCUMENTS_TYPES = {
        nic: ['front', 'back', 'other'], driving_lc: ['front', 'other'], passport: ['front', 'other']
    }


    $(document).on("click", '#saveKYC', function (e) {
        e.preventDefault()
        let kyc = $(this).data("kyc");

        if ($('#' + KYC_PROFILE).val().length <= 0) {
            Toast.fire({
                icon: 'error', title: "Please provide your document information.",
            })
        } else {
            let data = {
                kyc_id: kyc,
                [KYC_TYPE]: $('#' + KYC_PROFILE).val(),
                documents: {...REQUIRED_DOCUMENTS_TYPES[KYC_TYPE].reduce((ac, a) => ({...ac, [a]: null}), {})}
            };

            Swal.fire({
                title: "Please wait...!",
                text: "It may take some time...!",
                imageUrl: APP_URL + "/assets/images/loader.svg",
                showConfirmButton: false,
                allowOutsideClick: false,
            });
            console.log('loop start')
            let errors = [];
            for (let i = 0; i < REQUIRED_DOCUMENTS_TYPES[KYC_TYPE].length; i++) {
                let doc_type = REQUIRED_DOCUMENTS_TYPES[KYC_TYPE][i];
                let element_id = `#${doc_type}`;
                let element__current_value = $(`#${doc_type}-has-document`).val();

                if (element__current_value && element__current_value.length > 0 && ($(element_id).val() || $(element_id).val().length <= 0)) {
                    delete data.documents[doc_type];
                    continue;
                }

                console.log(doc_type)
                if (!$(element_id).val() || $(element_id).val().length <= 0) {
                    console.log(element_id)
                    Toast.fire({
                        icon: 'error', title: "KYC proof document is required",
                    })
                    errors.push(element_id)
                    break;
                } else {
                    data.documents[doc_type] = {
                        id: $(`#${KYC_TYPE}-${doc_type}-id`).val(),
                        old_document: element__current_value,
                        document_file: $(element_id).val()
                    }
                }
            }
            console.log('loop end, axios start')
            if (errors.length <= 0) {
                axios.post(`${APP_URL}/user/kyc/${kyc}/documents-upload`, data).then(response => {
                    if (response.data.status) {
                        Swal.fire({
                            icon: response.data.icon, text: response.data.message,
                        }).then((result) => {
                            location.reload();
                        });
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
        }
    });


    function readFile(input) {
        if (input.files && input.files[0]) {
            let data_el = $(input).data('type');
            canvasResize(input.files[0], {
                width: 600, height: 600, crop: false, quality: 80, //rotate: 90,
                callback: function (file, width, height) {
                    $('#' + data_el).val(file)
                }
            });
            let reader = new FileReader();
            reader.onload = function (e) {
                let htmlPreview = '<img class="preview-image" alt="preview-image" src="' + e.target.result + '" />';
                let wrapperZone = $(input).parent();
                let previewZone = $(input).parent().parent().find(".preview-zone");
                let boxZone = $(input).parent().parent().find(".preview-zone").find(".box").find(".box-body");
                wrapperZone.removeClass("dragover");
                previewZone.removeClass("d-none");
                boxZone.empty();
                boxZone.append(htmlPreview);
            };
            reader.readAsDataURL(input.files[0]);
        }
    }

    function reset(e) {
        e.wrap("<form>").closest("form").get(0).reset();
        e.unwrap();
    }

    $(".dropzone").change(function () {
        readFile(this);
    });
    $(".dropzone-wrapper").on("dragover", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).addClass("dragover");
    });
    $(".dropzone-wrapper").on("dragleave", function (e) {
        e.preventDefault();
        e.stopPropagation();
        $(this).removeClass("dragover");
    });
    $(".remove-preview").on("click", function () {
        let boxZone = $(this).parents(".preview-zone").find(".box-body");
        let previewZone = $(this).parents(".preview-zone");
        let dropzone = $(this).parents(".form-group").find(".dropzone");

        let kycImgContainer = $(this).parents(".kyc-img-container").find(".kyc-doc-val");
        kycImgContainer.val(null);

        boxZone.empty();
        previewZone.addClass("d-none");
        reset(dropzone);
    });
})
