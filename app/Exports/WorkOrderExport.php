<?php

namespace App\Exports;


use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class WorkOrderExport implements WithHeadings
{
    /**
    * @return \Illuminate\Support\Collection
    */

    public function headings(): array
    {
        return ["Name", "EmployeeNumber", "DepartmentName", "Title", "Photograph", "Notes", "InProgress", "created_at", "update_at"];
    }
}
