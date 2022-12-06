<?php

namespace App\Http\Livewire\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use Auth;
use Illuminate\Auth\Events\Registered;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;

class RegisterSteps extends Component
{
    use PasswordValidationRules;

    public int $step = 1;

    public array $state = [];

    protected function rules(): array
    {
        return [
            'state.name' => $this->step === 1 || $this->step === 3 ? ['required', 'string', 'max:255'] : '',
            'state.email' => $this->step === 2 || $this->step === 3 ? ['required', 'string', 'email', 'max:255', 'unique:users,email'] : '',
            'state.password' => $this->step === 3 ? $this->passwordRules() : '',
            'state.terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() && $this->step === 3 ? ['accepted', 'required'] : '',
        ];
    }

    public function previousStep()
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function nextStep()
    {
        if ($this->step < 3) {
            $this->validate();
            $this->step++;
        }
    }

    public function showStep(int $step)
    {
        $this->validate();
        if ($this->step !== $step) {
            if ($this->step > 1) {
                $this->step--;
            }
            if ($this->step < 3) {
                $this->validate();
                $this->step++;
            }
        }
    }

    public function register(CreatesNewUsers $creator): RegisterResponse
    {
        $this->validate();
        event(new Registered($user = $creator->create($this->state)));
        Auth::login($user);
        return app(RegisterResponse::class);
    }

    public function render()
    {
        return view('livewire.auth.register-steps');
    }
}
