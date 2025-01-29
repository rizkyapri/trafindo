<?php

namespace App\Http\Controllers;

use App\Models\Department;
use App\Models\Employees;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Maatwebsite\Excel\Facades\Excel;
use App\Models\EmployeesTasks;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Storage;
use Milon\Barcode\DNS2D;
use Milon\Barcode\PDF417;
use PhpOffice\PhpSpreadsheet\Writer\Pdf;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Yajra\DataTables\Facades\DataTables;

class EmployeeController extends Controller
{
    public function index(Request $request)
    {
        // $employees = Employees::with('department')->get();
        if ($request->ajax()) {
            $data = Employees::with('department');
            // Filter by WONumber
            return DataTables::of($data)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->has('search')) {
                        $query->where('Name', 'like', '%' . $request->input('search.value') . '%');
                    }
                })
                ->addColumn('checkbox', function ($row) {
                    $actionBtn = '<input type="checkbox" name="items[]" class="checkboxid" value="' . $row->id . '">';
                    return $actionBtn;
                })
                ->addColumn('action', function ($row) {
                    $editButton = '<a class="btn btn-warning btn-sm" href="' . route('employee.edit', $row->id) . '"><i class="fa-solid fa-pen-to-square"></i></a>';
                    $deleteButton = '<button class="btn btn-danger btn-sm" data-toggle="modal" data-target="#delete' . $row->id . '" onclick="return false;"><i class="fa-solid fa-trash"></i></button>';
                    $deleteButton .= '<!-- DELETE Modal -->
                    <div class="modal fade" id="delete' . $row->id . '">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Hapus Data?</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal body -->
                    <form method="post" action="' . route('employee.destroy', $row->id) . '">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <div class="modal-body">
                    Apakah Anda yakin ingin menghapus ?
                    <input type="hidden" name="idb" value="' . $row->id . '">
                    </div>
                    <!-- Modal footer -->
                    <div class="modal-footer">
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary" name="deletestok">Selesai</button>
                    </div>
                    </form>
                    </div>
                    </div>
                    </div>';

                    return '<div class="btn-group">' . $editButton . $deleteButton . '</div>';
                })
                ->addColumn('Name', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->Name !== null ? $row->Name : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('Number', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->EmployeeNumber !== null ? $row->EmployeeNumber : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('Department', function ($user) {

                    $badgeClass = $user->department ? ($user->department->name == 'PL 2' ? 'bg-info' : 'bg-primary') : 'bg-primary';

                    $departmentName = $user->department ? $user->department->name : 'Tidak tersedia';

                    return '<span class="badge ' . $badgeClass . '">' . $departmentName . '</span>';
                })
                ->addColumn('Title', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->Title !== null ? '<span class="badge bg-info me-1">' . $row->Title . '</span>' : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('Photo', function ($row) {
                    $actionBtn = '
                        <button type="button" class="btn btn-sm btn-primary text-center justify-content-center"
                            data-bs-toggle="modal" data-bs-target="#exampleModal' . $row->id . '">
                            <i class="fas fa-eye"></i>
                        </button>

                        <!-- Modal -->
                        <div class="modal fade" id="exampleModal' . $row->id . '" tabindex="-1"
                            aria-labelledby="exampleModalLabel' . $row->id . '" aria-hidden="true">
                            <div class="modal-dialog" role="document">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="exampleModalLabel' . $row->id . '">
                                            ' . $row->Name . '</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                            aria-label="Close">
                                        </button>
                                    </div>
                                    <div class="modal-body row justify-content-center align-items-center">';
                    if ($row->Photograph) {
                        $actionBtn .= '<img src="' . asset('storage/employee/' . $row->Photograph) . '" style="width: 100%;">';
                    } else {
                        $actionBtn .= '<div class="alert alert-warning">No photo available for this user.</div>';
                    }
                    $actionBtn .= '</div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-bs-dismiss="modal">Close</button>
                                    </div>
                                </div>
                            </div>
                        </div>';

                    return $actionBtn;
                })
                ->addColumn('Notes', function ($row) {
                    $actionBtn = '<button type="button" class="btn btn-sm btn-primary text-center justify-content-center"
                                    data-bs-toggle="modal" data-bs-target="#NotesModal' . $row->id . '">
                                    <i class="fa-solid fa-note-sticky"></i>
                                </button>

                                <!-- Modal -->
                                <div class="modal fade" id="NotesModal' . $row->id . '" tabindex="-1"
                                    aria-labelledby="NotesModalLabel' . $row->id . '" aria-hidden="true">
                                    <div class="modal-dialog">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="NotesModalLabel' . $row->id . '">
                                                    ' . $row->Name . ' Notes</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                    aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                <textarea style="padding-bottom: 250px" class="form-control" readonly>' . $row->Notes . '</textarea>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="button" class="btn btn-secondary"
                                                    data-bs-dismiss="modal">Close</button>
                                            </div>
                                        </div>
                                    </div>
                                </div>';

                    return $actionBtn;
                })
                ->addColumn('Progress', function ($row) {
                    if ($row->InProgress == 0) {
                        return '<span class="badge bg-success me-1">Finish</span>';
                    } elseif ($row->InProgress == 1) {
                        return '<span class="badge bg-primary me-1">Run</span>';
                    } else {
                        return '<span class="badge bg-danger me-1">Stop</span>';
                    }
                })
                ->rawColumns(['action', 'checkbox', 'Name', 'Number', 'Department', 'Title', 'Photo', 'Notes', 'Progress'])
                ->make(true);
        }

        return view('employee.index');
    }

    public function indextask(Request $request)
    {

        if ($request->ajax()) {
            $data = EmployeesTasks::join('tblEmployees', 'tblEmployeesTasks.EmployeeID', '=', 'tblEmployees.id')
                ->select('tblEmployeesTasks.*', 'tblEmployees.*');

            return DataTables::of($data)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->has('search')) {
                        $query->where('Name', 'like', '%' . $request->input('search.value') . '%');
                    }
                })
                ->addColumn('Name', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->Name !== null ? $row->Name : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('OprID', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->OprID !== null ? $row->OprID : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('TaskDateStart', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->TaskDateStart !== null ? $row->TaskDateStart : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('TaskDateEnd', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->TaskDateEnd !== null ? $row->TaskDateEnd : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('manhours', function ($row) {
                    // Calculate the range of hours for each row
                    $startDate = Carbon::parse($row->TaskDateStart);
                    $endDate = Carbon::parse($row->TaskDateEnd);
                    $diff = $startDate->diff($endDate);
                    return $diff->format('%h hr %i min');
                    // foreach ($row as $item) {
                    //     $startDate = Carbon::parse($item->TaskDateStart);
                    //     $endDate = Carbon::parse($item->TaskDateEnd);
                    //     $diff = $startDate->diff($endDate);
                    //     $item->hourRange = $diff->format('%h hr %i min');
                    //     $item->totalHours = $diff->h; // Hours
                    //     $item->totalMinutes = $diff->i; // Minutes
                    // }

                    // Cek apakah WONumber tidak null
                })
                ->addColumn('taskStatus', function ($row) {
                    if ($row->TaskStatus == 'F') {
                        $badge = '<span class="badge bg-success me-1">Finish</span>';
                        return $badge;

                    } else{

                        $badge = '<span class="badge bg-danger me-1">Stop</span>';
                        return $badge;
                    }
                })
                ->rawColumns(['OprID', 'Name', 'TaskDateStart', 'TaskDateEnd', 'manhours', 'taskStatus'])
                ->make(true);
        }
        $employeetasks = EmployeesTasks::all(); // Replace with your model and query as needed

        // Calculate the range of hours for each row
        foreach ($employeetasks as $item) {
            $startDate = Carbon::parse($item->TaskDateStart);
            $endDate = Carbon::parse($item->TaskDateEnd);
            $diff = $startDate->diff($endDate);
            $item->hourRange = $diff->format('%h hr %i min');
            $item->totalHours = $diff->h; // Hours
            $item->totalMinutes = $diff->i; // Minutes
        }

        // Aggregate total hours by EmployeeID
        $totalMinutes = DB::table('tblEmployeesTasks')
            ->select(
                'tblEmployeesTasks.EmployeeID',
                'tblEmployees.Name',
                DB::raw('SUM(HOUR(TaskDateEnd - TaskDateStart)) * 60 + SUM(MINUTE(TaskDateEnd - TaskDateStart)) as totalMinutes')
            )
            ->join('tblEmployees', 'tblEmployeesTasks.EmployeeID', '=', 'tblEmployees.ID')
            ->groupBy('tblEmployeesTasks.EmployeeID', 'tblEmployees.Name')
            ->get();

        return view('employee.indextask', compact('employeetasks', 'totalMinutes'));
        // return view('employee.indextask');
    }

    public function create()
    {
        // Tampilkan halaman create
        $dept = Department::all();
        return view('employee.create', compact('dept'));
    }

    public function store(Request $request)
    {
        // Validasi
        $validated = $request->validate([
            'EmployeeName' => 'required',
            'EmployeeNumber' => 'required|unique:tblEmployees',
            'department' => 'required',
            'Title' => 'required',
            // 'Notes' => 'required',
        ], [
            'EmployeeNumber.unique' => 'The Employee Number already exists.',
        ]);

        // Handling image
        if ($request->hasFile('Photo')) {
            // Ganti nama gambar
            $imageName = time() . '.' . $request->Photo->extension();

            // Store gambar ke folder
            Storage::putFileAs('public/employee', $request->Photo, $imageName);
        } else {
            // Memberikan nama jika tidak ada gambar
            $imageName = NULL;
        }

        // Simpan data ke database
        $user = Employees::create([
            'Name' => $request->EmployeeName,
            'EmployeeNumber' => $request->EmployeeNumber,
            'department_id' => $request->department,
            'Title' => $request->Title,
            'InProgress' => $request->InProgress,
            'Photograph' => $imageName,
            'Notes' => $request->Notes,
            // 'RoleID' => $request->RoleID,
            // 'password' => bcrypt('password') // default password, temporarily hardcoded
        ]);

        // menampilkan message success
        session()->flash('added', 'Data Berhasil Ditambahkan.');

        // Arahkan ke halaman
        return redirect()->route('employee.index');
    }

    public function edit($id)
    {
        // Ambil data user berdasarkan id
        $employee = Employees::find($id);

        // Ambil data roles dari database
        $dept = Department::all();

        // Tampilkan halaman edit dengan passing data user dan roles
        return view('employee.edit', compact('employee', 'dept'));
    }

    public function update(Request $request, $id)
    {
        // mencari data berdasarkan id
        $employee = Employees::find($id);

        // fungsi jika tidak ada employee id maka akan menampilkan eror
        if (!$employee) {
            return redirect()->route('employee.index')->with('error', 'Employee not found.');
        }

        // Validasi
        $request->validate([
            'Name' => 'required',
            'EmployeeNumber' => 'required',
            'department' => 'required',
            'title' => 'required',
            'Photo' => 'image|mimes:jpeg,png,jpg|max:2048',
        ]);

        $employee->update([
            'Name' => $request->Name,
            'EmployeeNumber' => $request->EmployeeNumber,
            'department_id' => $request->department,
            'Title' => $request->title,
            'Notes' => $request->notes,

        ]);

        // handling image
        if ($request->hasFile('Photo')) {
            $file = $request->file('Photo');
            $extension = $file->getClientOriginalExtension();
            $imageName = time() . '_' . str_replace(' ', '_', $employee->Name) . '.' . $extension;
            $path = $file->storeAs('public/employee', $imageName);

            // Menghapus foto sebelumnya (jika ada)
            if ($employee->Photograph) {
                Storage::delete('public/employee/' . $employee->Photograph);
            }

            $employee->Photograph = $imageName;
            $employee->save();
        }

        // membuat set message success
        session()->flash('updated', 'Data Berhasil Di Update.');

        // Arahkan ke halaman
        return redirect()->route('employee.index');
    }

    public function destroy($id)
    {
        // Ambil data user berdasarkan id
        $user = Employees::find($id);

        // Hapus data user
        $user->delete();

        // menampilkan pesan success di session
        session()->flash('deleted', 'Data Berhasil Dihapus.');

        // Redirect ke halaman employee.index
        return redirect()->route('employee.index');
    }

    public function cetakBarcode(Request $request)
    {
        $dataemployee = [];

        // Periksa apakah ada pegawai yang dipilih
        if ($request->has('items') && is_array($request->items)) {
            $selectedIds = $request->items;
            $dataemployee = Employees::whereIn('id', $selectedIds)->get();
        }

        if ($request->has('id') && is_array($request->id)) {
            foreach ($request->id as $id) {
                $employee = Employees::find($id);
                if ($employee) {
                    $dataemployee[] = $employee;
                }
            }
        }
        $pdf = App::make('dompdf.wrapper');
        $no  = 1;
        $pdf->loadView('employee.barcode', compact('dataemployee', 'no'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('produk.pdf');
    }

    public function showPhoto($id)
    {
        $employees = Employees::find($id); // Replace 'Photo' with your model name

        return view('employee.index', compact('employees'));
    }

    public function show($id)
    {
        // Find the employee by EmployeeNumber
        $employee = Employees::where('EmployeeNumber', $id)->first();

        if (!$employee) {
            // Employee not found
            return response()->json([
                'success' => false,
                'message' => 'Employee not found.',
            ], 404);
        }

        // Employee found, return employee data
        return response()->json([
            'success' => true,
            'message' => 'Employee found',
            'employee' => $employee,
        ]);
    }
}
