<?php

use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $super_admin = factory('App\User')->create([
            'name' => 'CCPM_SUPER_ADMIN',
            'email' => 'ccpm@mormal.com',
            'password' => \Illuminate\Support\Facades\Hash::make('temporary_password')
        ]);
        $super_admin->addRole('super_admin');
    }
}
