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
                'name'    =>'QAinfotech',
                'domain'  =>'https://qainfotech.com/',
                'created_at'     => '2020-01-01 19:21:30',
                'updated_at'     => '2020-01-01 19:21:30',

            ],
            [
                'id'      =>2,
                'name'    =>'Adobe',
                'domain'  =>'https://www.adobe.com/in/',
                'created_at'     => '2020-01-01 19:21:30',
                'updated_at'     => '2020-01-01 19:21:30',

            ]
        ];
        Organization::insert($organizations);
    }
}
