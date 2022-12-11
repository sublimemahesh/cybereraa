$(function () {

    // Use this method to overcome dom manipulation
    const REQUIRED_DOCUMENTS_TYPES = {
        nic: ['front', 'back', 'other'], driving_lc: ['front', 'other'], passport: ['front', 'other']
    }

    REQUIRED_DOCUMENTS_TYPES[KYC_TYPE].map(doc_type => {
        let element_id = `#${KYC_TYPE}-${doc_type}-image`
        let submit_btn = `#${KYC_TYPE}-${doc_type}-submit`

        $(document).on("click", submit_btn, function (e) {
            e.preventDefault()
            if ($(element_id).val().length <= 0) {
                Toast.fire({
                    icon: 'error', title: "KYC proof document is required",
                })
            } else {
                let document_file = $(element_id)[0].files[0]
                let kyc = $(this).data("kyc");
                let kyc_document_id = $(`#${KYC_TYPE}-${doc_type}-id`).val();

                Swal.fire({
                    title: "Please wait...!",
                    text: "It may take some time...!",
                    imageUrl: APP_URL + "/assets/images/loader.svg",
                    showConfirmButton: false,
                    allowOutsideClick: false,
                });
                canvasResize(document_file, {
                    width: 600,
                    height: 600,
                    crop: false,
                    quality: 80,
                    //rotate: 90,
                    callback: function (data, width, height) {
                        axios.post(`${APP_URL}/user/kyc/${kyc}/documents/${kyc_document_id}/upload`, {
                            document: data,
                            type: doc_type,
                        }).then(response => {
                            if (response.data.status) {
                                Swal.fire({
                                    icon: response.data.icon,
                                    text: response.data.message,
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
                });
            }
        });
    })


    function readFile(input) {
        if (input.files && input.files[0]) {
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
        boxZone.empty();
        previewZone.addClass("d-none");
        reset(dropzone);
    });
})