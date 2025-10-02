<?php

namespace App\Policies;

use App\Enums\TicketStatusEnum;
use App\Models\Ticket;
use App\Models\User;

class TicketPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return true;
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Ticket $ticket): bool
    {
        // jika admin maka true,
        if ($user->hasRole('admin')) {
            return true;
        }

        // jika user adalah author maka true
        return $ticket->user_id === $user->id;
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        // admin jangan bikin
        return $user->hasRole('admin') ? false : true;
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Ticket $ticket): bool
    {
        return ($ticket->status === TicketStatusEnum::DRAFT->value || $ticket->status === TicketStatusEnum::SUBMITTED->value) && $ticket->user_id === $user->id;
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Ticket $ticket): bool
    {
        // boleh dihapus jika status adalah draft atau submitted
        // yg boleh hapus adalah author atau admin
        return ($ticket->status === TicketStatusEnum::DRAFT->value || $ticket->status === TicketStatusEnum::SUBMITTED->value) && ($ticket->user_id === $user->id || $user->hasRole('admin'));
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Ticket $ticket): bool
    {
        return false;
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Ticket $ticket): bool
    {
        return false;
    }
}
