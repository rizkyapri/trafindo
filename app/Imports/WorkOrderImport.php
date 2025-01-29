<?php

namespace App\Imports;

use App\Models\WO;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;
use Maatwebsite\Excel\Imports\HeadingRowFormatter;
use PhpOffice\PhpSpreadsheet\Shared\Date;
use Maatwebsite\Excel\Concerns\SkipsEmptyRows;
use Maatwebsite\Excel\Validators\ValidationException;

HeadingRowFormatter::default('none');
class WorkOrderImport implements ToModel, WithHeadingRow, SkipsEmptyRows
{
    /**
     * @param array $row
     *
     * @return \Illuminate\Database\Eloquent\Model|null
     */
    public function model(array $row)
    {
        return new WO ([
            'WONumber' => $row['WONumber'],
            // 'WOName' => $row['WOName'],
            // 'WODescription' => $row['WODescription'],
            'WOBeginDate' => Date::excelToDateTimeObject($row['WOBeginDate']),
            'WOEndDate' => Date::excelToDateTimeObject($row['WOEndDate']),
            'WOStatus' => $row['WOStatus'],
            // 'IDMFG' =>  $row['IDMFG'],
            'WOnborig' => $row['WOnborig'],
            'FGnborig' => $row['FGnborig'],
            'BOMnborig' => $row['BOMnborig'],
            'WOqty' => $row['WOqty'],
            'WOnote' => $row['WOnote'],
            // 'created_at' => $row['created_at'],
            // 'updated_at' => $row['updated_at']
            // 'BOM' => $row['bom'],
            // 'BRG' =>  $row['brg'],
            // 'qty' => $row['qty'],
            // 'stn' => $row['stn'],
            // 'wc' => $row['wc'],
          
        ]);
    }
    
}
