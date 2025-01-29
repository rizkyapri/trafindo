<?php

namespace App\Exports;

use App\Models\Employees;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class EmployeeReportExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    public function collection()
    {
        // return Employees::select('id', 'Name', 'EmployeeNumber', 'DepartmentName', 'Title', 'Photograph', 'Notes', 'InProgress')->get();
        return Employees::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Name',
            'EmployeeNumber',
            'DepartmentName',
            'Title', 
            'Photograph',
            'Notes',
            'Progress',
            'created_at',
            'updated_at'
        ];
    }
}
