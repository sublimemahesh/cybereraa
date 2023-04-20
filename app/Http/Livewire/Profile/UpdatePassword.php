<?php

namespace App\Http\Livewire\Profile;


use App\Actions\Fortify\PasswordValidationRules;
use App\Services\OTPService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Livewire\Component;
use Validator;

class UpdatePassword extends Component
{
    use PasswordValidationRules;

    public $state = [
        'current_password' => '',
        'password' => '',
        'password_confirmation' => '',
    ];

    public $otp = null;
    public $otpSent = false;

    /**
     * @throws Exception
     */
    public function sendOTP(): void
    {
        Validator::make(
            $this->state,
            [
                'current_password' => ['required', 'string', 'current_password:web'],
                'password' => $this->passwordRules(),
            ],
            [
                'current_password.current_password' => __('The provided password does not match your current password.'),
            ]
        )->validateWithBag('updatePassword');

        $res = (new OTPService())->sendOTPCode(auth()->user())->getData();
        try {

            if ($res->status) {
                $this->otpSent = true;
            }
        } catch (Exception $e) {
            $this->otpSent = true;
        }

    }

    public function updatePassword(UpdatesUserPasswords $updater)
    {
        $this->resetErrorBag();
        $validated = Validator::make(['otp' => $this->otp], [
            'otp' => 'required|digits:6',
        ])->validate();

        $hashed_username = hash("sha512", auth()->user()?->username);
        $hashed_code = hash("sha512", $validated['otp']);
        if (!session()->has($hashed_username) || session()->get($hashed_username) !== $hashed_code) {
            $this->addError('otp', 'Entered OTP code is invalid!');
            return null;
        }
        session()->forget($hashed_username);
        $this->otpSent = false;
        $updater->update(Auth::user(), $this->state);

        if (request()->hasSession()) {
            request()->session()->put([
                'password_hash_' . Auth::getDefaultDriver() => Auth::user()->getAuthPassword(),
            ]);
        }

        $this->state = [
            'current_password' => '',
            'password' => '',
            'password_confirmation' => '',
        ];

        $this->emit('saved');
    }

    public function getUserProperty()
    {
        return Auth::user();
    }


    public function render()
    {
        return view('livewire.profile.update-password');
    }
}
