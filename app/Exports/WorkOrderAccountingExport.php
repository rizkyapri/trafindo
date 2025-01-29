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

class WorkOrderAccountingExport implements FromCollection, WithHeadings, WithStyles
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

            // dd($item, $startDate, $endDate, $item->tasks);
            // Initialize total duration in minutes
            $totalDuration = 0;

            foreach ($item->tasks as $task) {
                $taskStartDate = Carbon::parse($task->TaskDateStart);
                $taskEndDate = Carbon::parse($task->TaskDateEnd);
                $task->duration = $taskEndDate->diffInMinutes($taskStartDate);

                // Add the task duration to the total duration
                $totalDuration += $task->duration;
            }

            // Convert total duration to hours and minutes
            $totalDurationInHours = floor($totalDuration / 60);
            $totalDurationInMinutes = $totalDuration % 60;

            // Store the total duration in the item
            $item->totalDurationInHours = $totalDurationInHours;
            $item->totalDurationInMinutes = $totalDurationInMinutes;
        }

        // Sesuaikan data sebelum diekspor
        $formattedData = [];

        foreach ($report as $item) {
            foreach ($item->tasks as $task) {
                $formattedData[] = [
                    'WOnborig' => $item->WOnborig ?? null,
                    'Department' => $this->getDepartment($item->Workcenter ?? null),
                    'Workcenter' => $item->Workcenter ?? null,
                    'Qty' => $item->WOqty ?? null,
                    'Jam Kerja' => floor($task->duration / 60) . ' H ' . ($task->duration % 60) . ' M',
                    'NIK' => $task->employees->EmployeeNumber ?? null,
                    'Name' => $task->employees->Name ?? null,
                    // Add other columns as needed
                ];
            }
        }

        return collect($formattedData);
    }

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
            'Work Order',
            'Department',
            'Workcenter',
            'Qty',
            'Jam Kerja',
            'NIK',
            'Name',
            // ... tambahkan judul kolom lain yang Anda perlukan
        ];
    }

    // public function map($row): array
    // {
    //     // Make sure $row is an object, not an array
    //     $row = (object) $row;

    //     // Check if OprID property exists
    //     $oprId = property_exists($row, 'OprID') ? $row->OprID : null;

    //     // Initialize total duration in minutes
    //     $totalDuration = 0;

    //     // Fetch tasks for the current item using OprID
    //     $tasks = EmployeesTasks::where('OprID', $oprId)->get();

    //     foreach ($tasks as $task) {
    //         $taskStartDate = Carbon::parse($task->TaskDateStart);
    //         $taskEndDate = Carbon::parse($task->TaskDateEnd);
    //         $task->duration = $taskEndDate->diffInMinutes($taskStartDate);

    //         // Add the task duration to the total duration
    //         $totalDuration += $task->duration;
    //     }

    //     // Convert total duration to hours and minutes
    //     $totalDurationInHours = floor($totalDuration / 60);
    //     $totalDurationInMinutes = $totalDuration % 60;

    //     // Store the total duration in the item
    //     $row->totalDurationInHours = $totalDurationInHours;
    //     $row->totalDurationInMinutes = $totalDurationInMinutes;

    //     return [
    //         'Work Order' => $row->WOnborig ?? null,
    //         'Department' => $this->getDepartment($row->Workcenter ?? null),
    //         'Workcenter' => $row->Workcenter ?? null,
    //         'Qty' => $row->WOqty ?? null,
    //         'Jam Kerja' => $this->formatTotalDuration($row->totalDurationInHours, $row->totalDurationInMinutes),
    //         'NIK' => $row->EmployeeNumber ?? null,
    //         'Name' => $row->Name ?? null,
    //     ];
    // }


    // public function map($row): array
    // {
    //     $report = collect($this->data);
    //     foreach ($report as $item) {
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

    //     return [
    //         'Work Order' => $row['WOnborig'],
    //         'Department' => $this->getDepartment($row['Workcenter']),
    //         'Workcenter' => $row['Workcenter'],
    //         'Qty' => $row['WOqty'],
    //         'Jam Kerja' => $this->formatTotalDuration(floor($task->duration / 60), $task->duration % 60),
    //         'NIK' => $row['EmployeeNumber'],
    //         'Name' => $row['Name'],
    //     ];
    // }


    protected function formatTotalDuration($hours, $minutes)
    {
        return "{$hours} H {$minutes} M";
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
        } elseif (in_array($workcenter, ['CP13', 'CP17', 'CP17', 'CP18'])) {
            return 'CTVT';
        }

        // Default value if no match is found
        return 'Unknown';
    }
}
