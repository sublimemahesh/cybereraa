<?php

namespace App\Http\Livewire\User\Genealogy;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Country;
use App\Models\User;
use Auth;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;

class CreateNewUser extends Component
{
    use PasswordValidationRules;

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
        "super_parent_id" => null,
        "parent_id" => null,
        "username" => null,
        "terms" => null,
    ];

    public User $sponsor;

    protected function rules(): array
    {
        return [
            'state.first_name' => ['required', 'string', 'max:255'],
            'state.last_name' => ['required', 'string', 'max:255'],
            'state.country_id' => ['required', 'exists:countries,id'],
            'state.street' => ['required', 'string', 'max:255'],
            'state.state' => ['required', 'string', 'max:255'],
            'state.address' => ['required', 'string', 'max:255'],
            'state.zip_code' => ['required', 'string', 'max:255'],
            'state.phone' => ['required', 'string', 'max:255', 'unique:users,phone'],
            'state.home_phone' => ['required', 'string', 'max:255'],
            'state.gender' => ['required', 'in:male,female', 'string', 'max:255'],
            'state.dob' => ['required', 'date', 'max:255'],
            'state.email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'state.password' => $this->passwordRules(),

            'state.nic' => [Rule::requiredIf(empty($this->state['driving_lc_number']) && empty($this->state['passport_number'])), 'nullable', 'string', 'max:255'],
            'state.driving_lc_number' => [Rule::requiredIf(empty($this->state['nic']) && empty($this->state['passport_number'])), 'nullable', 'string', 'max:255'],
            'state.passport_number' => [Rule::requiredIf(empty($this->state['driving_lc_number']) && empty($this->state['nic'])), 'nullable', 'string', 'max:255'],

            'state.super_parent_id' => ['required', 'exists:users,id'],
            'state.username' => ['required', 'unique:users,username', 'string', 'max:255'],
            'state.terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ];
    }

    public function mount()
    {
        $this->sponsor = Auth::user();
        $this->state['super_parent_id'] = $this->sponsor->id;
        if (($this->sponsor->parent_id === null || $this->sponsor->position === null) && $this->sponsor->id !== config('fortify.super_parent_id')) {
            session()->flash('error', 'Your genealogy position is still not available. Please contact your up link user or contact us to solve the problem!');
            redirect()->route('user.genealogy');
        }
    }

    public function updated($name, $value): void
    {
        $this->validateOnly($name);
    }

    public function register(CreatesNewUsers $creator): void
    {
        $this->validate();

        $this->state['name'] = $this->state['first_name'] . " " . $this->state['last_name'];
        event(new Registered($user = $creator->create($this->state)));

        session()->flash('message', 'New User Created Successfully!');
        redirect()->route('user.genealogy');
    }

    public function render()
    {
        $countries = Country::orderBy('name')->get();
        return view('livewire.user.genealogy.create-new-user', compact('countries'));
    }
}
