<?php

namespace App\Http\Livewire\Profile;


use App\Services\OTPService;
use App\Traits\MaskCredentials;
use Exception;
use Illuminate\Support\Facades\Auth;
use Laravel\Fortify\Contracts\UpdatesUserProfileInformation;
use Livewire\Component;
use Livewire\WithFileUploads;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Validator;

class UpdateProfileInformation extends Component
{
    use WithFileUploads;


    public $state = [];

    public $photo;

    public $verificationLinkSent = false;

    public $otp = null;
    public $otpSent = false;


    public function mount()
    {
        $this->state = Auth::user()->withoutRelations()->toArray();
        $this->state['email'] = MaskCredentials::maskedEmailAddress(auth()->user()->email);
        $this->state['phone'] = MaskCredentials::maskedPhone(auth()->user()->phone);
    }

    /**
     * @throws Exception
     */
    public function sendOTP(): void
    {
        $res = (new OTPService())->sendOTPCode(auth()->user())->getData();
        try {

            if ($res->status) {
                $this->otpSent = true;
            }
        } catch (Exception $e) {
            $this->otpSent = true;
        }

    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function updateProfileInformation(UpdatesUserProfileInformation $updater): \Illuminate\Http\RedirectResponse|null
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
        $updater->update(
            Auth::user(),
            $this->photo
                ? [...$this->state, 'photo' => $this->photo]
                : $this->state
        );

        if (isset($this->photo)) {
            return redirect()->route('profile.show');
        }

        $this->emit('saved');

        $this->emit('refresh-navigation-menu');
        return null;
    }

    public function deleteProfilePhoto(): void
    {
        Auth::user()->deleteProfilePhoto();

        $this->emit('refresh-navigation-menu');
    }

    public function sendEmailVerification()
    {
        Auth::user()->sendEmailVerificationNotification();

        $this->verificationLinkSent = true;
    }

    public function getUserProperty()
    {
        return Auth::user();
    }

    public function render()
    {
        return view('livewire.profile.update-profile-information');
    }
}
