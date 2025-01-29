<?php

namespace Database\Seeders;

use App\Models\Title;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TitleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Title::create([
            'title' => 'WAKIL DIREKTUR',
        ]);
        Title::create([
            'title' => 'KEPALA DEPT.',
        ]);
        Title::create([
            'title' => 'KEPALA DIVISI',
        ]);
        Title::create([
            'title' => 'KEPALA SEKSI',
        ]);
        Title::create([
            'title' => 'KEPALA BAGIAN',
        ]);
    }
}
