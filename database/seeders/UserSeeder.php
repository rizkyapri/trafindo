<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;


class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Admin
        $user = User::create([
            'role_id' => 1,
            'Username' => 'Admin',
            'password' => Hash::make('admin'),
        ]);

        // Staff
        $user = User::create([
            'role_id' => 2,
            'andoncat_id' => 1,
            'Username' => 'Andon',
            'password' => Hash::make('andon'),
        ]);
        $user = User::create([
            'role_id' => 3,
            'Username' => 'Accounting',
            'password' => Hash::make('accounting'),
        ]);
        $user = User::create([
            'role_id' => 2,
            'andoncat_id' => 1,
            'Username' => 'andonmaterial',
            'password' => Hash::make('andonmaterial'),
        ]);
        $user = User::create([
            'role_id' => 2,
            'andoncat_id' => 2,
            'Username' => 'andondesain',
            'password' => Hash::make('andondesain'),
        ]);
        $user = User::create([
            'role_id' => 2,
            'andoncat_id' => 3,
            'Username' => 'andonmesin',
            'password' => Hash::make('andonmesin'),
        ]);
        $user = User::create([
            'role_id' => 2,
            'andoncat_id' => 4,
            'Username' => 'andonoperator',
            'password' => Hash::make('andonoperator'),
        ]);
        $user = User::create([
            'role_id' => 2,
            'andoncat_id' => 5,
            'Username' => 'andonsafety',
            'password' => Hash::make('andonsafety'),
        ]);
        $user = User::create([
            'role_id' => 2,
            'andoncat_id' => 6,
            'Username' => 'andonquality',
            'password' => Hash::make('andonquality'),
        ]);

        // User::create([
        //     'Username' => 'admin',
        //     'Password' => Hash::make('admin'),
        // ]);
    }
}
