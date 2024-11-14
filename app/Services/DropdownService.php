<?php

namespace App\Services;

use App\Models\Department;
use App\Models\Project;
use App\Models\Role;
use App\User;

class DropdownService
{

    public function roleUser(){

        $roleUser = Role::get()->pluck('name', 'id');

        return $roleUser;

    }

}
