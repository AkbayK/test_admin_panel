<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $this->allowAdminAndManager($user);
    }

    public function view(User $user, Employee $employee)
    {
        return $this->allowAdminAndManager($user);
    }

    public function create(User $user)
    {
        return $this->allowAdminAndManager($user);
    }

    public function update(User $user, Employee $employee)
    {
        return $this->allowAdminAndManager($user);
    }

    public function delete(User $user, Employee $employee)
    {
        return $this->allowAdminAndManager($user);
    }

    private function allowAdminAndManager(User $user)
    {
        $allow = false;
        if ($user->isAdmin() || $user->isManager()) {
            $allow = true;
        }
        return $allow;
    }
}
