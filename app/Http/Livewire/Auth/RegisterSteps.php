<?php

namespace App\Http\Livewire\Auth;

use App\Actions\Fortify\PasswordValidationRules;
use App\Models\Country;
use App\Models\User;
use Auth;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Fortify\Contracts\RegisterResponse;
use Laravel\Jetstream\Jetstream;
use Livewire\Component;

class RegisterSteps extends Component
{
    use PasswordValidationRules;

    public bool $disable_sponsor_modify = false;

    public string $phone_iso = 'LK';

    public array $state = [
        "first_name" => null,
        "last_name" => null,
        "country_id" => null,
        "phone" => null,
        "email" => null,
        "password" => null,
        "super_parent_id" => null,
        "sponsor" => null,
        "username" => null,
        "terms" => null,
    ];

    public User $sponsor;

    public function mount()
    {
        $this->state['super_parent_id'] = $this->sponsor?->id;
        $this->state['sponsor'] = $this->sponsor?->username;
        $this->disable_sponsor_modify = $this->sponsor->id !== null;
    }

    protected function rules(): array
    {
        return [
            'state.first_name' => ['required', 'string', 'max:255'],
            'state.last_name' => ['required', 'string', 'max:255'],
//            'state.country_id' => ['required', 'exists:countries,id', 'max:255'],
//            'state.phone' => ['required', 'string', 'max:255', 'phone:' . $this->phone_iso],
            'state.email' => ['required', 'string', 'email', 'max:255'],
            'state.password' => $this->passwordRules(),
            'state.super_parent_id' => [
                'nullable',
                Rule::exists('users', 'id')
//                    ->when(config('fortify.super_parent_id') !== (int)$this->state['super_parent_id'], function ($q) {
//                        $q->whereNotNull('position')->whereNotNull('parent_id');
//                    })
            ],
            'state.sponsor' => [
                'nullable',
                Rule::exists('users', 'username'),
//                    ->when(config('fortify.super_parent_username') !== $this->state['sponsor'], function ($q) {
//                        $q->whereNotNull('position')->whereNotNull('parent_id');
//                    }),
                'string',
                'max:255'
            ],
            'state.username' => ['required', 'unique:users,username', 'string', 'max:255', 'regex:/^[0-9A-Z]+$/'], // 'regex:/^[a-z0-9A-Z-_]+$/'
            'state.terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
        ];
    }

    protected $messages = [
        'state.username.regex' => 'The username must only contain numbers and uppercase letters',
    ];
    protected $validationAttributes = [
        'state.super_parent_id' => 'Sponsor'
    ];

    public function updated($name, $value): void
    {
        if ($name === 'state.sponsor' || $name === 'state.super_parent_id') {
            try {
                $this->validateOnly($name);
            } catch (Exception $e) {
                $this->sponsor = new User;
                $this->state['super_parent_id'] = null;
            }
        }
        $this->validateOnly($name);
    }

    public function updatedStateSponsor($value): void
    {
        $this->sponsor = User::where('username', $value)
            ->whereRelation('roles', 'name', 'user')
            ->when(config('fortify.super_parent_username') !== $value, function ($q) {
                $q->whereNotNull('super_parent_id');
            })
            ->whereHas('purchasedPackages')
            ->firstOrNew();
        $this->state['super_parent_id'] = $this->sponsor?->id;

        $this->validateOnly('state.sponsor');
    }

    public function updatedStateSuperParentId(int|null $value): void
    {

        $this->sponsor = User::when(config('fortify.super_parent_id') !== (int)$value,
            function ($q) {
                $q->whereNotNull('super_parent_id');
            })
            ->whereHas('purchasedPackages')
            ->findOrNew($value);
        $this->state['super_parent_id'] = $this->sponsor?->id;
        $this->validateOnly('state.sponsor');
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
        $countries = Country::orderBy('name')->get(['name', 'iso', 'id'])->keyBy('iso');
        return view('livewire.auth.register-steps', compact('countries'));
    }
}
