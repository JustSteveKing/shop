<?php

declare(strict_types=1);

namespace App\Policies;

use Domains\Customer\Models\User;
use Domains\Customer\Models\Wishlist;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class WishlistPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user) : Response|bool
    {
        //
    }

    public function view(User $user, Wishlist $wishlist): Response|bool
    {
        if ($wishlist->public) {
            return true;
        }

        return $user->id === $wishlist->user_id;
    }

    public function create(User $user): Response|bool
    {
        //
    }

    public function update(User $user, Wishlist $wishlist): Response|bool
    {
        //
    }

    public function delete(User $user, Wishlist $wishlist): Response|bool
    {
        //
    }

    public function restore(User $user, Wishlist $wishlist): Response|bool
    {
        //
    }

    public function forceDelete(User $user, Wishlist $wishlist): Response|bool
    {
        //
    }
}
