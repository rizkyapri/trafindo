<?php

namespace Database\Seeders;

use App\Models\AndonCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AndonCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        AndonCategory::create([
            'CodeAndon' => 'A',
            'CategoryProblem' => 'MATERIAL',
            'AssignTo' => 'Gudang Utama',
            'Guard_EmployeeID' => 163,
            'ContactPerson' => 'ARISMANTO SUTEDI',
            'HP_WA' => '085715380300',
            'Sirene' => '0',
            'AndonSerie' => NULL,
        ]);
        AndonCategory::create([
            'CodeAndon' => 'B',
            'CategoryProblem' => 'GAMBAR/DESAIN',
            'AssignTo' => 'Design Engineering',
            'Guard_EmployeeID' => 209,
            'ContactPerson' => 'M. SHOHIBUL KAHFI',
            'HP_WA' => '081586715760',
            'Sirene' => '0',
            'AndonSerie' => NULL,
        ]);
        AndonCategory::create([
            'CodeAndon' => 'C',
            'CategoryProblem' => 'MESIN & TOOL',
            'AssignTo' => 'Maintenance',
            'Guard_EmployeeID' => 184,
            'ContactPerson' => 'PAULUS MARYADI',
            'HP_WA' => '085289019262',
            'Sirene' => '0',
            'AndonSerie' => NULL,
        ]);
        AndonCategory::create([
            'CodeAndon' => 'D',
            'CategoryProblem' => 'OPERATOR',
            'AssignTo' => 'Produksi',
            'Guard_EmployeeID' => 55,
            'ContactPerson' => 'SUPRIYONO',
            'HP_WA' => '081281402695',
            'Sirene' => '0',
            'AndonSerie' => NULL,
        ]);
        AndonCategory::create([
            'CodeAndon' => 'E',
            'CategoryProblem' => 'SAFETY',
            'AssignTo' => 'Team K3',
            'Guard_EmployeeID' => 238,
            'ContactPerson' => 'SUHARGO',
            'HP_WA' => '081386747422',
            'Sirene' => '0',
            'AndonSerie' => NULL,
        ]);
        AndonCategory::create([
            'CodeAndon' => 'F',
            'CategoryProblem' => 'QUALITY',
            'AssignTo' => 'Quality Team',
            'Guard_EmployeeID' => 129,
            'ContactPerson' => 'AHMAD SUJARWO',
            'HP_WA' => '081510506156',
            'Sirene' => '0',
            'AndonSerie' => NULL,
        ]);

    }
}
