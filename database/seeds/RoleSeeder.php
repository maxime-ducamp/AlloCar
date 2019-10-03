<?php

use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory('App\Role')->create(['name' => 'admin']);
        factory('App\Role')->create(['name' => 'super_admin']);
        factory('App\Role')->create(['name' => 'moderator']);
    }
}
