<?php

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeed extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        Role::create([
            'name' => 'Super Admin'
        ]);

        Role::create([
            'name' => 'Admin'
        ]);
    }
}
