<x-backend.layouts.app>
    @section('title', 'My KYC')
    @section('header-title', 'My KYC' )
    @section('styles')
    @endsection
    @section('breadcrumb-items')
        <li class="breadcrumb-item">KYC</li>
    @endsection

    <div class="row kyc-details-page">
        <div class="col-lg-12 mb-2">
            <div id="sumsub-websdk-container"></div>
        </div>
    </div>

    @push('scripts')
        <script src="https://static.sumsub.com/idensic/static/sns-websdk-builder.js"></script>
        <script>
            function launchWebSdk(accessToken, applicantEmail, applicantPhone) {
                let snsWebSdkInstance = snsWebSdk.init(
                    accessToken,
                    () => getNewAccessToken()
                )
                    .withConf({
                        lang: 'en',
                        email: applicantEmail,
                        phone: applicantPhone,
                    })
                    .withOptions({addViewportTag: false, adaptIframeHeight: true})
                    .on('idCheck.onStepCompleted', (payload) => {
                        console.log('onStepCompleted', payload)
                    })
                    .on('idCheck.onError', (error) => {
                        console.log('onError', error)
                    })
                    .onMessage((type, payload) => {
                        console.log('onMessage', type, payload)
                    })
                    .build();
                snsWebSdkInstance.launch('#sumsub-websdk-container')
            }

            function getNewAccessToken() {


                return axios
                    .post(APP_URL + '/user/sumsub/accessTokens', {
                        'levelName': 'basic-kyc-level',
                        'ttlInSecs': 600
                    }).then(res => {
                        // Extract and return the new access token from the response
                        return res.data.token;
                    }).catch(error => {
                        console.error('Error refreshing access token:', error);
                        // If there's an error, you can handle it appropriately
                        // For example, you can throw an error or return a default value
                        throw error;
                    });
                // return Promise.resolve($NEW_ACCESS_TOKEN)
            }

            $(document).ready(function () {
                getNewAccessToken().then((token) => launchWebSdk(token))
            })

        </script>
    @endpush
</x-backend.layouts.app>
