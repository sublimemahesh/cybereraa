<?php

namespace App\Policies;

use App\Models\PopupNotice;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PopupNoticePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        if ($user->hasPermissionTo('popup-notice.viewAny')) {
            return true;
        }
    }

    public function view(User $user, PopupNotice $popupNotice)
    {
        if ($user->hasPermissionTo('popup-notice.viewAny')) {
            return true;
        }
    }

    public function create(User $user)
    {
        if ($user->hasPermissionTo('popup-notice.create')) {
            return true;
        }
    }

    public function update(User $user, PopupNotice $popupNotice)
    {
        if ($user->hasPermissionTo('popup-notice.update')) {
            return true;
        }
    }

    public function delete(User $user, PopupNotice $popupNotice)
    {
        if ($user->hasPermissionTo('popup-notice.delete')) {
            return true;
        }
    }

    public function restore(User $user, PopupNotice $popupNotice)
    {
        if ($user->hasPermissionTo('popup-notice.update')) {
            return true;
        }
    }

    public function forceDelete(User $user, PopupNotice $popupNotice)
    {
        if ($user->hasPermissionTo('popup-notice.delete')) {
            return true;
        }
    }
}
