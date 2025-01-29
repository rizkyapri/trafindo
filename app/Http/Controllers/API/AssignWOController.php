<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\AssignWO;
use App\Models\WO;
use App\Models\WOOpr;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AssignWOController extends Controller
{
    public function index()
    {
        $assignWO = AssignWO::join('tblWOOpr', 'tblAssign.OprID', '=', 'tblWOOpr.id')
        ->join('tblWO', 'tblWOOpr.WOID', '=', 'tblWO.id')
        ->join('tblEmployees', 'tblAssign.EmployeeID', '=', 'tblEmployees.id')
        ->select('tblAssign.*', 'tblAssign.id as AssignID' , 'tblWO.*', 'tblWOOpr.*', 'tblEmployees.*','tblAssign.AssignStatus as Status')
        ->where('tblAssign.AssignStatus', '!=', 2)
        ->get();

        return response()->json([
            'success' => true,
            'message' => 'Daftar data produk',
            'dataAssign' => $assignWO,
        ], 200);
    }

    public function show($id)
    {
        // mengambil data Assign berdasarkan id
        // $assign = Employees::find($id);
        $assignments = AssignWO::join('tblWOOpr', 'tblAssign.OprID', '=', 'tblWOOpr.id')
            ->join('tblWO', 'tblWOOpr.WOID', '=', 'tblWO.id')
            ->join('tblEmployees', 'tblAssign.EmployeeID', '=', 'tblEmployees.id')
            ->select(
                'tblAssign.id as AssignID','tblAssign.EmployeeID','tblEmployees.Name','tblEmployees.EmployeeNumber','tblAssign.OprID','tblAssign.AssignStatus as Status',
                DB::raw("CONCAT(tblWO.WONumber, tblWOOpr.OprNumber) as WorkOrder"),

            )
            ->where('tblEmployees.id', $id) // Batasi hasil hanya untuk ID tertentu
            ->where('tblAssign.AssignStatus', '!=', 2)
            ->get();

        if ($assignments) {

            return response()->json([
                'success' => true,
                'message' => 'Detail data assign',
                // 'data' => $assign,
                'WOOpr' => $assignments
            ], 200);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'Data tidak ditemukan',
                'data' => ''
            ], 404);
        }
    }

}
