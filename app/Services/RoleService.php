<?php

namespace App\Services;

use App\Models\Role;

class RoleService
{
    public function getList() : array
    {
        $query = Role::query();

        return $query->pluck('nama','id')->toArray();
    }
}