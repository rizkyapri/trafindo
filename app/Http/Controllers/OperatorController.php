<?php

namespace App\Http\Controllers;

use App\DataTables\RunEmployeeDataTable;
use App\DataTables\StopEmployeeDataTable;
use App\Models\Andon;
use App\Models\EmployeesTasks;
use App\Models\Employees;
use App\Models\WO;
use App\Models\WOOpr;
use App\Models\AndonCategory;
use App\Models\AndonNo;
use App\Models\AssignWO;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;
use Maatwebsite\Excel\Concerns\ToArray;
use PhpParser\Node\Expr\FuncCall;
use Yajra\DataTables\Facades\DataTables;

class OperatorController extends Controller
{
    public function index()
    {
        // dd(session()->all());
        // session()->forget('employeeTaskId');
        // session()->forget('currentWorkOrder');
        // session()->forget('makeWorkOrder');
        // session()->forget('EmployeeFinishWO');
        // session()->forget('WOEmployee');
        // session()->forget('andon_no');
        // session()->forget('andonAccepted');
        // session()->forget('AndonEmpSession');
        // session()->forget('Workcenter');
        // session()->forget('CategoryProblem');
        // session()->forget('AssignTo');
        // session()->forget('Andon_Color');

        $andonCat = AndonCategory::all();
        $EmployeeRun = Employees::where('InProgress', 1)->get();
        $EmployeeStop = Employees::where('InProgress', 2)->get();
        $employeeNames = Employees::select('Name', 'EmployeeNumber')->get();
        // $NoWO = WO::select('WONumber')->get();
        // $OprNumber = WOOpr::select('OprNumber')->get();

        $WOrder = WO::join('tblWOOpr', 'tblWO.id', '=', 'tblWOOpr.WOID')
            ->select('tblWO.WONumber', 'tblWOOpr.*', 'tblWO.*')
            ->get();


        $employeesession = session('currentWorkOrder');
        // $FinishWO = session('EmployeeFinishWO');
        $emptask = session('employeeTaskId');
        $WOActivity = session('WOEmployee');
        $AndonNo = session('andon_no');
        $andonAccepted = session('andonAccepted');
        $AndonEmpSession = session('AndonEmpSession');
        $andonRiseUpEmployee = session('andonRiseUpEmployee');
        $andonRiseUpEmployeeName = session('andonRiseUpEmployeeName');
        $andonRiseUpEmployeeNumber = session('andonRiseUpEmployeeNumber');
        $andonRiseUpWO = session('andonRiseUpWO');
        $AndonWorkcenter = session('Workcenter');
        $AndonCategoryProblem = session('CategoryProblem');
        $AndonAssignTo = session('AssignTo');
        $Andon_Color = session('Andon_Color');
        $WorkOrderOperationSession = session('WorkOrderOperationSession');

        // session()->forget('WOEmployee');

        if ($WOActivity) {
            $WOData = $WOActivity->first();
            $WODataF = $WOActivity->where('TaskStatus', '=', 'F');
            // dd($WOActivity->first());
            foreach ($WOActivity as $item) {
                $startDate = Carbon::parse($item->TaskDateStart);
                $endDate = Carbon::parse($item->TaskDateEnd);
                $diff = $startDate->diff($endDate);
                $item->hourRange = $diff->format('%h hr %i min');
                $item->totalHours = $diff->h; // Hours
                $item->totalMinutes = $diff->i; // Minutes
            }

            $groupedTasks = $WOActivity->groupBy('Name');

            // Aggregate total hours by EmployeeID
            $totalMinutes = DB::table('tblEmployeesTasks')
                ->select(
                    'tblEmployeesTasks.EmployeeID',
                    'tblemployees.Name',
                    DB::raw('SUM(HOUR(TaskDateEnd - TaskDateStart)) * 60 + SUM(MINUTE(TaskDateEnd - TaskDateStart)) as totalMinutes')
                )
                ->join('tblemployees', 'tblEmployeesTasks.EmployeeID', '=', 'tblemployees.ID')
                ->groupBy('tblEmployeesTasks.EmployeeID', 'tblemployees.Name')
                ->get();
            return view('operator.index', compact('groupedTasks', 'WOActivity', 'EmployeeRun', 'EmployeeStop', 'WOData', 'WODataF', 'totalMinutes'));
        } elseif ($andonAccepted) {
            // dd($AndonEmpSession);
            return view('operator.index', compact('EmployeeRun', 'EmployeeStop', 'AndonEmpSession'));
        }

        if ($emptask) {
            // dd($emptask);

            $employeeTabel = Employees::join('tblEmployeesTasks', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
                ->where('tblEmployees.id', $emptask->EmployeeID)
                ->select('tblEmployees.*', 'tblEmployeesTasks.*')
                ->first();
            // dd($employeeTabel);

            $today = Carbon::now(); // Ambil tanggal hari ini
            $WorkOrderOperationSession = EmployeesTasks::join('tblWOOpr', 'tblWOOpr.id', '=', 'tblEmployeesTasks.OprID')
                ->join('tblWO', 'tblWO.id', '=', 'tblWOOpr.WOID')
                ->where('tblEmployeesTasks.EmployeeID', $emptask->EmployeeID) // Filter berdasarkan tanggal (format 'Y-m-d')
                ->where('tblWOOpr.id', $emptask->OprID) // Filter berdasarkan OprID yang sama
                ->select('tblWOOpr.*', 'tblWO.*', 'tblEmployeesTasks.*')
                ->get();

            session(['WorkOrderOperationSession' => $WorkOrderOperationSession]);

            // dd($WorkOrderOperationSession);

            $WorkOrderSession = EmployeesTasks::join('tblWOOpr', 'tblWOOpr.id', '=', 'tblEmployeesTasks.OprID')
                ->join('tblWO', 'tblWO.id', '=', 'tblWOOpr.WOID')
                ->whereDate('tblEmployeesTasks.created_at', today()) // kalo gamau validate tanggal ini d hapus
                ->where('tblEmployeesTasks.EmployeeID', $emptask->EmployeeID) // Filter berdasarkan tanggal (format 'Y-m-d')
                ->where('tblWOOpr.id', $emptask->OprID) // Filter berdasarkan OprID yang sama
                ->orderBy('tblEmployeesTasks.created_at', 'desc') // Urutkan berdasarkan tanggal descending sama ini juga di hapus
                ->select('tblWOOpr.*', 'tblWO.*', 'tblEmployeesTasks.*')
                ->first();

            // dd($WorkOrderSession);

            $buttonaksi = EmployeesTasks::join('tblWOOpr', 'tblWOOpr.id', '=', 'tblEmployeesTasks.OprID')
                ->join('tblWO', 'tblWO.id', '=', 'tblWOOpr.WOID')
                ->where('tblEmployeesTasks.EmployeeID', $employeesession->EmployeeID)
                ->where('tblWOOpr.id', $emptask->OprID) // Filter berdasarkan OprID yang sama
                ->orderBy('tblEmployeesTasks.TaskDateStart', 'desc') // Order by TaskDateStart in descending order
                ->select('tblWOOpr.*', 'tblWO.*', 'tblEmployeesTasks.*')
                ->first(); // Retrieve the first (most recent) record

            // dd($buttonaksi);
            $aksiStart = EmployeesTasks::where('EmployeeID', $employeesession->EmployeeID)
                ->whereNull('TaskDateStart')
                ->whereNull('TaskDateEnd')
                ->whereNull('TaskStatus')
                ->latest('created_at') // Mengambil yang paling terbaru berdasarkan kolom created_at
                ->first();
            // dd($aksiStart);
            $aksi = EmployeesTasks::where('EmployeeID', $employeesession->EmployeeID)->first();
            // dd($aksi);

            // session()->forget('currentWorkOrder');
            // session()->forget('employeeTaskId');
            return view('operator.index', compact('aksiStart', 'buttonaksi', 'WorkOrderSession', 'aksi', 'EmployeeRun', 'EmployeeStop', 'employeeTabel',  'WorkOrderOperationSession'));
        } elseif ($employeesession) {
            // dd($employeesession);

            $employeeTabel = Employees::join('tblEmployeesTasks', 'tblEmployees.id', '=', 'tblEmployeesTasks.EmployeeID')
                ->where('tblEmployees.id', $employeesession->EmployeeID)
                ->select('tblEmployees.*', 'tblEmployeesTasks.*')
                ->orderBy('tblEmployeesTasks.created_at', 'desc') // Order by created_at in descending order
                ->first();
            // dd($employeeTabel);

            $today = Carbon::now(); // Ambil tanggal hari ini
            $WorkOrderOperationSession = EmployeesTasks::join('tblWOOpr', 'tblWOOpr.id', '=', 'tblEmployeesTasks.OprID')
                ->join('tblWO', 'tblWO.id', '=', 'tblWOOpr.WOID')
                ->where('tblEmployeesTasks.EmployeeID', $employeesession->EmployeeID) // Filter berdasarkan tanggal (format 'Y-m-d')
                ->where('tblWOOpr.id', $employeeTabel->OprID) // Filter berdasarkan OprID yang sama
                ->select('tblWOOpr.*', 'tblWO.*', 'tblEmployeesTasks.*')
                ->get();

            // dd($WorkOrderOperationSession);

            $WorkOrderSession = EmployeesTasks::join('tblWOOpr', 'tblWOOpr.id', '=', 'tblEmployeesTasks.OprID')
                ->join('tblWO', 'tblWO.id', '=', 'tblWOOpr.WOID')
                ->where('tblEmployeesTasks.EmployeeID', $employeesession->EmployeeID)
                ->where('tblWOOpr.id', $employeeTabel->OprID)
                ->select('tblWOOpr.*', 'tblWO.*', 'tblEmployeesTasks.*')
                ->orderBy('tblEmployeesTasks.created_at', 'desc') // Order by created_at in descending order
                ->first();


            // dd($WorkOrderSession);
            $buttonaksi = EmployeesTasks::join('tblWOOpr', 'tblWOOpr.id', '=', 'tblEmployeesTasks.OprID')
                ->join('tblWO', 'tblWO.id', '=', 'tblWOOpr.WOID')
                ->where('tblEmployeesTasks.EmployeeID', $employeesession->EmployeeID)
                ->where('tblWOOpr.id', $employeeTabel->OprID) // Filter berdasarkan OprID yang sama
                ->orderBy('tblEmployeesTasks.TaskDateStart', 'desc') // Order by TaskDateStart in descending order
                ->select('tblWOOpr.*', 'tblWO.*', 'tblEmployeesTasks.*')
                ->first(); // Retrieve the first (most recent) record



            $aksiStop = EmployeesTasks::where('EmployeeID', $employeesession->EmployeeID)
                ->whereNull('TaskDateEnd')
                ->latest('created_at') // Mengambil yang paling terbaru berdasarkan kolom created_at
                ->first();
            $aksiContinue = EmployeesTasks::where('EmployeeID', $employeesession->EmployeeID)
                ->where('TaskStatus', 'S')
                ->latest('created_at') // Mengambil yang paling terbaru berdasarkan kolom created_at
                ->first();

            // dd($aksiContinue);
            $aksi = EmployeesTasks::where('EmployeeID', $employeesession->EmployeeID)->first();
            // dd($aksi);

            // session()->forget('currentWorkOrder');
            // session()->forget('employeeTaskId');
            return view('operator.index', compact('aksiContinue', 'aksiStop', 'buttonaksi', 'WorkOrderSession', 'aksi', 'EmployeeRun', 'EmployeeStop', 'employeeTabel',  'WorkOrderOperationSession'));
        } else {
            // session()->forget('currentWorkOrder');
            return view('operator.index', compact('EmployeeRun', 'EmployeeStop', 'andonCat', 'employeeNames', 'WOrder'));
        }
    }

    public function employeerun(Request $request)
    {
        $employee = Employees::where('InProgress', 1);
        return DataTables::of($employee)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                if ($request->has('search')) {
                    $query->where('Name', 'like', '%' . $request->input('search.value') . '%');
                }
            })
            ->order(function ($query) {
                $query->orderBy('Name', 'asc');
            })
            ->addColumn('EmployeeName', function ($row) {
                return $row->Name;
            })
            ->addColumn('Progress', function ($row) {
                return '<span class="badge bg-primary me-1">Run</span>';
            })
            ->rawColumns(['Progress'])
            ->make(true);
    }
    public function employeestop(Request $request)
    {
        $employee = Employees::where('InProgress', 2);
        return DataTables::of($employee)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                if ($request->has('search')) {
                    $query->where('Name', 'like', '%' . $request->input('search.value') . '%');
                }
            })
            ->order(function ($query) {
                $query->orderBy('Name', 'asc');
            })
            ->addColumn('EmployeeName', function ($row) {
                return $row->Name;
            })
            ->addColumn('Progress', function ($row) {
                return '<span class="badge bg-danger me-1">Stop</span>';
            })
            ->rawColumns(['Progress'])
            ->make(true);
    }

    public function store(Request $request)
    {
        $tfContent = strtoupper($request->content);
        if (strpos($tfContent, 'TF') === 0) {

            // Memeriksa apakah hasil pemindaian sesuai dengan format "TF00708"
            // Mencari karyawan dengan nomor yang sesuai dalam tabel employees
            $employee = Employees::where('EmployeeNumber', $tfContent)->first();
            // dd($employee);
            if ($employee) {
                //ANDON SESSION
                $AndonSession = session('andonAccepted');
                $andonRiseUp = session('andon_no');

                $WOrder = WO::join('tblWOOpr', 'tblWO.id', '=', 'tblWOOpr.WOID')
                    ->select('tblWO.WONumber', 'tblWOOpr.*', 'tblWO.*')
                    ->get();

                $CariAndon = Andon::where('RiseUp_EmployeeNo', $employee->EmployeeNumber)
                    ->whereNull('AndonDateAccepted')
                    ->first();

                // WORKORDER SESSION FOR FINISH WO
                $WOSession = session('WOEmployee');
                if ($AndonSession) {
                    if ($CariAndon != null) {
                        session(['AndonEmpSession' => $CariAndon]);
                        return redirect()->route('operator');
                    } else {
                        session()->forget('andonAccepted');
                        return redirect()->route('operator')->with('error', 'Andon Rise Up tidak ditemukan');
                    }
                } else if ($andonRiseUp) {
                    if ($employee != null) {
                        session(['andonRiseUpEmployee' => $employee]);
                        session(['andonRiseUpEmployeeName' => $employee->Name]); // Set the employee name in the session
                        session(['andonRiseUpEmployeeNumber' => $employee->EmployeeNumber]); // Set the employee number in the session
                        return redirect()->route('operator')->with('warning', 'Silahkan scan work order number');
                    } else {
                        return redirect()->route('operator')->with('error', 'Employee Number tidak ditemukan');
                    }
                } else if ($WOSession) {
                    // AMBIL SESI DARI WO
                    $SesiWO = session('WOEmployee');

                    // AMBIL OPRID dan EmployeeID saja
                    $idOPR = $SesiWO[0]->OprID;

                    // find orangnya disini
                    $cariorang = EmployeesTasks::where('OprID', $idOPR)
                        ->where('EmployeeID', $employee->id)
                        ->first();

                    session(['EmployeeFinishWO' => $cariorang]);

                    return redirect()->route('operator');
                } else {
                    // Tidak ada session 'andonAccepted', cek 'tfScannedToday'
                    $today = now()->format('Y-m-d');
                    $yesterday = now()->subDay()->format('Y-m-d');

                    $tfScannedToday = EmployeesTasks::where('EmployeeID', $employee->id)
                        ->where(function ($query) use ($today, $yesterday) {
                            $query->whereDate('created_at', $today)
                                ->orWhereDate('created_at', $yesterday);
                        })
                        ->latest('created_at')
                        ->first();

                    if ($tfScannedToday != null && $tfScannedToday->TaskStatus != 'F') {
                        session(['currentWorkOrder' => $tfScannedToday]);
                        return redirect()->route('operator');
                    } else {
                        session(['makeWorkOrder' => $employee]);
                        return redirect()->route('operator')->with('warning', 'Silahkan lakukan scan Work Order');
                    }
                }
            } else {
                return redirect()->back()->with('error', 'Data Employee Tidak Ditemukan');
            }
        } else if (strlen($tfContent) === 11) {

            // // Memeriksa apakah hasil pemindaian sesuai dengan format "INMH0170320"
            // if (preg_match('/\w{8}\d{2}$/', $tfContent)) {
            // Mencari karyawan yang sudah dipindai sebelumnya (menggunakan session)
            $employeeData = session('makeWorkOrder');

            // dd($employeeData);
            $AndonNo = session('andon_no');
            // dd($AndonNo);
            $andonWoValidasi = Andon::where('RiseUp_OprNo', $tfContent)->first();
            $WOnumberValidasi = WO::join('tblWOOpr', 'tblWO.id', '=', 'tblWOOpr.WOID')
                ->selectRaw('CONCAT(tblWO.WONumber, tblWOOpr.OprNumber) AS CombinedValue') // Combine WONumber and OprNumber
                ->pluck('CombinedValue')
                ->toArray();

            // ini ada yang diubah beberapa seperti if nya di ubah ke bawah
            // if ($WOnumberValidasi) {
            //     if (in_array($tfContent, $WOnumberValidasi)) {
            //         session(['andonRiseUpWO' => $tfContent]);
            //         return redirect()->route('operator');
            //     } else {
            //         return redirect()->route('operator')->with('error', 'WO Number tidak ditemukan');
            //     }
            // }

            if ($employeeData) {
                // Mengambil dua karakter terakhir sebagai OprNumber
                // S32953FA240
                // Pencarian id Work Order
                $oprNumber = substr($tfContent, 0, -2); // Menghapus dua karakter terakhir
                $cariIdWo = WO::where('WONumber', $oprNumber)->first();
                $idwo = $cariIdWo->id;

                // Pencarian id OPR
                $lastTwoCharacters = substr($tfContent, -2);
                $cariIdOpr = WOOpr::where('WOID', $idwo)->where('OprNumber', $lastTwoCharacters)->first();
                $idOpr = $cariIdOpr->id;
                // INI JUGA DIUBAH UNTUK VALIDASIMYA
                //FIND EMPLOYEESTASKS
                // $employeeTasks = EmployeesTasks::where('EmployeeID', $employeeData->id)
                //     ->where('OprID', $idOpr)
                //     ->first();
                // dd($employeeTasks);

                // if (!$employeeTasks) {
                // Membuat entri baru dalam tabel employeestasks
                $newEmployeeTask = EmployeesTasks::create([
                    'EmployeeID' => $employeeData->id,
                    'OprID' => $idOpr,
                ]);

                //BUAT UPDATE WO DAN WOOPR
                if ($cariIdOpr->OprBeginDate === NULL) {
                    WOOpr::where('id', $cariIdOpr->id)->update([
                        'OprBeginDate' => now(),
                        'OprStatus' => "1",
                        'EmployeeID' => $employeeData->id,
                    ]);
                }

                // Menyimpan ID karyawan ke dalam session
                session(['employeeTaskId' => $newEmployeeTask]);
                session(['currentWorkOrder' => $employeeData]);

                // menampilkan pesan success di session
                return redirect()->back()->with('success', 'Data WorkOrder Berhasil Ditambahkan');
                // } else {
                //     // menampilkan pesan success di session
                //     session()->forget('makeWorkOrder');
                //     return redirect()->back()->with('error', 'WorkOrder Sudah Terdaftar');
                // }
            } else if ($AndonNo) {
                $andonRecord = Andon::where('RiseUp_OprNo', $tfContent)
                    ->whereNotNull('AndonDateOpen')
                    ->first();

                if ($andonRecord) {
                    // The WOnumber is valid and AndonDateOpen is not NULL
                    session()->flush();
                    return redirect()->route('operator')->with('error', 'WO Number ini sedang di solving');
                } else if (in_array($tfContent, $WOnumberValidasi)) {
                    session(['andonRiseUpWO' => $tfContent]);
                    $andonRiseUpEmployeeNumber = session('andonRiseUpEmployeeNumber');
                    return redirect()->route('operator');
                } else {
                    session()->flush();
                    return redirect()->route('operator')->with('error', 'WO Number tidak ditemukan atau belum dibuka');
                }
            } else {
                $oprNumber = substr($tfContent, 0, -2); // Menghapus dua karakter terakhir
                $cariIdWo = WO::where('WONumber', $oprNumber)->first();
                $idwo = $cariIdWo->id;


                // Pencarian id OPR
                $cariIdOpr = WOOpr::where('WOID', $idwo)->first();
                $idOpr = $cariIdOpr->id;


                $employeeTaskses = EmployeesTasks::join('tblemployees', 'tblEmployeesTasks.EmployeeID', '=', 'tblemployees.ID')
                    ->join('tblWOOpr', 'tblWOOpr.id', '=', 'tblEmployeesTasks.OprID')
                    ->join('tblWO', 'tblWO.id', '=', 'tblWOOpr.WOID')
                    ->where('tblEmployeesTasks.OprID', $idOpr)
                    ->select('tblEmployeesTasks.*', 'tblemployees.*', 'tblWOOpr.*', 'tblWO.WONumber')
                    ->get();
                // menampilkan pesan error kalo tidak ada isinya
                if ($employeeTaskses->isEmpty()) {
                    return redirect()->route('operator')->with('error', 'Work Order Belum Digunakan');
                } else {
                    session(['WOEmployee' => $employeeTaskses]);
                    return redirect()->route('operator');
                }
            }
        } else if (strpos($tfContent, 'XY') === 0 || strpos($tfContent, 'XR') === 0) {
            $AndonNo = AndonNo::where('Andon_No', $tfContent)->first();

            if ($AndonNo) {

                $andonCat = AndonCategory::where('CodeAndon', $AndonNo->CodeAndon)->first();

                session(['andon_no' => $AndonNo->Andon_No]);
                session(['Andon_Color' => $AndonNo->Andon_Color]);
                session(['Workcenter' => $AndonNo->Workcenter]);
                session(['CategoryProblem' => $andonCat->CategoryProblem]); // Create session for CategoryProblem
                session(['AssignTo' => $andonCat->AssignTo]); // Create session for AssignTo
                return redirect()->back()->with('success', 'Silahkan Scan NIK');
            }else{
                return redirect()->back()->with('error', 'Data tidak ditemukan');
            }
        } else if (strpos($tfContent, 'XN') === 0) {
            $andonAccepted = AndonNo::where('Andon_No', $tfContent)->first();
            // dd($andonAccepted);
            if ($andonAccepted) {
                $andonCat = AndonCategory::where('CodeAndon', $andonAccepted->CodeAndon)->first();

                session(['andonAccepted' => $andonAccepted->Andon_No]);
                return redirect()->back()->with('success', 'Silahkan Scan NIK');
                // ->back()->with('success', 'Silahkan Scan NIK')
            }else{
                return redirect()->back()->with('error', 'Data tidak ditemukan');
            }
        } else {
            return redirect()->back()->with('error', 'Data tidak ditemukan');
        }
    }

    public function storeAndon(Request $request)
    {
        $AndonNo = session('andon_no');
        $andonRiseUpEmployeeName = session('andonRiseUpEmployeeName');
        $andonRiseUpEmployeeNumber = session('andonRiseUpEmployeeNumber');
        $AndonAssignTo = session('AssignTo');
        $Andon_Color = session('Andon_Color');
        $woAndonSession = session('andonRiseUpWO');

        $woAndonStop = substr($woAndonSession, 0, -2);

        // dd($EmployeeSesi);
        $andonNo = session('andon_no');
        $Workcenter = 'TP' . session('Workcenter');

        // Andon-serie dengan mencari last record id + Andon_No
        $lastAndon = Andon::orderBy('id', 'desc')->first();

        if ($lastAndon) {
            // Extract the current Andon_Serie and increment it
            $lastAndonSerie = $lastAndon->id;
            $nextAndonSerie =  $AndonNo . '-0' . $lastAndonSerie + 1;
        } else {
        }
        // $selectedEmployee = explode('|', $request->input('RiseUp_EmployeeNo'));
        // $selectedEmployeeNumber = $selectedEmployee[0];
        // $selectedEmployeeName = $selectedEmployee[1];

        // $DescriptionProblem = session('DescriptionProblem');
        // store ke database
        // dd($request->all());
        $user = Andon::create([
            'Andon_No' => $AndonNo,
            'RiseUp_OprNo' => $woAndonSession,
            'Workcenter' => $Workcenter,
            // 'Guard_HPWA' => $request->Guard_HPWA,
            'Andon_Serie' => $nextAndonSerie,
            'DescriptionProblem' => $request->DescriptionProblem,
            'RiseUp_EmployeeNo' => $andonRiseUpEmployeeNumber,
            'RiseUp_EmployeeName' => $andonRiseUpEmployeeName,

        ]);

        // Mengupdate kolom InProgress pada tabel Employees menjadi 2 = Stop
        Employees::where('EmployeeNumber', $andonRiseUpEmployeeNumber)->update(['InProgress' => 2]);

        // Use the provided password to find a record in table2
        $CategoryProblem = $request->input('CategoryProblem');
        $record = AndonCategory::where('CategoryProblem', $CategoryProblem)->first();

        if ($record) {
            // Update the status of the found record in table2
            $record->update([
                'Sirene' => '1',
            ]);
        }
        // forget all session jika sudah sukses
        $request->session()->forget(['andon_no', 'Workcenter', 'CategoryProblem', 'AssignTo', 'Andon_Color', 'andonRiseUpEmployeeNumber', 'andonRiseUpEmployeeName', 'andonRiseUpEmployee', 'andonRiseUpWO']);

        // kembali
        return redirect()->back()->with('added', 'Andon Berhasil Dikirim');
    }

    public function storeAndonAcc(Request $request)
    {
        $GETDATA = session('AndonEmpSession');
        $rating = $request->input('rating');

        // Membuat entri baru dalam tabel employeestasks
        Andon::where('id', $GETDATA->id)->update([
            'AndonDateAccepted' => now(),
            'Solving_Score' => $rating,
        ]);

        session()->forget('andonAccepted');
        session()->forget('AndonEmpSession');

        // session()->flash('stop', 'Data WorkOrder Berhasil Ditambahkan.');

        return redirect()->route('operator')->with('success', 'Andon Accepted');
    }

    public function start(Request $request)
    {
        // Ambil Session
        $EmployeeTaskSesi = session('employeeTaskId');
        $currentWorkOrder = session('currentWorkOrder');

        if ($EmployeeTaskSesi) {
            // dd($EmployeeTaskSesi);
            // Membuat entri baru dalam tabel employeestasks
            EmployeesTasks::where('id', $EmployeeTaskSesi->id)->update([
                'TaskDateStart' => now(),
                'TaskStatus' => 'B',
            ]);

            // Mengupdate kolom InProgress pada tabel Employees menjadi 1
            Employees::where('id', $EmployeeTaskSesi->id)->update(['InProgress' => 1]);

            // Update kolom assign menjadi 1 sedang dikerjakan
            AssignWO::where('OprID', $EmployeeTaskSesi->OprID)->update(['AssignStatus' => 1]);
        } elseif ($currentWorkOrder) {
            // Membuat entri baru dalam tabel employeestasks
            EmployeesTasks::where('id', $currentWorkOrder->id)->update([
                'TaskDateStart' => now(),
                'TaskStatus' => 'B',
            ]);

            // Mengupdate kolom InProgress pada tabel Employees menjadi 1
            Employees::where('id', $currentWorkOrder->id)->update(['InProgress' => 1]);

            // Update kolom assign menjadi 1 sedang dikerjakan
            AssignWO::where('OprID', $currentWorkOrder->OprID)->update(['AssignStatus' => 1]);
        }


        session()->forget('employeeTaskId');
        session()->forget('currentWorkOrder');
        session()->forget('makeWorkOrder');
        // menampilkan pesan success di session
        return redirect()->route('operator')->with('success', 'Silahkan Bekerja.');
    }

    public function stop(Request $request)
    {
        // Ambil Session
        $EmployeeSesi = session('currentWorkOrder');

        // Membuat entri baru dalam tabel employeestasks
        EmployeesTasks::where('id', $EmployeeSesi->id)->update([
            'TaskDateEnd' => now(),
            'TaskStatus' => 'S',
        ]);

        // // Mengupdate kolom InProgress pada tabel Employees menjadi 1
        Employees::where('id', $EmployeeSesi->EmployeeID)->update(['InProgress' => 2]);

        session()->forget('employeeTaskId');
        session()->forget('currentWorkOrder');
        session()->forget('makeWorkOrder');

        // session()->flash('stop', 'Data WorkOrder Berhasil Ditambahkan.');

        return redirect()->route('operator')->with('error', 'Tugas Dihentikan');
    }

    public function continue(Request $request)
    {
        // Ambil Session
        $EmployeeSesi = session('currentWorkOrder');

        // Membuat entri baru dalam tabel employeestasks
        $newEmployeeTask = EmployeesTasks::create([
            'EmployeeID' => $EmployeeSesi->EmployeeID,
            'OprID' => $EmployeeSesi->OprID,
            'TaskDateStart' => now(),
            'TaskStatus' => 'C', // "C" berarti pemindaian "TF"
        ]);

        // // Mengupdate kolom InProgress pada tabel Employees menjadi 1
        Employees::where('id', $EmployeeSesi->EmployeeID)->update(['InProgress' => 1]);

        session()->forget('employeeTaskId');
        session()->forget('currentWorkOrder');
        session()->forget('makeWorkOrder');

        // menampilkan pesan success di session
        // session()->flash('added', 'Tugas dilanjutkan.');

        return redirect()->route('operator')->with('success', 'Tugas dilanjutkan');
    }

    public function finish(Request $request)
    {
        // Ambil Session
        $EmployeeSesi = session('currentWorkOrder');
        $EmployeeFinishWOSesi = session('EmployeeFinishWO');
        // dd($EmployeeSesi);

        if ($EmployeeSesi) {
            // Membuat entri baru dalam tabel employeestasks
            EmployeesTasks::where('id', $EmployeeSesi->id)->update([
                'TaskDateEnd' => now(),
                'TaskStatus' => 'F',
            ]);

            // Update kolom assign menjadi 1 sedang dikerjakan
            // where('WOID', $idwo)->where('OprNumber', $lastTwoCharacters)->first()
            AssignWO::where('OprID', $EmployeeSesi->OprID)
                ->where('EmployeeID', $EmployeeSesi->EmployeeID)
                ->update(['AssignStatus' => 2]);

            // // Mengupdate kolom InProgress pada tabel Employees menjadi 1
            Employees::where('id', $EmployeeSesi->EmployeeID)->update(['InProgress' => 0]);
        } else if ($EmployeeFinishWOSesi) {
            $cariIdOpr = session('WOEmployee');

            // Pencarian id OPR
            $OPRDATA = WOOpr::where('id', $cariIdOpr[0]->OprID)->first();
            // dd($OPRDATA);
            //BUAT UPDATE WO DAN WOOPR
            if ($OPRDATA->OprEndDate === NULL) {
                WOOpr::where('id', $OPRDATA->id)->update([
                    'OprEndDate' => now(),
                    'OprStatus' => "2",
                ]);
            }
        }

        session()->forget('employeeTaskId');
        session()->forget('currentWorkOrder');
        session()->forget('EmployeeFinishWO');
        session()->forget('makeWorkOrder');
        session()->forget('WOEmployee');

        // menampilkan pesan success di session
        // session()->flash('added', 'Tugas Selesai.');

        return redirect()->route('operator')->with('success', 'Tugas Selesai');
    }

    public function close(Request $request)
    {
        session()->flush();
        return redirect()->route('operator');
    }
}
