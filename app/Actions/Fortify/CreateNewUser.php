<?php

namespace App\Actions\Fortify;

use App\Models\Profile;
use App\Models\Team;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Validation\Rule;
use Laravel\Fortify\Contracts\CreatesNewUsers;
use Laravel\Jetstream\Jetstream;

class CreateNewUser implements CreatesNewUsers
{
    use PasswordValidationRules;

    /**
     * Create a newly registered user.
     *
     * @param array $input
     * @return \App\Models\User
     */
    public function create(array $input)
    {
        Validator::make($input, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:255', 'unique:users,phone'],
            'super_parent_id' => ['nullable', 'exists:users,id'],
            'username' => ['required', 'unique:users,username', 'string', 'max:255'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',

            'parent_id' => ['nullable', 'exists:users,id'],
            'position' => [
                Rule::requiredIf(!empty($input['parent_id'])),
                'nullable',
                'lte:5',
                'gte:1',
                !empty($input['parent_id']) ?
                    Rule::unique('users', 'position')
                        ->where('parent_id', $input['parent_id']) : ''
            ],

            // Profile
            'country_id' => ['required', 'exists:countries,id', 'max:255'],
            'street' => ['required', 'string', 'max:255'],
            'state' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:255'],
            'zip_code' => ['required', 'string', 'max:255'],
            'home_phone' => ['required', 'string', 'max:255'],
            'gender' => ['required', 'in:male,female', 'string', 'max:255'],
            'dob' => ['required', 'date', 'max:255'],
            'nic' => [Rule::requiredIf(empty($input['driving_lc_number']) && empty($input['passport_number'])), 'nullable', 'string', 'max:255'],
            'driving_lc_number' => [Rule::requiredIf(empty($input['nic']) && empty($input['passport_number'])), 'nullable', 'string', 'max:255'],
            'passport_number' => [Rule::requiredIf(empty($input['driving_lc_number']) && empty($input['nic'])), 'nullable', 'string', 'max:255'],
        ])->validate();

        return DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'],
                'super_parent_id' => $input['super_parent_id'],
                'parent_id' => $input['parent_id'] ?? null,
                'position' => $input['position'] ?? null,
                'username' => $input['username'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) use ($input) {
                $user->profile()->save(Profile::forceCreate([
                    "country_id" => $input['country_id'],
                    "street" => $input['street'],
                    "state" => $input['state'],
                    "address" => $input['address'],
                    "zip_code" => $input['zip_code'],
                    "home_phone" => $input['home_phone'],
                    "gender" => $input['gender'],
                    "dob" => $input['dob'],
                    "nic" => $input['nic'],
                    "driving_lc_number" => $input['driving_lc_number'],
                    "passport_number" => $input['passport_number'],
                ]));
                $user->assignRole('user');
                $this->createTeam($user);
            });
        });
    }

    /**
     * Create a personal team for the user.
     *
     * @param \App\Models\User $user
     * @return void
     */
    protected function createTeam(User $user)
    {
        $user->ownedTeams()->save(Team::forceCreate([
            'user_id' => $user->id,
            'name' => explode(' ', $user->name, 2)[0] . "'s Team",
            'personal_team' => true,
        ]));
    }
}
