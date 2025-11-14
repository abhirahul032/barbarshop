<?php

namespace App\Policies;

use App\Models\Employee;
use App\Models\Stores;
use Illuminate\Auth\Access\HandlesAuthorization;

class EmployeePolicy
{
    use HandlesAuthorization;

    public function view(Stores $user, Employee $employee)
    {
        return $user->id === $employee->store_id;
    }

    public function update(Stores $user, Employee $employee)
    {
        return $user->id === $employee->store_id;
    }

    public function delete(Stores $user, Employee $employee)
    {
        return $user->id === $employee->store_id;
    }
}