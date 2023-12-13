<?php

namespace Database\Seeders;

use App\Models\Admin;
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
        //
        Admin::create([
            'first_name' => 'admin',
            'last_name'  => 'admin',
            'email'      => 'admin@gmail.com',
            'role'       => 'Admin',
            'password'   => bcrypt('123456'),
        ]);
    }
}
