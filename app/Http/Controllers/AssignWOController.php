<?php

namespace App\Http\Controllers;

use App\Models\AssignWO;
use App\Models\Employees;
use App\Models\EmployeesTasks;
use App\Models\WO;
use App\Models\WOOpr;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AssignWOController extends Controller
{
    public function index(Request $request)
    {
        // $assignData = AssignWO::join('tblEmployees', 'tblEmployees.id', '=', 'tblAssign.EmployeeID')
        //     ->join('tblWOOpr', 'tblWOOpr.id', '=', 'tblAssign.OprID')
        //     ->select(
        //         'tblAssign.id as assign_id', // Memberikan alias 'assign_id' kepada kolom id dari tblAssign
        //         'tblAssign.*',
        //         'tblEmployees.*',
        //         'tblWOOpr.*'
        //     )
        //     ->get();
        //     dd($assignData);

        if ($request->ajax()) {
            $data = AssignWO::join('tblEmployees', 'tblEmployees.id', '=', 'tblAssign.EmployeeID')
                ->join('tblWOOpr', 'tblWOOpr.id', '=', 'tblAssign.OprID')
                ->join('tblWO', 'tblWOOpr.WOID', '=', 'tblWO.id') // Menambahkan join ke tabel 'WO'
                ->select(
                    'tblAssign.id as assign_id', // Memberikan alias 'assign_id' kepada kolom id dari tblAssign
                    'tblAssign.*',
                    'tblEmployees.*',
                    'tblWOOpr.*',
                    'tblWO.*',
                );

            // Filter by WONumber
            return DataTables::of($data)
                ->addIndexColumn()
                ->filter(function ($query) use ($request) {
                    if ($request->has('search')) {
                        $query->where('Name', 'like', '%' . $request->input('search.value') . '%');
                    }
                })
                ->addColumn('action', function ($row) {
                    $editButton = '<a class="btn btn-warning" href="' . route('assignwo.edit', $row->assign_id) . '"><i class="fa-solid fa-pen-to-square"></i></a>';
                    $deleteButton = '<button class="btn btn-danger" data-toggle="modal" data-target="#delete' . $row->assign_id . '" onclick="return false;"><i class="fa-solid fa-trash"></i></button>';
                    $deleteButton .= '<!-- DELETE Modal -->
                    <div class="modal fade" id="delete' . $row->assign_id . '">
                    <div class="modal-dialog">
                    <div class="modal-content">
                    <!-- Modal Header -->
                    <div class="modal-header">
                    <h4 class="modal-title">Hapus Data?</h4>
                    <button type="button" class="btn-close" data-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <!-- Modal body -->
                    <form method="post" action="' . route('assignwo.destroy', $row->assign_id) . '">
                    ' . csrf_field() . '
                    ' . method_field('DELETE') . '
                    <div class="modal-body">
                    Apakah Anda yakin ingin menghapus ?
                    <input type="hidden" name="idb" value="' . $row->assign_id . '">
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
                ->addColumn('WONumber', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->WONumber !== null ? $row->WONumber . $row->OprNumber : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('Bagian', function ($row) {
                    // Cek apakah WONumber tidak null
                    return $row->OprName !== null ? $row->OprName : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->addColumn('Status', function ($row) {
                    $badgeClass = 'bg-warning';
                    $badgeText = 'Belum Dikerjakan';

                    if ($row->AssignStatus == 1) {
                        $badgeClass = 'bg-info';
                        $badgeText = 'Sedang Dikerjakan';
                    } elseif ($row->AssignStatus == 2) {
                        $badgeClass = 'bg-success';
                        $badgeText = 'Sudah Dikerjakan';
                    }

                    $badge = '<span class="badge rounded-pill ' . $badgeClass . '">' . $badgeText . '</span';

                    return $badge;

                    // Cek apakah WONumber tidak null
                    // $badgeClass = $row->AssignStatus == 1 ? 'bg-success' : 'bg-warning';
                    // $badgeText = $row->AssignStatus == 1 ? 'sudah done' : 'belum dikerjakan';

                    // $badge = '<span class="badge rounded-pill ' . $badgeClass . '">' . $badgeText . '</span>';

                    // return $badge;

                    // return $row->WONumber !== null ? substr($row->WONumber, -3) : '<span class="badge bg-secondary me-1">No Data</span>';
                })
                ->rawColumns(['action', 'Name', 'Bagian', 'Status'])
                ->make(true);
        }

        return view('assignwo.index');
    }

    public function create(Request $request)
    {
        $name = Employees::all();
        $data = WOOpr::join('tblWO', 'tblWO.id', '=', 'tblWOOpr.WOID')
            ->where('tblWOOpr.OprStatus', '!=', '2')
            ->select('tblWO.WONumber', 'tblWOOpr.*')
            ->get()->toArray();


        // dd($data);

        return view('assignwo.create', compact('name', 'data'));
    }

    public function store(Request $request)
    {

        $validator = Validator::make($request->all(), [
            'employee' => 'required',
            'OprID' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        // Simpan data ke database
        $user = AssignWO::create([
            'EmployeeID' => $request->employee,
            'OprID' => $request->OprID,
            'AssignStatus' => 0,
        ]);

        // Set a success message in the session
        session()->flash('added', 'Data Berhasil Ditambahkan.');

        // Redirect ke halaman assignwo.index
        return redirect()->route('assignwo.index');
    }

    public function edit($id)
    {
        $assignData = AssignWO::find($id);
        $data = WOOpr::join('tblWO', 'tblWO.id', '=', 'tblWOOpr.WOID')
            ->select('tblWO.WONumber', 'tblWOOpr.*')
            ->get()->toArray();

        return view('assignwo.edit', compact('assignData', 'data'));
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'OprID' => 'required',
        ]);

        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator->errors())->withInput();
        }

        // Ambil data user berdasarkan id
        $user = AssignWO::find($id);


        $user->update([
            'OprID' => $request->OprID,
        ]);

        session()->flash('updated', 'Data Berhasil Di Update.');

        // Redirect ke halaman assignwo.index
        return redirect()->route('assignwo.index');
    }

    public function destroy($id)
    {
        // Ambil data user berdasarkan id
        $user = AssignWO::find($id);

        // Hapus data user
        $user->delete();

        // menampilkan pesan success di session
        session()->flash('deleted', 'Data Berhasil Dihapus.');

        // Redirect ke halaman assignwo.index
        return redirect()->route('assignwo.index');
    }
}
