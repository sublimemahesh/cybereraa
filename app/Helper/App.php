<?php

function authUserFolder(): string
{
    $folder = '';
    if (Auth::check()) {
        $roles = Auth::user()->getRoleNames()->toArray();
        if (in_array('user', $roles, true)) {
            $folder = 'user';
        } elseif (in_array('super_admin', $roles, true)) {
            $folder = 'super_admin';
        } else {
            $folder = 'admin';
        }
    }
    return $folder;
}