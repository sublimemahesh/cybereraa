<script>
    (function () {
        window.addEventListener('DOMContentLoaded', (event) => {
            $('.bday-mask').mask('0000-00-00', {
                onComplete: function (cep) {
                    console.log('cep changed! ', cep);
                },
                placeholder: "YYYY-MM-DD",
                selectOnFocus: true
            });
            const __REG_STEP = @this;
            let itl_phone, itl_home_phone

            function init(phone_iso = 'lk', home_phone_iso = 'lk') {
                itl_phone && itl_phone.destroy();
                itl_home_phone && itl_home_phone.destroy();

                try {
                    const itl_phone = intlTelInput.intlTelInput(document.querySelector("#phone"), {
                        initialCountry: phone_iso,
                        formatOnDisplay: false,
                        //allowDropdown: false,
                        autoPlaceholder: 'aggressive'
                    })
                    const itl_home_phone = intlTelInput.intlTelInput(document.querySelector("#home_phone"), {
                        initialCountry: home_phone_iso,
                        formatOnDisplay: false,
                        //allowDropdown: false,
                        autoPlaceholder: 'aggressive'
                    })


                    return {itl_phone, itl_home_phone}
                } catch (e) {
                    console.log(e.message)
                    return init('lk')
                }
            }


            ({itl_phone, itl_home_phone} = init())

            document.querySelector("#phone").addEventListener('change', function (e) {
                let countryData = itl_phone.getSelectedCountryData();
                let phone = itl_phone.getNumber(intlTelInputUtils.numberFormat.E164);
                __REG_STEP.set('phone_iso', countryData.iso2)
                __REG_STEP.set('state.phone', phone);
                console.log('phone: change: ', countryData)
            })

            document.getElementById("home_phone").addEventListener('change', function (e) {
                let countryData = itl_home_phone.getSelectedCountryData();
                let phone = itl_home_phone.getNumber(intlTelInputUtils.numberFormat.E164);
                __REG_STEP.set('home_phone_iso', countryData.iso2)
                __REG_STEP.set('state.home_phone', phone);
                console.log('home_phone : change: ', countryData)
            })


            document.getElementById("phone").addEventListener("close:countrydropdown", function () {
                let countryData = itl_phone.getSelectedCountryData();
                let phone = itl_phone.getNumber(intlTelInputUtils.numberFormat.E164);
                __REG_STEP.set('phone_iso', countryData.iso2)
                __REG_STEP.set('state.phone', phone);
                console.log('countryChange: phone_iso: ', countryData)
            });

            document.querySelector("#home_phone").addEventListener("close:countrydropdown", function () {
                let countryData = itl_home_phone.getSelectedCountryData();
                let phone = itl_home_phone.getNumber(intlTelInputUtils.numberFormat.E164);
                __REG_STEP.set('home_phone_iso', countryData.iso2)
                __REG_STEP.set('state.home_phone', phone);
                console.log('countryChange: home_phone_iso: ', countryData)
            });

            document.getElementById('country').onchange = function (e) {
                let selectedISO = e.target.options[e.target.selectedIndex].getAttribute('data-value');
                let currentPhoneISO = itl_phone.getSelectedCountryData().iso2
                let currentHomePhoneISO = itl_home_phone.getSelectedCountryData().iso2;

                let currentPhoneVal = itl_phone.getNumber(intlTelInputUtils.numberFormat.E164)
                let currentHomePhoneVal = itl_home_phone.getNumber(intlTelInputUtils.numberFormat.E164);

                let phone_iso = currentPhoneVal.length ? currentPhoneISO : selectedISO
                let home_phone_iso = currentHomePhoneVal.length ? currentHomePhoneISO : selectedISO

                itl_phone.setCountry(phone_iso)
                itl_home_phone.setCountry(home_phone_iso)
            }

            Livewire.hook('element.updated', (message, component) => {

                //console.log(component.serverMemo.data)
                if (component.serverMemo.data.step === 1) {
                    document.querySelector("#phone").value = component.serverMemo.data.state.phone;
                    document.querySelector("#home_phone").value = component.serverMemo.data.state.home_phone;

                    // let phone_iso = itl_phone.getSelectedCountryData().iso2;
                    // let home_phone_iso = itl_home_phone.getSelectedCountryData().iso2;
                    //
                    // console.log({phone_iso, home_phone_iso});
                    // ({itl_phone, itl_home_phone} = init(phone_iso, home_phone_iso));

                    //let isoEl = document.getElementById('country')
                    //let selectedISO = isoEl.options[isoEl.selectedIndex].getAttribute('data-value') || 'LK';
                }
            });

        });
    })()
</script>