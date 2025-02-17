<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Database\RoleSeeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
        ]);
    }
}
