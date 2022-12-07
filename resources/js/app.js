import './bootstrap';

import Alpine from 'alpinejs';
import intlTelInput from "intl-tel-input";
import Swal from "sweetalert2";


window.Alpine = Alpine;

Alpine.start();

window.Swal = Swal;

window.Toast = Swal.mixin({
    toast: true,
    position: "top-end",
    showConfirmButton: false,
    timer: 3000,
    timerProgressBar: true,
    // didOpen: (toast) => {
    //   toast.addEventListener('mouseenter', Swal.stopTimer)
    //   toast.addEventListener('mouseleave', Swal.resumeTimer)
    // }
});


window.intlTelInput = {
    intlTelInput,
    errorMap: [
        "Invalid number",
        "Invalid country code",
        "The number is too short",
        "Number Too long",
        "Invalid number",
    ],
    options: {
        onlyCountries: ["LK"],
        allowDropdown: false,
        initialCountry: "LK",
        customContainer: "int-phone",
        separateDialCode: true,
        utilsScript: import("intl-tel-input/build/js/utils.js"),
    },
    selector: document.querySelector("#phone") || false,
    init: function (selector = this.selector) {
        return selector && intlTelInput(selector, this.options);
    },
};

const images = document.querySelectorAll('img');

images.forEach(img => {
    img.addEventListener('error', function handleError() {
        img.src = import.meta.env.VITE_ASSET_URL + '/assets/images/no-image.jpg';
        img.alt = '404';
    });
});