<?php

namespace App\Exports;

use App\Models\AndonCategory;
use App\Models\Employees;
use App\Models\User;
use App\Models\AndonNo;
use Carbon\Carbon;
use App\Models\Andon;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class AndonHistoryExport implements FromCollection, WithHeadings, WithStyles
{
    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    public function collection()
    {
        return $this->data;
    }

    public function styles(Worksheet $sheet): array
    {
        return [
            '1' => ['font' => ['bold' => true, 'color' => ['rgb' => 'FFFFFF'],], 'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['rgb' => '016A70']]],
            // Adjust the '1' to the corresponding row number of your header row
        ];
    }

    public function headings(): array
    {
        // Sesuaikan judul kolom
        return [
            'id',
            'Andon_No',
            'Andon_Serie',
            'Guard_ID',
            'Guard_Name',
            'Guard_HPWA',
            'Workcenter',
            'RiseUp_EmployeeNo',
            'RiseUp_EmployeeName',
            'RiseUp_OprNo',
            'DescriptionProblem',
            'AndonDateOpen',
            'AndonDateReceived',
            'Received_EmployeeID',
            'DescriptionSolving',
            'AndonDateSolving',
            'Solved_EmployeeID',
            'AndonDateAccepted',
            'Solving_Score',
            'AndonRemark',
            'AndonDateClosed',
            'created_at',
            'updated_at'
            // ... tambahkan judul kolom lain yang Anda perlukan
        ];
    }
}
