<?php

namespace Database\Seeders;

use App\Models\Department;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DepartmentSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Department::create([
        //     'name' => 'PL 0',
        //     'name' => 'PL 1',
        //     'name' => 'PL 2',
        //     'name' => 'PL 3',
        //     'name' => 'REPAIR',
        //     'name' => 'PROSES MATERIAL',
        //     'name' => 'QA',
        //     'name' => 'QC TRAFO',
        //     'name' => 'INVENTORY TRAFO',
        //     'name' => 'MAINTENANCE',
        //     'name' => 'PROJECT ENG TRAFO',
        //     'name' => 'DESIGN ENG TRAFO',
        //     'name' => 'PPIC TRAFO',
        //     'name' => 'MR',
        //     'name' => 'PRO. DRY TYPE',
        // ]);
        Department::create([
            'name' => 'PL 1',
        ]);
        Department::create([
            'name' => 'PL 2',
        ]);
        Department::create([
            'name' => 'PL 3',
        ]);
        Department::create([
            'name' => 'REPAIR',
        ]);
        Department::create([
            'name' => 'PROSES MATERIAL',
        ]);
        Department::create([
            'name' => 'QA',
        ]);
        Department::create([
            'name' => 'QC TRAFO',
        ]);
        Department::create([
            'name' => 'INVENTORY TRAFO',
        ]);
        Department::create([
            'name' => 'MAINTENANCE',
        ]);
        Department::create([
            'name' => 'PROJECT ENG TRAFO',
        ]);
        Department::create([
            'name' => 'DESIGN ENG TRAFO',
        ]);
        Department::create([
            'name' => 'PPIC TRAFO',
        ]);
        Department::create([
            'name' => 'MR',
        ]);
        Department::create([
            'name' => 'PRO. DRY TYPE',
        ]);
    }
}
