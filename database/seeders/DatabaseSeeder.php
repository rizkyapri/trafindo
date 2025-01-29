<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Database\Seeders\UserSeeder;
use Database\Seeders\DepartmentSeeder;
use Database\Seeders\TitleSeeder;
use Database\Seeders\AndonCategorySeeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            AndonCategorySeeder::class,
            DepartmentSeeder::class,
            TitleSeeder::class,
            RoleSeeder::class,
            UserSeeder::class,
        ]);
    }
}
