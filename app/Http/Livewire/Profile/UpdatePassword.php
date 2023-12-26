<?php

namespace App\Http\Livewire\Profile;


use App\Actions\Fortify\PasswordValidationRules;
use App\Mail\PasswordChangeMail;
use App\Services\OTPService;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserPasswords;
use Livewire\Component;
use Mail;
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

    public function mount()
    {
        $lastOTPRequestTime = session('update_password_last_otp_requested_at');
        if ($lastOTPRequestTime && now()->diffInMinutes($lastOTPRequestTime) < 5) {
            $this->otpSent = true;
        }
    }

    /**
     * @throws Exception
     */
    public function sendOTP(): void
    {
        $this->resetErrorBag();
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

        // Check if the last OTP request time is stored in the session
        $lastOTPRequestTime = session('update_password_last_otp_requested_at');

        if ($lastOTPRequestTime && now()->diffInMinutes($lastOTPRequestTime) < 5) {
            // Calculate the remaining time until they can request a new OTP
            $remainingTime = 5 - now()->diffInMinutes($lastOTPRequestTime);

            // Add an error with the remaining time
            $this->addError('otp', "Please wait {$remainingTime} minutes before requesting a new OTP.");
            return;
        }

        $res = (new OTPService())->sendOTPCode(auth()->user())->getData();
        try {
            if ($res->status) {
                session()->flash('message', 'OTP Has sent to your Email');
                $this->otpSent = true;
                session(['update_password_last_otp_requested_at' => now()]);
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

        session()->forget('update_password_last_otp_requested_at');
        session()->forget($hashed_username);
        $this->otpSent = false;
        $this->otp = null;

        $current_password = Auth::user()->getAuthPassword(); // current_password
        $updater->update(Auth::user(), $this->state);  // password

        // password !==  current_password
        if (Auth::user()->getAuthPassword() !== $current_password) {
            Mail::to(auth()->user()->email)
                ->send(new PasswordChangeMail(auth()->user()));
        }

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
