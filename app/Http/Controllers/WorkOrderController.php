<?php

namespace App\Http\Controllers;

use App\Exports\WorkOrderExport;
use App\Imports\WorkOrderImport;
use App\Imports\WoOprImport;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\EmployeesTasks;
use App\Models\Employees;
use App\Models\WO;
use App\Models\WOOpr;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class WorkOrderController extends Controller
{
    public function index(Request $request)
    {
        // $data = WOOpr::with('wo')->get();
        // dd($data);
        if ($request->ajax()) {
            $data = WOOpr::join('tblWO', 'tblWOOpr.WOID', '=', 'tblWO.id')->select('tblWOOpr.*','tblWOOpr.id as OprID', 'tblWO.*');
            // dd($data);
            // Filter by WONumber
            return DataTables::of($data)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->has('search')) {
                        $query->where('WONumber', 'like', '%' . $request->input('search.value') . '%');
                    }
                })
                ->addColumn('WONumber', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->WONumber !== null ? $row->WONumber . $row->OprNumber : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('WOName', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->OprName !== null ? $row->OprName : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('WOBeginDate', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->WOBeginDate !== null ? $row->WOBeginDate : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('WOEndDate', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->WOEndDate !== null ? $row->WOEndDate : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('WOStatus', function ($row) {
                    if ($row->OprStatus == 2) {
                        $badge = '<span class="badge bg-success me-1">Finish</span>';
                        return $badge;
                    } elseif ($row->OprStatus == 1) {
                        $badge = '<span class="badge bg-primary me-1">In Progress</span>';
                        return $badge;
                    } else {
                        $badge = '<span class="badge bg-danger me-1">Not Started</span>';
                        return $badge;
                    }
                })
                ->addColumn('WODescription', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->WODescription !== null ? $row->WODescription : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('WOnote', function ($row) {
                    // Cek apakah WONumber tidak null
                    if ($row->WOnote !== null && $row->WOnote !== '') {
                        return $row->WOnote; // Tampilkan nilai WOnote jika tidak NULL atau kosong
                    } else {
                        return '<span class="badge bg-secondary me-1">No Data</span>';
                    }
                })
                ->addColumn('WOqty', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->WOqty !== null ? $row->WOqty : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('action', function ($row) {
                    $actionBtn1 = '<button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal"
                        data-bs-target="#exampleModal' . $row->id . '">
                        <i class="fas fa-eye"></i>
                    </button>';
                    $actionBtn2 = '<a href="' . route("workorder.edit", $row->OprID) . '" class="btn btn-sm btn-warning">
                        <i class="fa-solid fa-pen"></i>
                    </a>';


                    // Create a variable to store the content for the Work Number
                    $workNumberContent = $row->WONumber !== null ? $row->WONumber . $row->OprNumber : '<span class="badge bg-secondary me-1">No Data</span>';
                    $workOrderBeginDateContent = $row->WOBeginDate !== null ? $row->WOBeginDate : '<span class="badge bg-secondary me-1">No Data</span>';
                    $workOrderEndDateContent = $row->WOEndDate !== null ? $row->WOEndDate : '<span class="badge bg-secondary me-1">No Data</span>';
                    // Create a variable to store the content for IDMFG
                    $idMfgContent = $row->IDMFG !== null ? $row->IDMFG : '<span class="badge bg-secondary me-1">No Data</span>';
                    $WOnborigContent = $row->WOnborig !== null ? $row->WOnborig : '<span class="badge bg-secondary me-1">No Data</span>';
                    $FGnborigContent = $row->FGnborig !== null ? $row->FGnborig : '<span class="badge bg-secondary me-1">No Data</span>';
                    $BOMnborigContent = $row->BOMnborig !== null ? $row->BOMnborig : '<span class="badge bg-secondary me-1">No Data</span>';
                    $WOqtyContent = $row->WOqty !== null ? $row->WOqty : '<span class="badge bg-secondary me-1">No Data</span>';
                    $WOnoteContent = $row->WOnote !== null ? $row->WOnote : '<span class="badge bg-secondary me-1">No Data</span>';


                    // Create a variable to store the content for the Work Order Status
                    if ($row->OprStatus == 2) {
                        $workOrderStatusContent = '<span class="badge bg-success me-1">Finish</span>';
                    } elseif ($row->OprStatus == 1) {
                        $workOrderStatusContent = '<span class="badge bg-primary me-1">In Progress</span>';
                    } else {
                        $workOrderStatusContent = '<span class="badge bg-danger me-1">Not Started</span>';
                    }
                    $actionBtn1 .= '
                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal' . $row->id . '" tabindex="-1" aria-labelledby="exampleModalLabel' . $row->id . '" aria-hidden="true">
                            <div class="modal-dialog " role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel' . $row->id . '">
                                            ' . $row->WONumber . '
                                        </h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body row justify-content-center align-items-center">
                                        <div class="card">
                                            <div class="table-responsive text-nowrap container">
                                                <table class="table table-hover">
                                                    <thead>
                                                        <tr>
                                                            <th>Work Number</th>
                                                            <th>
                                                                ' . $workNumberContent . '
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Work Order Begin Date</th>
                                                            <th>
                                                                ' . $workOrderBeginDateContent . '
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Work Order End Date</th>
                                                            <th>
                                                                ' . $workOrderEndDateContent . '
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Work Order Status</th>
                                                            <th>
                                                                ' . $workOrderStatusContent . '
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>IDMFG</th>
                                                            <th>
                                                                ' . $idMfgContent . '
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>WOnborig</th>
                                                            <th>
                                                                ' . $WOnborigContent . '
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>FGnborig</th>
                                                            <th>
                                                                ' . $FGnborigContent . '
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>BOMnborig</th>
                                                            <th>
                                                                ' . $BOMnborigContent . '
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Work Order Quantity</th>
                                                            <th>
                                                                ' . $WOqtyContent . '
                                                            </th>
                                                        </tr>
                                                        <tr>
                                                            <th>Work Order Note</th>
                                                            <th>
                                                                ' . $WOnoteContent . '
                                                            </th>
                                                        </tr>
                                                    </thead>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    ';

                    $actionBtn = $actionBtn1 . ' ' . $actionBtn2;

                    return $actionBtn;
                })
                ->rawColumns(['action', 'WOName', 'WOStatus', 'WONumber', 'WOBeginDate', 'WOEndDate', 'WODescription', 'WOnote', 'WOqty'])
                ->make(true);
        }

        return view('wo.index');
    }

    public function show($id)
    {
        $workorder = WO::find($id);
        $WOEndDate = Carbon::parse('2020-12-31 00:00:00');
        $WOBeginDate = Carbon::parse('2020-09-03 00:00:00');

        // Menghitung selisih hari
        $selisihHari = $WOEndDate->diffInDays($WOBeginDate);
        return view('wo.show', compact('workorder', 'selisihHari'));
    }

    public function edit($OprID)
    {
        // ambil data product berdasarkan id
        $workorder = WOOpr::where('id', $OprID)->with('wo')->first();
        // dd($Workorder);

        // tampilkan view edit dan passing data product
        return view('wo.edit', compact('workorder'));
    }

    public function update(Request $request, $id){
        $woopr = WOOpr::where('id', $id)->first();
        // dd($request->status);

        $woopr->update([
            'OprStatus' => $request->status
        ]);

        // redirect ke halaman product.index
        return redirect()->route('workorder.index');

    }

    public function indexBarcode(Request $request)
    {
        if ($request->ajax()) {
            $data = WO::join('tblWOOpr', 'tblWO.id', '=', 'tblWOOpr.WOID')
                ->where('tblWOOpr.OprStatus', '!=', '2')
                ->select('tblWO.WONumber', 'tblWOOpr.OprNumber', 'tblWOOpr.OprName', 'tblWOOpr.Workcenter', 'tblWO.*');
            // Filter by WONumber
            return DataTables::of($data)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->has('search')) {
                        $searchValue = $request->input('search.value');
                        $query->where(function ($query) use ($searchValue) {
                            // Pisahkan teks pencarian menjadi 'WONumber' dan 'OprNumber'
                            $wonumber = substr($searchValue, 0, 9);  // Ambil karakter pertama
                            $oprnumber = substr($searchValue, 9);     // Ambil karakter sisanya
                            $query->where('WONumber', 'like', '%' . $wonumber . '%')
                                ->where('OprNumber', 'like', '%' . $oprnumber . '%');
                        })
                            ->orWhere('OprName', 'like', '%' . $searchValue . '%');
                    }
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<input type="checkbox" name="items[]" class="checkboxid" value="' . $row->id . '">';
                    return $actionBtn;
                })
                ->addColumn('WONumber', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->WONumber !== null ? $row->WONumber . $row->OprNumber : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('OprName', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->OprName !== null ? $row->OprName : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('Trafo', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->WONumber !== null ? substr($row->WONumber, -3) : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('Workcenter', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->Workcenter !== null ? $row->Workcenter : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->rawColumns(['action', 'WONumber', 'OprName', 'Trafo', 'Workcenter'])
                ->make(true);
        }

        return view('wo.indexbarcode');
    }
    public function cetakcodeqr(Request $request)
    {
        $dataworkorder = [];

        // Periksa apakah ada pegawai yang dipilih
        if ($request->has('items') && is_array($request->items)) {
            $selectedIds = $request->items;
            $dataworkorder = WO::whereIn('tblWO.id', $selectedIds) // Gunakan 'tblWO.id' untuk menghindari ambiguitas
                ->join('tblWOOpr', 'tblWO.id', '=', 'tblWOOpr.WOID')
                ->select('tblWO.WONumber', 'tblWOOpr.OprNumber', 'tblWO.*', 'tblWOOpr.OprName', 'tblWOOpr.Workcenter')
                ->get();
        }


        if ($request->has('id') && is_array($request->id)) {
            foreach ($request->id as $id) {
                $workorder = WO::find($id);
                if ($workorder) {
                    $workorderDetails = WO::join('tblWOOpr', 'tblWO.id', '=', 'tblWOOpr.WOID')
                        ->select('tblWO.WONumber', 'tblWOOpr.OprNumber', 'tblWO.*', 'tblWOOpr.OprName', 'tblWOOpr.Workcenter')
                        ->where('tblWO.id', $workorder->id)
                        ->first();

                    if ($workorderDetails) {
                        $dataworkorder[] = $workorderDetails;
                    }
                }
            }
        }

        $pdf = App::make('dompdf.wrapper');
        $no  = 1;
        $pdf->loadView('wo.barcodewo', compact('dataworkorder', 'no'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('workorder.pdf');
    }

    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx',
        ]);

        Excel::import(new WorkOrderImport, request()->file('file'));
        Excel::import(new WoOprImport, request()->file('file'));

        // membuat session message
        session()->flash('import', 'Data import berhasil ditambahkan');

        return back();
    }

    public function export()
    {
        return Excel::download(new WorkOrderExport, 'Employees.xlsx');
    }

    public function showDetail($id)
    {
        $wo = WO::find($id);

        return view('wo.index', compact('wo'));
    }
}


// INSERT INTO tblandonno (Andon_No, Andon_Color, Workcenter, CodeAndon) VALUES
//   ('XY11A', 'YELLOW', 11, 'A'),
//   ('XY11B', 'YELLOW', 11, 'B'),
//   ('XY11C', 'YELLOW', 11, 'C'),
//   ('XY11D', 'YELLOW', 11, 'D'),
//   ('XY11E', 'YELLOW', 11, 'E'),
//   ('XY11F', 'YELLOW', 11, 'F'),
//   ('XR11A', 'RED', 11, 'A'),
//   ('XR11B', 'RED', 11, 'B'),
//   ('XR11C', 'RED', 11, 'C'),
//   ('XR11D', 'RED', 11, 'D'),
//   ('XR11E', 'RED', 11, 'E'),
//   ('XR11F', 'RED', 11, 'F'),
//   ('XY31A', 'YELLOW', 31, 'A'),
//   ('XY31B', 'YELLOW', 31, 'B'),
//   ('XY31C', 'YELLOW', 31, 'C'),
//   ('XY31D', 'YELLOW', 31, 'D'),
//   ('XY31E', 'YELLOW', 31, 'E'),
//   ('XY31F', 'YELLOW', 31, 'F'),
//   ('XR31A', 'RED', 31, 'A'),
//   ('XR31B', 'RED', 31, 'B'),
//   ('XR31C', 'RED', 31, 'C'),
//   ('XR31D', 'RED', 31, 'D'),
//   ('XR31E', 'RED', 31, 'E'),
//   ('XR31F', 'RED', 31, 'F'),
//   ('XY32A', 'YELLOW', 32, 'A'),
//   ('XY32B', 'YELLOW', 32, 'B'),
//   ('XY32C', 'YELLOW', 32, 'C'),
//   ('XY32D', 'YELLOW', 32, 'D'),
//   ('XY32E', 'YELLOW', 32, 'E'),
//   ('XY32F', 'YELLOW', 32, 'F'),
//   ('XR32A', 'RED', 32, 'A'),
//   ('XR32B', 'RED', 32, 'B'),
//   ('XR32C', 'RED', 32, 'C'),
//   ('XR32D', 'RED', 32, 'D'),
//   ('XR32E', 'RED', 32, 'E'),
//   ('XR32F', 'RED', 32, 'F'),
//   ('XY33A', 'YELLOW', 33, 'A'),
//   ('XY33B', 'YELLOW', 33, 'B'),
//   ('XY33C', 'YELLOW', 33, 'C'),
//   ('XY33D', 'YELLOW', 33, 'D'),
//   ('XY33E', 'YELLOW', 33, 'E'),
//   ('XY33F', 'YELLOW', 33, 'F'),
//   ('XR33A', 'RED', 33, 'A'),
//   ('XR33B', 'RED', 33, 'B'),
//   ('XR33C', 'RED', 33, 'C'),
//   ('XR33D', 'RED', 33, 'D'),
//   ('XR33E', 'RED', 33, 'E'),
//   ('XR33F', 'RED', 33, 'F'),
//   ('XY13A', 'YELLOW', 13, 'A'),
//   ('XY13B', 'YELLOW', 13, 'B'),
//   ('XY13C', 'YELLOW', 13, 'C'),
//   ('XY13D', 'YELLOW', 13, 'D'),
//   ('XY13E', 'YELLOW', 13, 'E'),
//   ('XY13F', 'YELLOW', 13, 'F'),
//   ('XR13A', 'RED', 13, 'A'),
//   ('XR13B', 'RED', 13, 'B'),
//   ('XR13C', 'RED', 13, 'C'),
//   ('XR13D', 'RED', 13, 'D'),
//   ('XR13E', 'RED', 13, 'E'),
//   ('XR13F', 'RED', 13, 'F'),
//   ('XY17A', 'YELLOW', 17, 'A'),
//   ('XY17B', 'YELLOW', 17, 'B'),
//   ('XY17C', 'YELLOW', 17, 'C'),
//   ('XY17D', 'YELLOW', 17, 'D'),
//   ('XY17E', 'YELLOW', 17, 'E'),
//   ('XY17F', 'YELLOW', 17, 'F'),
//   ('XY18A', 'YELLOW', 18, 'A'),
//   ('XY18B', 'YELLOW', 18, 'B'),
//   ('XY18C', 'YELLOW', 18, 'C'),
//   ('XY18D', 'YELLOW', 18, 'D'),
//   ('XY18E', 'YELLOW', 18, 'E'),
//   ('XY18F', 'YELLOW', 18, 'F'),
//   ('XR17A', 'RED', 17, 'A'),
//   ('XR17B', 'RED', 17, 'B'),
//   ('XR17C', 'RED', 17, 'C'),
//   ('XR17D', 'RED', 17, 'D'),
//   ('XR17E', 'RED', 17, 'E'),
//   ('XR17F', 'RED', 17, 'F'),
//   ('XR18A', 'RED', 18, 'A'),
//   ('XR18B', 'RED', 18, 'B'),
//   ('XR18C', 'RED', 18, 'C'),
//   ('XR18D', 'RED', 18, 'D'),
//   ('XR18E', 'RED', 18, 'E'),
//   ('XR18F', 'RED', 18, 'F');
