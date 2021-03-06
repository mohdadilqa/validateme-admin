<?php

use App\Role;
use Illuminate\Database\Seeder;

class RolesTableSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            [
                'id'         => 1,
                'title'      => 'superadmin',
                'created_at' => '2019-09-13 19:15:46',
                'updated_at' => '2019-09-13 19:15:46',
            ],
            [
                'id'         => 2,
                'title'      => 'support staff',
                'created_at' => '2019-09-13 19:15:46',
                'updated_at' => '2019-09-13 19:15:46',
            ],
            [
                'id'         => 3,
                'title'      => 'company admin',
                'created_at' => '2019-09-13 19:15:46',
                'updated_at' => '2019-09-13 19:15:46',
            ],
        ];

        foreach ($roles as $role) {
            Role::updateOrCreate(['id' => $role['id']], $role);
        }

        //Role::insert($roles);
    }
}
