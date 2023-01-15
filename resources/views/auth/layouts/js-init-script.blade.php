<script>
    (function () {
        window.addEventListener('DOMContentLoaded', (event) => {

            const __REG_STEP = @this;
            let itl_phone

            function init(phone_iso = 'lk') {
                itl_phone && itl_phone.destroy();

                try {
                    return intlTelInput.intlTelInput(document.querySelector("#phone"), {
                        initialCountry: phone_iso,
                        formatOnDisplay: false,
                        //allowDropdown: false,
                        autoPlaceholder: 'aggressive'
                    })
                } catch (e) {
                    console.log(e.message)
                    return init('lk')
                }
            }


            itl_phone = init()

            document.querySelector("#phone").addEventListener('change', function (e) {
                let countryData = itl_phone.getSelectedCountryData();
                let phone = itl_phone.getNumber(intlTelInputUtils.numberFormat.E164);
                __REG_STEP.set('phone_iso', countryData.iso2)
                __REG_STEP.set('state.phone', phone);
                console.log('phone: change: ', countryData)
            })


            document.getElementById("phone").addEventListener("close:countrydropdown", function () {
                let countryData = itl_phone.getSelectedCountryData();
                let phone = itl_phone.getNumber(intlTelInputUtils.numberFormat.E164);
                __REG_STEP.set('phone_iso', countryData.iso2)
                __REG_STEP.set('state.phone', phone);
                console.log('countryChange: phone_iso: ', countryData)
            });


            document.getElementById('country').onchange = function (e) {
                let selectedISO = e.target.options[e.target.selectedIndex].getAttribute('data-value');
                let currentPhoneISO = itl_phone.getSelectedCountryData().iso2

                let currentPhoneVal = itl_phone.getNumber(intlTelInputUtils.numberFormat.E164)

                let phone_iso = currentPhoneVal.length ? currentPhoneISO : selectedISO

                itl_phone.setCountry(phone_iso)

            }

            Livewire.hook('element.updated', (message, component) => {

                //console.log(component.serverMemo.data)
                if (component.serverMemo.data.step === 1) {
                    document.querySelector("#phone").value = component.serverMemo.data.state.phone;

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