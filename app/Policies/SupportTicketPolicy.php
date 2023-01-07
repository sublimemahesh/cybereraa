<?php

namespace App\Policies;

use App\Models\SupportTicket;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class SupportTicketPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->getRoleNames()->first() === 'admin';
    }

    public function lowPriority(User $user, SupportTicket $ticket)
    {
        return $ticket->support_ticket_priority_id !== 1 && $user->getRoleNames()->first() === 'admin';
    }

    public function mediumPriority(User $user, SupportTicket $ticket)
    {
        return $ticket->support_ticket_priority_id !== 2 && $user->getRoleNames()->first() === 'admin';
    }

    public function highPriority(User $user, SupportTicket $ticket)
    {
        return $ticket->support_ticket_priority_id !== 3 && $user->getRoleNames()->first() === 'admin';
    }

    public function close(User $user, SupportTicket $ticket)
    {
        return $ticket->support_ticket_status_id !== 3 &&
            ($user->getRoleNames()->first() === 'admin' || ($ticket->user_id === $user->id));
    }

    public function reopen(User $user, SupportTicket $ticket)
    {
        return $ticket->support_ticket_status_id !== 1 &&
            ($user->getRoleNames()->first() === 'admin' || ($ticket->user_id === $user->id));
    }

    public function view(User $user, SupportTicket $ticket)
    {
        return $user->getRoleNames()->first() === 'admin' || ($ticket->user_id === $user->id);
    }

    public function create(User $user)
    {
        $allowed = ['user'];
        return in_array($user->getRoleNames()->first(), $allowed, true);
    }

    public function update(User $user, SupportTicket $ticket)
    {
        return $ticket->user_id === $user->id;
    }

    public function delete(User $user, SupportTicket $ticket)
    {
        return $ticket->user_id === $user->id;
    }

    public function restore(User $user, SupportTicket $ticket)
    {
        return $ticket->user_id === $user->id || $user->getRoleNames()->first() === 'super_admin';
    }

    public function forceDelete(User $user, SupportTicket $ticket)
    {
        return $user->getRoleNames()->first() === 'super_admin';
    }
}
