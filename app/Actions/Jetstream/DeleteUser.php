<?php

namespace App\Actions\Jetstream;

use Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;
use Laravel\Jetstream\Contracts\DeletesTeams;
use Laravel\Jetstream\Contracts\DeletesUsers;

class DeleteUser implements DeletesUsers
{
    /**
     * The team deleter implementation.
     *
     * @var \Laravel\Jetstream\Contracts\DeletesTeams
     */
    protected $deletesTeams;

    /**
     * Create a new action instance.
     *
     * @param \Laravel\Jetstream\Contracts\DeletesTeams $deletesTeams
     * @return void
     */
    public function __construct(DeletesTeams $deletesTeams)
    {
        $this->deletesTeams = $deletesTeams;
    }

    /**
     * Delete the given user.
     *
     * @param mixed $user
     * @return void
     */
    public function delete($user)
    {
        $pkg_status = \App\Models\User::whereRelation('roles', 'name', 'user')
            ->where('id', Auth::user()->id)
            ->whereDoesntHave('purchasedPackages')
            ->whereDoesntHave('transactions', fn($q) => $q->where('status', 'PENDING'))
            ->doesntExist();
        if ($pkg_status) {
//            session()->flash('error', 'You are not allowed to delete this account! Contact your administrator for further instructions.');
            throw ValidationException::withMessages([
                'account' => [__('You are not allowed to delete this account! Contact your administrator for further instructions.')],
            ]);
        }
        DB::transaction(function () use ($user) {
            $this->deleteTeams($user);
            $user->deleteProfilePhoto();
            $user->tokens->each->delete();
            $user->profile()->forceDelete();
            $user->forceDelete();
//            $user->delete();
        });
    }

    /**
     * Delete the teams and team associations attached to the user.
     *
     * @param mixed $user
     * @return void
     */
    protected function deleteTeams($user)
    {
        $user->teams()->detach();

        $user->ownedTeams->each(function ($team) {
            $this->deletesTeams->delete($team);
        });
    }
}
