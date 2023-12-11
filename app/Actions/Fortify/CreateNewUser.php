<?php

namespace App\Actions\Fortify;

use App\Models\Profile;
use App\Models\Team;
use App\Models\TeamBonus;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
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
            'email' => ['required', 'string', 'email', 'max:255'],
//            'phone' => ['required', 'string', 'max:255'],
            'super_parent_id' => ['nullable', 'exists:users,id'],
            'username' => ['required', 'unique:users,username', 'string', 'max:255', 'regex:/^[a-z0-9A-Z-_]+$/'],
            'password' => $this->passwordRules(),
            'terms' => Jetstream::hasTermsAndPrivacyPolicyFeature() ? ['accepted', 'required'] : '',
            // Profile
//            'country_id' => ['required', 'exists:countries,id', 'max:255'],
        ])->validate();

        return DB::transaction(function () use ($input) {
            return tap(User::create([
                'name' => $input['name'],
                'email' => $input['email'],
                'phone' => $input['phone'] ?? null,
                'super_parent_id' => $input['super_parent_id'] ?? config('fortify.super_parent_id'),
                'username' => $input['username'],
                'password' => Hash::make($input['password']),
            ]), function (User $user) use ($input) {
                $user->profile()->save(Profile::forceCreate([
                    "country_id" => $input['country_id'] ?? null,
                ]));
                $this->createSpecialBonus($user);
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

    private function createSpecialBonus(User $user): void
    {
        if ($user->sponsor->specialBonuses->count() === 3) {
            return;
        }

        if ($user->sponsor->children()->count() >= 10) {
            TeamBonus::updateOrCreate([
                'user_id' => $user->super_parent_id,
                'bonus' => '10_DIRECT_SALE',
                'status' => 'DISQUALIFIED',
                'type' => 'SPECIAL_BONUS'
            ]);
        }
        if ($user->sponsor->children()->count() >= 20) {
            TeamBonus::updateOrCreate([
                'user_id' => $user->super_parent_id,
                'bonus' => '20_DIRECT_SALE',
                'status' => 'DISQUALIFIED',
                'type' => 'SPECIAL_BONUS'
            ]);
        }
        if ($user->sponsor->children()->count() >= 30) {
            TeamBonus::updateOrCreate([
                'user_id' => $user->super_parent_id,
                'bonus' => '30_DIRECT_SALE',
                'status' => 'DISQUALIFIED',
                'type' => 'SPECIAL_BONUS'
            ]);
        }
    }
}
