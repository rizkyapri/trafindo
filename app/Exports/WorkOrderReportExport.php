<?php

namespace App\Exports;

use App\Models\WO;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;

class WorkOrderReportExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        // return WO::select('id', 'WONumber', 'WOName', 'WODescription', 'WOBeginDate', 'WOEndDate', 'WOStatus', 'IDMFG', 'WOnborig', 'FGnborig', 'BOMnborig', 'WOqty', 'WOnote')->get();
        return WO::all();
    }

    public function headings(): array
    {
        return [
            'ID',
            'WONumber',
            'WOName',
            'WODescription',
            'WOBeginDate',
            'WOEndDate',
            'WOStatus',
            'IDMFG',
            'WOnborig',
            'FGnborig',
            'BOMnborig',
            'WOqty',
            'WOnote',
            'created_at',
            'updated_at'
        ];
    }
}
