<?php

namespace App\Http\Controllers;

use App\Models\Employees;
use App\Models\WO;
use App\Exports\EmployeeReportExport;
use App\Exports\WorkOrder303;
use App\Exports\WorkOrder303CSV;
use App\Exports\WorkOrderAccountingExport;
use App\Exports\WorkOrderAccountingExportCSV;
use Maatwebsite\Excel\Facades;
use App\Exports\WorkOrderReportExport;
use App\Models\Andon;
use App\Models\Department;
use App\Models\EmployeesTasks;
use App\Models\WOOpr;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;
use Barryvdh\DomPDF\Facade\Pdf;
use Yajra\DataTables\Facades\DataTables;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportController extends Controller
{
    public function index()
    {
        $woopr = WOOpr::with('department', 'employee');
        $department = null; // Inisialisasi variabel
        // dd($woopr);

        // $woopr = WOOpr::orderBy('Workcenter')->distinct()->pluck('Workcenter');
        return view('report.index', compact('woopr', 'department'));
    }

    public function report(Request $request)
    {
        $dateRange = $request->input('daterange');

        // Inisialisasi tanggal awal dan akhir
        $startDate = $endDate = null;

        // Periksa apakah " to " ada dalam string
        if (strpos($dateRange, ' to ') !== false) {
            // Pisahkan tanggal awal dan tanggal akhir dari string rentang tanggal
            list($startDate, $endDate) = explode(' to ', $dateRange);
        } else {
            // Jika hanya ada satu tanggal, gunakan tanggal yang sama untuk kedua variabel
            $startDate = $endDate = $dateRange;
        }
        $department = $request->input('department');
        $hours = $request->input('hours');

        // dd($hours,$startDate, $endDate, $department);


        if ($department === 'PL 1') {
            // dd($request->all());

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['TP01', 'TP02', 'TP03', 'TP04', 'TP05', 'TP06', 'TP07'])
                ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig') // Menggunakan GROUP BY pada kolom yang ingin dijadikan acuan
                ->get();

            return view('report.index', compact('woopr', 'dateRange', 'department',  'hours'));
        } elseif ($department === 'PL 2') {
            // dd($request->all());

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['TP41', 'TP42', 'TP43', 'TP44', 'TP45', 'TP46', 'TP47'])
                ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig') // Menggunakan GROUP BY pada kolom yang ingin dijadikan acuan
                ->get();

            return view('report.index', compact('woopr', 'dateRange', 'department', 'hours'));
        } elseif ($department === 'PL 3') {
            // dd($request->all());

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['TP51', 'TP52', 'TP53', 'TP54', 'TP55', 'TP56', 'TP57', 'TP58'])
                ->select('tblwo.WOnborig', 'tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig')
                ->get();



            // dd($woopr);

            return view('report.index', compact('woopr', 'dateRange', 'department',   'hours'));
        } elseif ($department === 'REPAIR') {
            // dd($request->all());

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['SP11', 'SP12', 'SP13'])
                ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig') // Menggunakan GROUP BY pada kolom yang ingin dijadikan acuan
                ->get();

            return view('report.index', compact('woopr', 'dateRange', 'department',   'hours'));
        } elseif ($department === 'DRY TYPE') {
            // dd($request->all());

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['DP41', 'DP42', 'DP43', 'DP44', 'DP45'])
                ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig') // Menggunakan GROUP BY pada kolom yang ingin dijadikan acuan
                ->get();

            return view('report.index', compact('woopr', 'dateRange', 'department',   'hours'));
        } elseif ($department === 'CTVT') {
            // dd($request->all());

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['CP13', 'CP17', 'CP17', 'CP18'])
                ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig') // Menggunakan GROUP BY pada kolom yang ingin dijadikan acuan
                ->get();

            return view('report.index', compact('woopr', 'dateRange', 'department',   'hours'));
        } else {
            return back()->with('error', 'Invalid Department or Date');
        }

        // dd($woopr,$startDate, $endDate,$department,$hours);

        // return view('report.index', compact('woopr', 'dateRange','department ,'hours'));
        // dd($startDate,$endDate,$department,$hours);
    }

    public function details($WOnborig, $date, $workcenter)
    {
        // INI DI GROUP BY
        // Misalnya $date adalah string '2023-02'
        // Inisialisasi tanggal awal dan akhir
        $startDate = $endDate = null;

        // Periksa apakah " to " ada dalam string
        if (strpos($date, ' to ') !== false) {
            // Pisahkan tanggal awal dan tanggal akhir dari string rentang tanggal
            list($startDate, $endDate) = explode(' to ', $date);
        } else {
            // Jika hanya ada satu tanggal, gunakan tanggal yang sama untuk kedua variabel
            $startDate = $endDate = $date;
        }
        // $yearAndMonth = explode('-', $date);

        $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
            ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
            ->join('tblEmployees', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
            ->whereBetween('tblEmployeesTasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('tblwo.WOnborig', $WOnborig)
            ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployeesTasks.EmployeeID as EmployeeIDtasks', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber')
            ->groupBy('tblEmployeesTasks.OprID')
            ->get();

        // dd($report, $date);

        foreach ($report as $item) {
            $item->tasks = EmployeesTasks::where('OprID', $item->OprID)
                ->whereBetween('tblEmployeesTasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->get();


            // dd($item->tasks);


            // $item->tasks = EmployeesTasks::where('TaskDateStart', $item->TaskDateStart)->get();

            // Initialize total duration in minutes
            $totalDuration = 0;

            foreach ($item->tasks as $task) {
                // dd($task);
                $taskStartDate = Carbon::parse($task->TaskDateStart);
                $taskEndDate = Carbon::parse($task->TaskDateEnd);
                $task->duration = $taskEndDate->diffInMinutes($taskStartDate);

                // Add the task duration to the total duration
                $totalDuration += $task->duration;
            }

            // Convert total duration to hours, seconds and minutes
            $totalDurationInHours = floor($totalDuration / 60);
            $totalDurationInMinutes = $totalDuration % 60;
            $totalDurationInSeconds = $totalDuration * 60;

            // Store the total duration in the item
            $item->totalDurationInHours = $totalDurationInHours;
            $item->totalDurationInMinutes = $totalDurationInMinutes;
        }

        // dd($report); //W122S402FA

        $overallTotalDurationInMinutes = collect($report)->sum('totalDurationInMinutes');
        $overallTotalDurationInHours = collect($report)->sum('totalDurationInHours');

        return view('report.detail', compact('report', 'overallTotalDurationInMinutes', 'overallTotalDurationInHours', 'workcenter', 'WOnborig', 'date'));
    }

    public function exportreport($WOnborig, $date, $workcenter)
    {
        $startDate = $endDate = null;

        // Periksa apakah " to " ada dalam string
        if (strpos($date, ' to ') !== false) {
            // Pisahkan tanggal awal dan tanggal akhir dari string rentang tanggal
            list($startDate, $endDate) = explode(' to ', $date);
        } else {
            // Jika hanya ada satu tanggal, gunakan tanggal yang sama untuk kedua variabel
            $startDate = $endDate = $date;
        }
        // $yearAndMonth = explode('-', $date);

        $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
            ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
            ->join('tblEmployees', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
            ->whereBetween('tblEmployeesTasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('tblwo.WOnborig', $WOnborig)
            ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployeesTasks.EmployeeID as EmployeeIDtasks', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber')
            ->groupBy('tblEmployeesTasks.OprID')
            ->get();
        // dd($report);


        // $export = new WorkOrderAccountingExport($report);

        // Set data tambahan jika diperlukan di export class
        // $export->setWorkcenter($workcenter);

        // Debugging untuk melihat data sebelum ekspor
        // dd($WOnborig, $date, $report, $workcenter);

        // Assuming $yearAndMonth contains the current date in the format you want
        $filename = 'Report303_' . $date . '.xlsx';


        // Ekspor ke Excel
        return Excel::download(new WorkOrderAccountingExport($report, $startDate, $endDate), $filename);
        // return Excel::download(new WorkOrderAccountingExport($report), 'Report303.xlsx');
    }

    public function exportwo($daterange, $department)
    {

        // Inisialisasi tanggal awal dan akhir
        $startDate = $endDate = null;

        // Periksa apakah " to " ada dalam string
        if (strpos($daterange, ' to ') !== false) {
            // Pisahkan tanggal awal dan tanggal akhir dari string rentang tanggal
            list($startDate, $endDate) = explode(' to ', $daterange);
        } else {
            // Jika hanya ada satu tanggal, gunakan tanggal yang sama untuk kedua variabel
            $startDate = $endDate = $daterange;
        }

        // dd($hours,$startDate, $endDate, $department);


        if ($department === 'PL 1') {
            // dd($request->all());

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['TP01', 'TP02', 'TP03', 'TP04', 'TP05', 'TP06', 'TP07'])
                ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig') // Menggunakan GROUP BY pada kolom yang ingin dijadikan acuan
                ->get();

            // Ambil data WOnborig dari hasil query
            $WOnborig = $woopr->pluck('WOnborig')->toArray();

            // AMBIL TAHUN DAN BULAN
            // $date = Carbon::parse($startDate)->format('Y-m');

            $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->join('tblEmployees', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('tblwo.WOnborig', $WOnborig)
                ->select('tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployeesTasks.EmployeeID as EmployeeIDtasks', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber')
                ->groupBy('tblEmployeesTasks.OprID')
                ->get();
            // foreach ($woopr as $item) {

            //     }
            // Assuming $yearAndMonth contains the current date in the format you want
            $filename = 'ReportWO303_' . $daterange . '.xlsx';

            // dd($woopr);
            return Excel::download(new WorkOrder303($daterange, $WOnborig), $filename);

        } elseif ($department === 'PL 2') {
            // dd($request->all());

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['TP41', 'TP42', 'TP43', 'TP44', 'TP45', 'TP46', 'TP47'])
                ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig') // Menggunakan GROUP BY pada kolom yang ingin dijadikan acuan
                ->get();

            // Ambil data WOnborig dari hasil query
            $WOnborig = $woopr->pluck('WOnborig')->toArray();

            // AMBIL TAHUN DAN BULAN
            // $date = Carbon::parse($startDate)->format('Y-m');

            $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->join('tblEmployees', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('tblwo.WOnborig', $WOnborig)
                ->select('tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployeesTasks.EmployeeID as EmployeeIDtasks', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber')
                ->groupBy('tblEmployeesTasks.OprID')
                ->get();
            // foreach ($woopr as $item) {

            //     }
            // Assuming $yearAndMonth contains the current date in the format you want
            $filename = 'ReportWO303_' . $daterange . '.xlsx';

            // dd($woopr);
            return Excel::download(new WorkOrder303($daterange, $WOnborig), $filename);

        } elseif ($department === 'PL 3') {

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['TP51', 'TP52', 'TP53', 'TP54', 'TP55', 'TP56', 'TP57', 'TP58'])
                ->select('tblwo.WOnborig', 'tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig')
                ->get();


            // Ambil data WOnborig dari hasil query
            $WOnborig = $woopr->pluck('WOnborig')->toArray();

            // AMBIL TAHUN DAN BULAN
            // $date = Carbon::parse($startDate)->format('Y-m');

            $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->join('tblEmployees', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('tblwo.WOnborig', $WOnborig)
                ->select('tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployeesTasks.EmployeeID as EmployeeIDtasks', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber')
                ->groupBy('tblEmployeesTasks.OprID')
                ->get();
            // foreach ($woopr as $item) {

            //     }
            // Assuming $yearAndMonth contains the current date in the format you want
            $filename = 'ReportWO303_' . $daterange . '.xlsx';

            // dd($woopr);
            return Excel::download(new WorkOrder303($daterange, $WOnborig), $filename);


            // dd($woopr, $daterange, $department, $date, $WOnborig,$report);
        } elseif ($department === 'REPAIR') {
            // dd($request->all());

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['SP11', 'SP12', 'SP13'])
                ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig') // Menggunakan GROUP BY pada kolom yang ingin dijadikan acuan
                ->get();

            // Ambil data WOnborig dari hasil query
            $WOnborig = $woopr->pluck('WOnborig')->toArray();

            // AMBIL TAHUN DAN BULAN
            // $date = Carbon::parse($startDate)->format('Y-m');

            $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->join('tblEmployees', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('tblwo.WOnborig', $WOnborig)
                ->select('tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployeesTasks.EmployeeID as EmployeeIDtasks', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber')
                ->groupBy('tblEmployeesTasks.OprID')
                ->get();
            // foreach ($woopr as $item) {

            //     }
            // Assuming $yearAndMonth contains the current date in the format you want
            $filename = 'ReportWO303_' . $daterange . '.xlsx';

            // dd($woopr);
            return Excel::download(new WorkOrder303($daterange, $WOnborig), $filename);

        } elseif ($department === 'DRY TYPE') {
            // dd($request->all());

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['DP41', 'DP42', 'DP43', 'DP44', 'DP45'])
                ->select('tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig') // Menggunakan GROUP BY pada kolom yang ingin dijadikan acuan
                ->get();

            // Ambil data WOnborig dari hasil query
            $WOnborig = $woopr->pluck('WOnborig')->toArray();

            // AMBIL TAHUN DAN BULAN
            // $date = Carbon::parse($startDate)->format('Y-m');

            $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->join('tblEmployees', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('tblwo.WOnborig', $WOnborig)
                ->select('tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployeesTasks.EmployeeID as EmployeeIDtasks', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber')
                ->groupBy('tblEmployeesTasks.OprID')
                ->get();
            // foreach ($woopr as $item) {

            //     }
            // Assuming $yearAndMonth contains the current date in the format you want
            $filename = 'ReportWO303_' . $daterange . '.xlsx';

            // dd($woopr);
            return Excel::download(new WorkOrder303($daterange, $WOnborig), $filename);

        } elseif ($department === 'CTVT') {
            // dd($request->all());

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['CP13', 'CP17', 'CP17', 'CP18'])
                ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig') // Menggunakan GROUP BY pada kolom yang ingin dijadikan acuan
                ->get();

            // Ambil data WOnborig dari hasil query
            $WOnborig = $woopr->pluck('WOnborig')->toArray();

            // AMBIL TAHUN DAN BULAN
            // $date = Carbon::parse($startDate)->format('Y-m');

            $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->join('tblEmployees', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('tblwo.WOnborig', $WOnborig)
                ->select('tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployeesTasks.EmployeeID as EmployeeIDtasks', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber')
                ->groupBy('tblEmployeesTasks.OprID')
                ->get();
            // foreach ($woopr as $item) {

            //     }
            // Assuming $yearAndMonth contains the current date in the format you want
            $filename = 'ReportWO303_' . $daterange . '.xlsx';

            // dd($woopr);
            return Excel::download(new WorkOrder303($daterange, $WOnborig), $filename);

        }
    }

    public function exportreportcsv($WOnborig, $date, $workcenter)
    {
        $startDate = $endDate = null;

        // Periksa apakah " to " ada dalam string
        if (strpos($date, ' to ') !== false) {
            // Pisahkan tanggal awal dan tanggal akhir dari string rentang tanggal
            list($startDate, $endDate) = explode(' to ', $date);
        } else {
            // Jika hanya ada satu tanggal, gunakan tanggal yang sama untuk kedua variabel
            $startDate = $endDate = $date;
        }
        // $yearAndMonth = explode('-', $date);

        $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
            ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
            ->join('tblEmployees', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
            ->whereBetween('tblEmployeesTasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
            ->where('tblwo.WOnborig', $WOnborig)
            ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployeesTasks.EmployeeID as EmployeeIDtasks', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber')
            ->groupBy('tblEmployeesTasks.OprID')
            ->get();

        // $export = new WorkOrderAccountingExportCSV($report);

        // Set data tambahan jika diperlukan di export class
        // $export->setWorkcenter($workcenter);

        // Debugging untuk melihat data sebelum ekspor
        // dd($WOnborig, $date, $report, $workcenter);

        // Assuming $yearAndMonth contains the current date in the format you want
        $filename = 'Report303_CSV_' . $date . '.csv';


        // Ekspor ke Excel
        return Excel::download(new WorkOrderAccountingExportCSV($report, $startDate, $endDate), $filename);
        // return Excel::download(new WorkOrderAccountingExport($report), 'Report303.xlsx');
    }

    public function exportwocsv($daterange, $department)
    {

        // Inisialisasi tanggal awal dan akhir
        $startDate = $endDate = null;

        // Periksa apakah " to " ada dalam string
        if (strpos($daterange, ' to ') !== false) {
            // Pisahkan tanggal awal dan tanggal akhir dari string rentang tanggal
            list($startDate, $endDate) = explode(' to ', $daterange);
        } else {
            // Jika hanya ada satu tanggal, gunakan tanggal yang sama untuk kedua variabel
            $startDate = $endDate = $daterange;
        }

        // dd($hours,$startDate, $endDate, $department);


        if ($department === 'PL 1') {
            // dd($request->all());

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['TP01', 'TP02', 'TP03', 'TP04', 'TP05', 'TP06', 'TP07'])
                ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig') // Menggunakan GROUP BY pada kolom yang ingin dijadikan acuan
                ->get();

            // Ambil data WOnborig dari hasil query
            $WOnborig = $woopr->pluck('WOnborig')->toArray();

            // AMBIL TAHUN DAN BULAN
            // $date = Carbon::parse($startDate)->format('Y-m');

            $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->join('tblEmployees', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('tblwo.WOnborig', $WOnborig)
                ->select('tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployeesTasks.EmployeeID as EmployeeIDtasks', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber')
                ->groupBy('tblEmployeesTasks.OprID')
                ->get();
            // foreach ($woopr as $item) {

            //     }
            // Assuming $yearAndMonth contains the current date in the format you want
            $filename = 'ReportWO303_' . $daterange . '.xlsx';

            // dd($woopr);
            return Excel::download(new WorkOrder303($daterange, $WOnborig), $filename);

        } elseif ($department === 'PL 2') {
            // dd($request->all());

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['TP41', 'TP42', 'TP43', 'TP44', 'TP45', 'TP46', 'TP47'])
                ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig') // Menggunakan GROUP BY pada kolom yang ingin dijadikan acuan
                ->get();

            // Ambil data WOnborig dari hasil query
            $WOnborig = $woopr->pluck('WOnborig')->toArray();

            // AMBIL TAHUN DAN BULAN
            // $date = Carbon::parse($startDate)->format('Y-m');

            $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->join('tblEmployees', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('tblwo.WOnborig', $WOnborig)
                ->select('tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployeesTasks.EmployeeID as EmployeeIDtasks', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber')
                ->groupBy('tblEmployeesTasks.OprID')
                ->get();

            //     }
            // Assuming $yearAndMonth contains the current date in the format you want
            $filename = 'ReportWO303_' . $daterange . '.xlsx';

            // dd($woopr);
            return Excel::download(new WorkOrder303($daterange, $WOnborig), $filename);

        } elseif ($department === 'PL 2') {
            // dd($request->all());

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['TP41', 'TP42', 'TP43', 'TP44', 'TP45', 'TP46', 'TP47'])
                ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig') // Menggunakan GROUP BY pada kolom yang ingin dijadikan acuan
                ->get();

            // Ambil data WOnborig dari hasil query
            $WOnborig = $woopr->pluck('WOnborig')->toArray();

            // AMBIL TAHUN DAN BULAN
            // $date = Carbon::parse($startDate)->format('Y-m');

            $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->join('tblEmployees', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('tblwo.WOnborig', $WOnborig)
                ->select('tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployeesTasks.EmployeeID as EmployeeIDtasks', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber')
                ->groupBy('tblEmployeesTasks.OprID')
                ->get();
            // foreach ($woopr as $item) {

            //     }
            // Assuming $yearAndMonth contains the current date in the format you want
            $filename = 'ReportWO303_' . $daterange . '.xlsx';

            // dd($woopr);
            return Excel::download(new WorkOrder303($daterange, $WOnborig), $filename);

        } elseif ($department === 'PL 3') {

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['TP51', 'TP52', 'TP53', 'TP54', 'TP55', 'TP56', 'TP57', 'TP58'])
                ->select('tblwo.WOnborig', 'tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig')
                ->get();


            // Ambil data WOnborig dari hasil query
            $WOnborig = $woopr->pluck('WOnborig')->toArray();

            // AMBIL TAHUN DAN BULAN
            // $date = Carbon::parse($startDate)->format('Y-m');

            $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->join('tblEmployees', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('tblwo.WOnborig', $WOnborig)
                ->select('tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployeesTasks.EmployeeID as EmployeeIDtasks', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber')
                ->groupBy('tblEmployeesTasks.OprID')
                ->get();
            // foreach ($woopr as $item) {

            //     }
            // Assuming $yearAndMonth contains the current date in the format you want
            $filename = 'ReportWO303_CSV_' . $daterange . '.csv';

            // dd($woopr);
            return Excel::download(new WorkOrder303CSV($daterange, $WOnborig), $filename);


            // dd($woopr, $daterange, $department, $date, $WOnborig,$report);
        } elseif ($department === 'REPAIR') {
            // dd($request->all());

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['SP11', 'SP12', 'SP13'])
                ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig') // Menggunakan GROUP BY pada kolom yang ingin dijadikan acuan
                ->get();

            // Ambil data WOnborig dari hasil query
            $WOnborig = $woopr->pluck('WOnborig')->toArray();

            // AMBIL TAHUN DAN BULAN
            // $date = Carbon::parse($startDate)->format('Y-m');

            $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->join('tblEmployees', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('tblwo.WOnborig', $WOnborig)
                ->select('tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployeesTasks.EmployeeID as EmployeeIDtasks', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber')
                ->groupBy('tblEmployeesTasks.OprID')
                ->get();
            // foreach ($woopr as $item) {

            //     }
            // Assuming $yearAndMonth contains the current date in the format you want
            $filename = 'ReportWO303_' . $daterange . '.xlsx';

            // dd($woopr);
            return Excel::download(new WorkOrder303($daterange, $WOnborig), $filename);

        } elseif ($department === 'DRY TYPE') {
            // dd($request->all());

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['DP41', 'DP42', 'DP43', 'DP44', 'DP45'])
                ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig') // Menggunakan GROUP BY pada kolom yang ingin dijadikan acuan
                ->get();

            // Ambil data WOnborig dari hasil query
            $WOnborig = $woopr->pluck('WOnborig')->toArray();

            // AMBIL TAHUN DAN BULAN
            // $date = Carbon::parse($startDate)->format('Y-m');

            $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->join('tblEmployees', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('tblwo.WOnborig', $WOnborig)
                ->select('tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployeesTasks.EmployeeID as EmployeeIDtasks', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber')
                ->groupBy('tblEmployeesTasks.OprID')
                ->get();
            // foreach ($woopr as $item) {

            //     }
            // Assuming $yearAndMonth contains the current date in the format you want
            $filename = 'ReportWO303_' . $daterange . '.xlsx';

            // dd($woopr);
            return Excel::download(new WorkOrder303($daterange, $WOnborig), $filename);

        } elseif ($department === 'CTVT') {
            // dd($request->all());

            $woopr = WOOpr::join('tblEmployees', 'tblEmployees.id', '=', 'tblwoopr.EmployeeID')
                ->join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tbldepartment', 'tbldepartment.id', '=', 'tblEmployees.department_id')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', ["$startDate 00:00:00", "$endDate 23:59:59"])
                ->whereIn('tblwoopr.Workcenter', ['CP13', 'CP17', 'CP17', 'CP18'])
                ->select('tblwo.WOnborig','tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber', 'tbldepartment.name as department')
                ->groupBy('tblwo.WOnborig') // Menggunakan GROUP BY pada kolom yang ingin dijadikan acuan
                ->get();

            // Ambil data WOnborig dari hasil query
            $WOnborig = $woopr->pluck('WOnborig')->toArray();

            // AMBIL TAHUN DAN BULAN
            // $date = Carbon::parse($startDate)->format('Y-m');

            $report = WOOpr::join('tblwo', 'tblwo.id', '=', 'tblwoopr.WOID')
                ->join('tblEmployeesTasks', 'tblEmployeesTasks.OprID', '=', 'tblwoopr.id')
                ->join('tblEmployees', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
                ->whereBetween('tblEmployeesTasks.TaskDateStart', [$startDate . ' 00:00:00', $endDate . ' 23:59:59'])
                ->where('tblwo.WOnborig', $WOnborig)
                ->select('tblwo.*', 'tblwoopr.*', 'tblEmployeesTasks.*', 'tblEmployeesTasks.EmployeeID as EmployeeIDtasks', 'tblEmployees.Name', 'tblEmployees.EmployeeNumber')
                ->groupBy('tblEmployeesTasks.OprID')
                ->get();
            // foreach ($woopr as $item) {

            //     }
            // Assuming $yearAndMonth contains the current date in the format you want
            $filename = 'ReportWO303_' . $daterange . '.xlsx';

            // dd($woopr);
            return Excel::download(new WorkOrder303($daterange, $WOnborig), $filename);

        }
    }

}