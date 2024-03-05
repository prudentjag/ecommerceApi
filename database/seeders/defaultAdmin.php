<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class defaultAdmin extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create(
            [
                'username' => 'admin',
                'email' => 'admin@jf.com',
                'password' => bcrypt('testpassword'),
                'role' => 'admin',
            ]
        );
    }
}
