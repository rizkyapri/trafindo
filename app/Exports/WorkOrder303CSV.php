<?php

namespace App\Exports;

use App\Models\Employees;
use App\Models\EmployeesTasks;
use App\Models\WOOpr;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use Maatwebsite\Excel\Facades\Excel;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;

class WorkOrder303CSV implements FromCollection, WithHeadings, WithStyles
{
    protected $daterange;
    protected $WOnborig;

    public function __construct($daterange, $WOnborig)
    {
        $this->daterange = $daterange;
        $this->WOnborig = $WOnborig;
    }


    public function collection()
    {
        // Inisialisasi tanggal awal dan akhir
        $startDate = $endDate = null;

        // Periksa apakah " to " ada dalam string
        if (strpos($this->daterange, ' to ') !== false) {
            // Pisahkan tanggal awal dan tanggal akhir dari string rentang tanggal
            list($startDate, $endDate) = explode(' to ', $this->daterange);
        } else {
            // Jika hanya ada satu tanggal, gunakan tanggal yang sama untuk kedua variabel
            $startDate = $endDate = $this->daterange;
        }
        // Inisialisasi array untuk menyimpan data yang akan diekspor
        $exportData = [];

        foreach ($this->WOnborig as $wo) {
            // Query data untuk setiap WOnborig
            $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tblemployeestasks', 'tblemployeestasks.OprID', '=', 'tblwoopr.id')
                ->join('tblemployees', 'tblemployees.id', '=', 'tblemployeestasks.EmployeeID')
                ->whereBetween('tblemployeestasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('tblwo.WOnborig', $wo)
                ->select('tblwo.WOnborig', 'tblwo.*', 'tblwoopr.*', 'tblemployeestasks.*', 'tblemployeestasks.EmployeeID as EmployeeIDtasks', 'tblemployees.Name', 'tblemployees.EmployeeNumber')
                ->groupBy('tblemployeestasks.OprID')
                ->get();

            // dd($this->WOnborig);

            foreach ($report as $item) {
                $item = (object) $item;

                // Fetch tasks for the current item using OprID and EmployeeID
                $item->tasks = EmployeesTasks::where('OprID', $item->OprID)
                    ->whereBetween('tblemployeestasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                    ->get();

                // dd($item, $startDate, $endDate, $item->tasks,$item->TaskDateStart);

                // Initialize total duration in minutes
                $totalDuration = 0;

                foreach ($item->tasks as $task) {
                    $taskStartDate = Carbon::parse($task->TaskDateStart);
                    $taskEndDate = Carbon::parse($task->TaskDateEnd);
                    $task->durationInSeconds = $taskEndDate->diffInSeconds($taskStartDate);

                    // Add the task duration to the total duration
                    $totalDuration += $task->durationInSeconds;
                }

                // Convert total duration to hours and minutes
                $item->totalDurationInSeconds = $totalDuration;
            }
            // Format dan tambahkan data ke array ekspor

            foreach ($report as $item) {
                foreach ($item->tasks as $task) {
                    $exportData[] = [
                        'empid' => $item->EmployeeID ?? null,
                        'wonum' => $item->WOnborig ?? null,
                        'taskid' => $this->getTaskID($item->Workcenter ?? null),
                        'wosiecode' => $this->getWOSieCode($item->Workcenter ?? null),
                        'TaskDateStart' => $item->TaskDateStart ?? null,
                        'TaskDateEnd' => $item->TaskDateEnd ?? null,
                        'period' => floor($task->durationInSeconds * 1),
                        'worktype' => 'PR',
                        // Add other columns as needed
                    ];
                }
            }
        }

        // Return the processed data as a collection
        return collect($exportData);
    }

    // ...

    // Ekspor data ke dalam format yang diinginkan

    // foreach ($WOnborig as $wo) {
    //     $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
    //         ->join('tblemployeestasks', 'tblemployeestasks.OprID', '=', 'tblwoopr.id')
    //         ->join('tblemployees', 'tblemployees.id', '=', 'tblemployeestasks.EmployeeID')
    //         ->whereBetween('tblemployeestasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
    //         ->where('tblwo.WOnborig', $wo)
    //         ->select('tblwo.*', 'tblwoopr.*', 'tblemployeestasks.*', 'tblemployeestasks.EmployeeID as EmployeeIDtasks', 'tblemployees.Name', 'tblemployees.EmployeeNumber')
    //         ->groupBy('tblemployeestasks.OprID')
    //         ->get();
    //     foreach ($report as $item) {
    //         // dd($item, $woopr);
    //         // Convert $item to object
    //         $item = (object) $item;

    //         // Fetch tasks for the current item using OprID and EmployeeID
    //         $tasks = EmployeesTasks::where('OprID', $item->OprID)
    //             ->where('TaskDateStart', '=', $item->TaskDateStart)
    //             ->get();

    //         // Initialize total duration in minutes
    //         $totalDuration = 0;

    //         foreach ($tasks as $task) {
    //             $taskStartDate = Carbon::parse($task->TaskDateStart);
    //             $taskEndDate = Carbon::parse($task->TaskDateEnd);
    //             $task->duration = $taskEndDate->diffInMinutes($taskStartDate);

    //             // Add the task duration to the total duration
    //             $totalDuration += $task->duration;
    //         }

    //         // Convert total duration to hours and minutes
    //         $totalDurationInHours = floor($totalDuration / 60);
    //         $totalDurationInMinutes = $totalDuration % 60;

    //         // Store the total duration in the item
    //         $item->totalDurationInHours = $totalDurationInHours;
    //         $item->totalDurationInMinutes = $totalDurationInMinutes;
    //     }

    //     // Sesuaikan data sebelum diekspor
    //     $formattedData = $report->map(function ($item) {
    //         return [
    //             'WOnborig' => $item->WOnborig ?? null,
    //             'Department' => $this->getDepartment($item->Workcenter ?? null),
    //             'Workcenter' => $item->Workcenter ?? null,
    //             'Qty' => $item->WOqty ?? null,
    //             'Jam Kerja' => $this->formatTotalDuration($item->totalDurationInHours, $item->totalDurationInMinutes),
    //             'NIK' => $item->EmployeeNumber ?? null,
    //             'Name' => $item->Name ?? null,
    //             // ... tambahkan kolom lain yang Anda perlukan
    //         ];
    //     });


    //     return $formattedData;
    //     }
    // }

    // public function collection()
    // {
    //     $report = collect($this->data);

    //     foreach ($report as $item) {
    //         // Convert $item to object
    //         $item = (object) $item;

    //         $item->tasks = EmployeesTasks::where('OprID', $item->OprID)->get();

    //         // Initialize total duration in minutes
    //         $totalDuration = 0;

    //         foreach ($item->tasks as $task) {
    //             $taskStartDate = Carbon::parse($task->TaskDateStart);
    //             $taskEndDate = Carbon::parse($task->TaskDateEnd);
    //             $task->duration = $taskEndDate->diffInMinutes($taskStartDate);

    //             // Add the task duration to the total duration
    //             $totalDuration += $task->duration;
    //         }

    //         // Convert total duration to hours and minutes
    //         $totalDurationInHours = floor($totalDuration / 60);
    //         $totalDurationInMinutes = $totalDuration % 60;

    //         // Store the total duration in the item
    //         $item->totalDurationInHours = $totalDurationInHours;
    //         $item->totalDurationInMinutes = $totalDurationInMinutes;
    //     }
    //     // Sesuaikan data sebelum diekspor
    //     $formattedData = collect($this->data)->map(function ($item) {

    //         return [
    //             'WOnborig' => $item['WOnborig'],
    //             'Department' => $this->getDepartment($item['Workcenter']),
    //             'Workcenter' => $item['Workcenter'],
    //             'WOqty' => $item['WOqty'],
    //             'Jam Kerja' => $item->formattedTotalDuration,
    //             'NIK' => $item['EmployeeNumber'],
    //             'Name' => $item['Name'],
    //             // ... tambahkan kolom lain yang Anda perlukan
    //         ];
    //     });

    //     return $formattedData;
    // }

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
