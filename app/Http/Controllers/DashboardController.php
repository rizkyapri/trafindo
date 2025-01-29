<?php

namespace App\Http\Controllers;

use App\Models\WO;
use Illuminate\Support\Facades\DB;
use App\Models\WOOpr;
use App\Models\Employees;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index(Request $request)
    {

        $year = $request->input('year');

        // Query untuk menghitung status "Not Started" berdasarkan tblwoopr yang memiliki OprStatus = 0
        // Menginisialisasi array untuk menyimpan data status berdasarkan bulan
        $statusData = [
            'Not Started' => [],
            'In Progress' => [],
            'Finish' => [],
        ];

        // Loop melalui bulan-bulan dalam satu tahun
        for ($month = 1; $month <= 12; $month++) {
            // Ambil data WOOpr yang sesuai dengan bulan dan tahun
            $notStartedCount = WOOpr::where('OprStatus', 0)
                ->whereYear('OprPlanBegin', $year)
                ->whereMonth('OprPlanBegin', $month)
                ->count();

            $inProgressCount = WOOpr::where('OprStatus', 1)
                ->whereYear('OprBeginDate', $year)
                ->whereMonth('OprBeginDate', $month)
                ->count();

            $finishCount = WOOpr::where('OprStatus', 2)
                ->whereYear('OprEndDate', $year)
                ->whereMonth('OprEndDate', $month)
                ->count();

            // Tambahkan hasil per bulan ke dalam array
            $statusData['Not Started'][] = $notStartedCount;
            $statusData['In Progress'][] = $inProgressCount;
            $statusData['Finish'][] = $finishCount;
        }

        $yearsFromColumns = WOOpr::select(DB::raw('YEAR(OprPlanBegin) as year'))
            ->distinct()
            ->whereNotNull('OprPlanBegin') // Hanya tahun yang memiliki nilai yang valid
            ->union(WOOpr::select(DB::raw('YEAR(OprBeginDate) as year'))
                ->distinct()
                ->whereNotNull('OprBeginDate'))
            ->union(WOOpr::select(DB::raw('YEAR(OprEndDate) as year'))
                ->distinct()
                ->whereNotNull('OprEndDate'))
            ->orderBy('year', 'desc')
            ->pluck('year');

        $employees = Employees::all();
        $workorder = WO::all();

        $totalEmployees = count($employees);
        $totalWO = count($workorder);

        // Menghitung jumlah karyawan dengan status (Run)
        $totalFinishEmployees = Employees::where('InProgress', 0)->count();

        // Menghitung jumlah karyawan dengan status (Run)
        $totalRunEmployees = Employees::where('InProgress', 1)->count();

        // Menghitung jumlah karyawan dengan status (stop)
        $totalStopEmployees = Employees::where('InProgress', 2)->count();


        return view('dashboard', compact('statusData', 'year', 'yearsFromColumns', 'totalFinishEmployees', 'totalRunEmployees', 'totalStopEmployees', 'totalEmployees', 'employees', 'totalWO'));
        // 'notStartedCount', 'inProgressCount', 'finishCount', 'notStartedChartData', 'inProgressChartData', 'finishChartData'
    }
}