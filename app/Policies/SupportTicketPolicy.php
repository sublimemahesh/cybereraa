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
        if ($user->hasPermissionTo('support_ticket.viewAny')) {
            return true;
        }
    }

    public function lowPriority(User $user, SupportTicket $ticket)
    {
        if ($ticket->support_ticket_priority_id === 1) {
            return false;
        }

        if ($user->hasPermissionTo('support_ticket.lowPriority')) {
            return true;
        }
    }

    public function mediumPriority(User $user, SupportTicket $ticket)
    {
        if ($ticket->support_ticket_priority_id === 2) {
            return false;
        }
        if ($user->hasPermissionTo('support_ticket.mediumPriority')) {
            return true;
        }
    }

    public function highPriority(User $user, SupportTicket $ticket)
    {
        if ($ticket->support_ticket_priority_id === 3) {
            return false;
        }
        if ($user->hasPermissionTo('support_ticket.highPriority')) {
            return true;
        }

    }

    public function close(User $user, SupportTicket $ticket)
    {
        if ($ticket->support_ticket_status_id === 3) {
            return false;
        }
        if ($ticket->user_id === $user->id || $user->hasPermissionTo('support_ticket.close')) {
            return true;
        }
    }

    public function reopen(User $user, SupportTicket $ticket)
    {
        if ($ticket->support_ticket_status_id === 1) {
            return false;
        }
        if ($ticket->user_id === $user->id || $user->hasPermissionTo('support_ticket.reopen')) {
            return true;
        }
    }

    public function reply(User $user, SupportTicket $ticket)
    {

        if ($ticket->user_id === $user->id || $user->hasPermissionTo('support_ticket.reply')) {
            return true;
        }
    }

    public function view(User $user, SupportTicket $ticket)
    {
        if ($ticket->user_id === $user->id || $user->hasPermissionTo('support_ticket.viewAny')) {
            return true;
        }

    }

    public function create(User $user)
    {
        $allowed = ['user'];
        return $user->hasRole($allowed);
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
        return $ticket->user_id === $user->id || $user->hasRole('super_admin');
    }

    public function forceDelete(User $user, SupportTicket $ticket)
    {
        return $user->hasRole('super_admin');
    }
}
