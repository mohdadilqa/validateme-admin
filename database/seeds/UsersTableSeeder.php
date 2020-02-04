<?php

use App\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    public function run()
    {
        $users = [
            [
                'id'             => 1,
                'name'           => 'Superadmin',
                'email'          => 'superadmin@gmail.com',
                'password'       => '$2y$10$iz6WtVj69p/5JonFfuBRVO2LwrEGTJw3I6BqliWCbSmSF.5X9RPcu',
                'remember_token' => null,
                'created_at'     => '2019-09-13 19:21:30',
                'updated_at'     => '2019-09-13 19:21:30',
            ],
        ];

        foreach ($users as $user) {
            User::withTrashed()->updateOrCreate(['id' => $user['id']], $user)->restore();
        }
       // User::insert($users);
    }
}
