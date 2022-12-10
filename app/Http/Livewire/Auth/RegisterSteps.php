<?php

namespace App\Http\Livewire\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\User;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;

class RegisterSteps extends Component
{
    use PasswordValidationRules;

    public int $step = 1;

    public array $state = [
        "first_name" => null,
        "last_name" => null,
        "country_id" => null,
        "street" => null,
        "state" => null,
        "address" => null,
        "zip_code" => null,
        "phone" => null,
        "home_phone" => null,
        "gender" => null,
        "dob" => null,
        "email" => null,
        "password" => null,
        "nic" => null,
        "driving_lc_number" => null,
        "passport_number" => null,
        "parent_id" => null,
        "sponsor" => null,
        "username" => null,
        "position" => null,
        "terms" => null,
    ];

    public User $sponsor;

    protected function rules(): array
    {
        return [
            'state.first_name' => $this->step === 1 || $this->step === 3 ? ['required', 'string', 'max:255'] : '',
            'state.last_name' => $this->step === 1 || $this->step === 3 ? ['required', 'string', 'max:255'] : '',
            'state.country_id' => $this->step === 1 || $this->step === 3 ? ['required', 'exists:countries,id', 'max:255'] : '',
            'state.street' => $this->step === 1 || $this->step === 3 ? ['required', 'string', 'max:255'] : '',
            'state.state' => $this->step === 1 || $this->step === 3 ? ['required', 'string', 'max:255'] : '',
            'state.address' => $this->step === 1 || $this->step === 3 ? ['required', 'string', 'max:255'] : '',
            'state.zip_code' => $this->step === 1 || $this->step === 3 ? ['required', 'string', 'max:255'] : '',
            'state.phone' => $this->step === 1 || $this->step === 3 ? ['required', 'string', 'max:255', 'unique:users,phone'] : '',
            'state.home_phone' => $this->step === 1 || $this->step === 3 ? ['required', 'string', 'max:255'] : '',
            'state.gender' => $this->step === 1 || $this->step === 3 ? ['required', 'in:male,female', 'string', 'max:255'] : '',
            'state.dob' => $this->step === 1 || $this->step === 3 ? ['required', 'date', 'max:255'] : '',
            'state.email' => $this->step === 1 || $this->step === 3 ? ['required', 'string', 'email', 'max:255', 'unique:users,email'] : '',
            'state.password' => $this->step === 1 || $this->step === 3 ? $this->passwordRules() : '',

            'state.nic' => $this->step === 2 || $this->step === 3 ? [Rule::requiredIf(empty($this->state['driving_lc_number']) && empty($this->state['passport_number'])), 'nullable', 'string', 'max:255'] : '',
            'state.driving_lc_number' => $this->step === 2 || $this->step === 3 ? [Rule::requiredIf(empty($this->state['nic']) && empty($this->state['passport_number'])), 'nullable', 'string', 'max:255'] : '',
            'state.passport_number' => $this->step === 2 || $this->step === 3 ? [Rule::requiredIf(empty($this->state['driving_lc_number']) && empty($this->state['nic'])), 'nullable', 'string', 'max:255'] : '',

            'state.parent_id' => $this->step === 3 ? ['required', 'exists:users,id', 'max:255'] : '',
            'state.sponsor' => $this->step === 3 ? ['required', 'exists:users,username', 'string', 'max:255'] : '',
            'state.username' => $this->step === 3 ? ['required', 'unique:users,username', 'string', 'max:255'] : '',
            'state.position' => $this->step === 3 ? ['required', 'in:right,left', 'string', 'max:255'] : '',
            'state.terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() && $this->step === 3 ? ['accepted', 'required'] : '',
        ];
    }

    public function updated($name, $value): void
    {
        if ($this->step === 2) {
            $this->validate();
        }
        $this->validateOnly($name);
    }

    public function updatedStateSponsor($value): void
    {

        $this->validateOnly('state.sponsor');
        $this->sponsor = User::where('username', $value)->first();
        $this->state['parent_id'] = optional($this->sponsor)->id;
    }

    public function previousStep(): void
    {
        if ($this->step > 1) {
            $this->step--;
        }
    }

    public function nextStep(): void
    {
        if ($this->step < 3) {
            $this->validate();
            $this->step++;
        }
    }

    public function showStep(int $step): void
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

    public function register(CreatesNewUsers $creator)
    {
        $this->validate();
        $this->state['name'] = $this->state['first_name'] . " " . $this->state['last_name'];
        event(new Registered($user = $creator->create($this->state)));
        Auth::login($user);
        return app(RegisterResponse::class);
    }

    public function render()
    {
        return view('livewire.auth.register-steps');
    }
}
