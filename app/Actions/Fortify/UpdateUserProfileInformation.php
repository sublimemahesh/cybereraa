<?php

namespace App\Actions\Fortify;

use App\Models\Profile;
use App\Traits\MaskCredentials;
use Carbon;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Support\Facades\Validator;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;

class UpdateUserProfileInformation implements UpdatesUserProfileInformation
{
    /**
     * Validate and update the given user's profile information.
     *
     * @param mixed $user
     * @param array $input
     * @return void
     */
    public function update($user, array $input)
    {

        if (MaskCredentials::maskedEmailAddress(auth()->user()->email) === $input['email']) {
            $input['email'] = auth()->user()->email;
        }
        //        if (MaskCredentials::maskedPhone(auth()->user()->phone) === $input['phone']) {
        //            $input['phone'] = auth()->user()->phone;
        //        }


        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:255'],
            'photo' => ['nullable', 'mimes:jpg,jpeg,png', 'max:1024'],

            'profile_info.street' => ['required', 'string', 'max:255'],
            'profile_info.state' => ['required', 'string', 'max:255'],
            'profile_info.address' => ['required', 'string', 'max:255'],
            'profile_info.zip_code' => ['required', 'integer', 'max_digits:16'],
            'profile_info.home_phone' => ['required', 'string', 'max:255'],
            'profile_info.recover_email' => ['required', 'email', 'max:255'],
            'profile_info.gender' => ['required', 'in:male,female', 'string', 'max:255'],
            'profile_info.dob' => ['required', 'date', 'max:255', 'after_or_equal:1940-01-01', 'before_or_equal:' . Carbon::now()->subYears(16)->format('Y-m-d')],
            'profile_info.country_id' => ['nullable', 'exists:countries,id'],
            'profile_info.wallet_address' => ['nullable', 'string', 'max:255'],
            'profile_info.binance_email' => ['nullable', 'email', 'max:255'],
            'profile_info.binance_id' => ['nullable', 'string', 'max:255'],
            'profile_info.binance_phone' => ['nullable', 'string', 'max:255'],
        ], customAttributes: [
            'name' => "Name (Personal Details)",
            'email' => "Email (Personal Details)",
            'phone' => "Phone (Personal Details)",
            'profile_info.gender' => "Gender (Personal Details)",
            'profile_info.dob' => "Date of Birth (Personal Details)",
            'profile_info.street' => "Street (Contact Details)",
            'profile_info.state' => "State (Contact Details)",
            'profile_info.address' => "Address (Contact Details)",
            'profile_info.zip_code' => "Zip code (Contact Details)",
            'profile_info.home_phone' => "Home phone (Contact Details)",
            'profile_info.recover_email' => "Recover  (Contact Details)",
            'profile_info.wallet_address' => "Wallet address (Payment Details)",
            'profile_info.binance_email' => "Binance email (Payment Details)",
            'profile_info.binance_id' => "Binance id (Payment Details)",
            'profile_info.binance_phone' => "Binance phone (Payment Details)",
        ])->validateWithBag('updateProfileInformation');

        if (isset($input['photo'])) {
            $user->updateProfilePhoto($input['photo']);
        }

        if ($input['email'] !== $user->email && $user instanceof MustVerifyEmail) {
            $this->updateVerifiedUser($user, $input);
        }

        if ($input['phone'] !== $user->phone) {
            $user->forceFill([
                'name' => $input['name'],
                'phone' => $input['phone'],
                'phone_verified_at' => null,
            ])->save();
        }

        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
        ])->save();

        Profile::where('user_id', $user->id)->update([
            'street' => $input['profile_info']['street'],
            'state' => $input['profile_info']['state'],
            'address' => $input['profile_info']['address'],
            'zip_code' => $input['profile_info']['zip_code'],
            'home_phone' => $input['profile_info']['home_phone'],
            'recover_email' => $input['profile_info']['recover_email'],
            'gender' => $input['profile_info']['gender'],
            'dob' => $input['profile_info']['dob'],
            'country_id' => $input['profile_info']['country_id'],
            'wallet_address' => $input['profile_info']['wallet_address'] ?? null,
            'binance_email' => $input['profile_info']['binance_email'] ?? null,
            'binance_id' => $input['profile_info']['binance_id'] ?? null,
            'binance_phone' => $input['profile_info']['binance_phone'] ?? null,
        ]);
    }

    /**
     * Update the given verified user's profile information.
     *
     * @param mixed $user
     * @param array $input
     * @return void
     */
    protected function updateVerifiedUser($user, array $input)
    {
        $user->forceFill([
            'name' => $input['name'],
            'email' => $input['email'],
            'email_verified_at' => null,
        ])->save();

        $user->sendEmailVerificationNotification();
    }
}
