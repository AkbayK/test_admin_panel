<?php

namespace App\Policies;

use App\Models\Category\Category;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->isAdmin();
    }

    public function create(User $user)
    {
        return $user->isAdmin();
    }

    public function update(User $user, Category $category)
    {
        return $user->isAdmin();
    }

    public function delete(User $user, Category $category)
    {
        return $user->isAdmin();
    }
}
