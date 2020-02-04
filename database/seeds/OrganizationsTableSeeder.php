<?php

use App\Organization;
use Illuminate\Database\Seeder;

class OrganizationsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $organizations=[
            [
                'id'      =>1,
                'organization_name'    =>'QA InfoTech',
                'organization_domain'  =>'qainfotech.com',
                'organization_email'  =>'qainfotech.com@validateme.online',
                'created_at'=> '2020-01-01 19:21:30',
                'updated_at'=> '2020-01-01 19:21:30',

            ],
            [
                'id'      =>2,
                'organization_name'    =>'Adobe',
                'organization_domain'  =>'adobe.com',
                'organization_email'  =>'adobe.com@validateme.online',
                'created_at'=> '2020-01-01 19:21:30',
                'updated_at'=> '2020-01-01 19:21:30',

            ]
        ];

        foreach ($organizations as $organization) {
            Organization::updateOrCreate(['id' => $organization['id']], $organization);
        }
    }
}
