<?php

namespace App\Exports;

use App\Models\Employees;
use App\Models\EmployeesTasks;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkOrderAccountingExportCSV implements FromCollection, WithHeadings, WithStyles
{
    protected $data;
    protected $startDate;
    protected $endDate;

    public function __construct($data, $startDate, $endDate)
    {
        $this->data = $data;
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }


    public function collection()
    {
        $report = collect($this->data);
        $startDate = collect($this->startDate);
        $endDate = collect($this->endDate);

        foreach ($report as $item) {
            // Convert $item to object
            $item = (object) $item;

            // Fetch tasks for the current item using OprID and EmployeeID
            $item->tasks = EmployeesTasks::where('OprID', $item->OprID)
                ->whereBetween('tblemployeestasks.TaskDateStart', [$startDate[0] . ' 00:00:00', $endDate[0] . ' 23:59:59'])
                ->get();

            // Initialize total duration in minutes
            $totalDuration = 0;

            foreach ($item->tasks as $task) {
                $taskStartDate = Carbon::parse($task->TaskDateStart);
                $taskEndDate = Carbon::parse($task->TaskDateEnd);
                $task->durationInSeconds = $taskEndDate->diffInSeconds($taskStartDate);

                // Add the task duration to the total duration
                $totalDuration += $task->durationInSeconds;
            }

            $item->totalDurationInSeconds = $totalDuration;
        }

        // Sesuaikan data sebelum diekspor
        $formattedData = [];

        foreach ($report as $item) {
            foreach ($item->tasks as $task) {
                $formattedData[] = [
                    'empid' => $item->EmployeeID ?? null,
                    'wonum' => $item->WOnborig ?? null,
                    'taskid' => $this->getTaskID($item->Workcenter ?? null),
                    'wosiecode' => $this->getWOSieCode($item->Workcenter ?? null),
                    'TaskDateStart' => $task->TaskDateStart ?? null,
                    'TaskDateEnd' => $task->TaskDateEnd ?? null,
                    'period' => floor($task->durationInSeconds * 1),
                    'worktype' => 'PR',
                    // Add other columns as needed
                ];
            }
        }

        return collect($formattedData);
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
            'empid',
            'wonum',
            'taskid',
            'wosiecode',
            'TaskDateStart',
            'TaskDateEnd',
            'period',
            'worktype',
            // ... tambahkan judul kolom lain yang Anda perlukan
        ];
    }

    protected function formatTotalDuration($seconds)
    {
        return "{$seconds}";
    }

    protected function getDepartment($workcenter)
    {
        if (in_array($workcenter, ['TP01', 'TP02', 'TP03', 'TP04', 'TP05', 'TP06', 'TP07'])) {
            return 'PL 1';
        } elseif (in_array($workcenter, ['TP41', 'TP42', 'TP43', 'TP44', 'TP45', 'TP46', 'TP47'])) {
            return 'PL 2';
        } elseif (in_array($workcenter, ['TP51', 'TP52', 'TP53', 'TP54', 'TP55', 'TP56', 'TP57', 'TP58'])) {
            return 'PL 3';
        } elseif (in_array($workcenter, ['SP11', 'SP12', 'SP13'])) {
            return 'REPAIR';
        } elseif (in_array($workcenter, ['DP41', 'DP42', 'DP43', 'DP44', 'DP45'])) {
            return 'DRY TYPE';
        } elseif (in_array($workcenter, ['CP13', 'CP16', 'CP17', 'CP18'])) {
            return 'CTVT';
        }

        // Default value if no match is found
        return 'Unknown';
    }
    protected function getTaskID($workcenter)
    {
        if (in_array($workcenter, ['TP01', 'TP03', 'TP41', 'TP51', 'DP41'])) {
            return '402';
        } elseif (in_array($workcenter, ['TP02', 'DP42'])) {
            return '403';
        } elseif (in_array($workcenter, ['TP04'])) {
            return '410';
        } elseif (in_array($workcenter, ['TP05'])) {
            return '418';
        } elseif (in_array($workcenter, ['TP42'])) {
            return '408';
        } elseif (in_array($workcenter, ['TP45'])) {
            return '419';
        } elseif (in_array($workcenter, ['TP55'])) {
            return '420';
        } elseif (in_array($workcenter, ['TP06'])) {
            return '423 ';
        } elseif (in_array($workcenter, ['TP07', 'TP47'])) {
            return '427';
        } elseif (in_array($workcenter, ['TP43', 'TP44', 'TP53'])) {
            return '412';
        } elseif (in_array($workcenter, ['TP54'])) {
            return '413';
        } elseif (in_array($workcenter, ['TP46'])) {
            return '424';
        } elseif (in_array($workcenter, ['TP52'])) {
            return '409';
        } elseif (in_array($workcenter, ['TP56'])) {
            return '428';
        } elseif (in_array($workcenter, ['TP57'])) {
            return '434';
        } elseif (in_array($workcenter, ['SP11'])) {
            return '633';
        } elseif (in_array($workcenter, ['SP13'])) {
            return '634';
        } elseif (in_array($workcenter, ['SP12'])) {
            return '635';
        } elseif (in_array($workcenter, ['DP43'])) {
            return '312';
        } elseif (in_array($workcenter, ['DP44'])) {
            return '328';
        } elseif (in_array($workcenter, ['DP45'])) {
            return '329';
        } elseif (in_array($workcenter, ['CP13'])) {
            return '207';
        } elseif (in_array($workcenter, ['CP16'])) {
            return '219';
        } elseif (in_array($workcenter, ['CP17'])) {
            return '212';
        } elseif (in_array($workcenter, ['CP18'])) {
            return '213';
        }

        // Default value if no match is found
        return 'Unknown';
    }


    protected function getWOSieCode($workcenter)
    {
        if (in_array($workcenter, ['TP01', 'TP02', 'TP03', 'TP41', 'TP51', 'DP41', 'DP42'])) {
            return '411';
        } elseif (in_array($workcenter, ['TP42', 'TP52'])) {
            return '412';
        } elseif (in_array($workcenter, ['TP04', 'TP43', 'TP44', 'TP53', 'TP54'])) {
            return '413';
        } elseif (in_array($workcenter, ['TP05', 'TP45', 'TP55'])) {
            return '414';
        } elseif (in_array($workcenter, ['TP06', 'TP46', 'TP56'])) {
            return '415';
        } elseif (in_array($workcenter, ['TP07', 'TP47', 'TP57'])) {
            return '416';
        } elseif (in_array($workcenter, ['SP11', 'SP13'])) {
            return '601';
        } elseif (in_array($workcenter, ['SP12'])) {
            return '602';
        } elseif (in_array($workcenter, ['DP43'])) {
            return '302';
        } elseif (in_array($workcenter, ['DP44'])) {
            return '303';
        } elseif (in_array($workcenter, ['DP45'])) {
            return '306';
        } elseif (in_array($workcenter, ['CP13'])) {
            return '201';
        } elseif (in_array($workcenter, ['CP16'])) {
            return '208';
        } elseif (in_array($workcenter, ['CP17'])) {
            return '205';
        } elseif (in_array($workcenter, ['CP18'])) {
            return '206';
        }

        // Default value if no match is found
        return 'Unknown';
    }
}
