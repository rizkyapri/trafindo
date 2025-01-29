<?php

namespace App\Imports;

use App\Models\WOOpr;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Validators\ValidationException;

HeadingRowFormatter::default('none');
class WoOprImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
     * @param Collection $collection
     */
    public function model(array $row)
    {
        return new WOOpr([
            'OprNumber' => $row['OprNumber'],
            'OprName' => $row['OprName'],
            // 'EmployeeID' => $row['EmployeeID'],
            'OprPlanBegin' => Date::excelToDateTimeObject($row['WOBeginDate']),
            'OprPlanEnd' => Date::excelToDateTimeObject($row['WOEndDate']),
            'Workcenter' => $row['Workcenter'],
            'OprBeginDate' => Date::excelToDateTimeObject($row['OprBeginDate']),
            'OprEndDate' => Date::excelToDateTimeObject($row['OprEndDate']),
            'StdSetupTime' => $row['StdSetupTime'],
            'StdRunTime' => $row['StdRunTime'],
            // 'StdSetupTime' => Date::excelToDateTimeObject($row['StdSetupTime']),
            // 'StdRunTime' => Date::excelToDateTimeObject($row['StdRunTime']),
            // 'Stdhrs' =>  $row['Stdhrs'],
            // 'WOID' => $row['WOID'],
            'OprStatus' => $row['OprStatus']
            // 'Oprnote1' => $row['WOnote'],
            // 'created_at' => $row['created_at'],
            // 'updated_at' => $row['updated_at']
        ]);
    }
    
}
