<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AndonNo;
use App\Models\AndonCategory;
use Illuminate\Support\Facades\App;
use Yajra\DataTables\Facades\DataTables;

class AndonnoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $andonno = AndonNo::OrderBy('workcenter')
        // ->join('tblAndonCat','tblandonno.CodeAndon','=','tblAndonCat.id')
        // ->get();
        

        if ($request->ajax()) {
            $data = AndonNo::OrderBy('workcenter')
                    ->join('tblAndonCat','tblandonno.CodeAndon','=','tblAndonCat.CodeAndon')
                    ->select('tblandonno.id','tblandonno.Andon_No','tblandonno.Andon_Color','tblandonno.Workcenter','tblAndonCat.CodeAndon','tblAndonCat.CategoryProblem');
            // Filter by WONumber
            return DataTables::of($data)
            ->addIndexColumn()
            ->filter(function ($query) use ($request) {
                if ($request->has('search')) {
                    $query->where('Workcenter', 'like', '%' . $request->input('search.value') . '%');
                }
            })
            ->addColumn('action', function ($row) {
                $actionBtn = '<input type="checkbox" name="items[]" class="checkboxid" value="'. $row->id .'">';
                return $actionBtn;
            })
            ->addColumn('andonno', function ($row) {
                // Cek apakah WONumber tidak null
                return $row->Andon_No !== null ? $row->Andon_No : '<span class="badge bg-label-secondary me-1">No Data</span>';
            })
            ->addColumn('andoncolor', function ($row) {
                // Cek apakah WONumber tidak null
                return $row->Andon_Color !== null ? $row->Andon_Color : '<span class="badge bg-label-secondary me-1">No Data</span>';
            })
            ->addColumn('Workcenter', function ($row) {
                // Cek apakah WONumber tidak null
                return $row->Workcenter !== null ? $row->Workcenter : '<span class="badge bg-label-secondary me-1">No Data</span>';
            })
            ->filter(function ($instance) use ($request) {
                if (!empty($request->get('workcenterFilter'))) {
                    $instance->where('Workcenter', $request->get('workcenterFilter'));
                }
            })
            ->addColumn('CategoryProblem', function ($row) {
                // Cek apakah WONumber tidak null
                return $row->CategoryProblem !== null ? $row->CategoryProblem : '<span class="badge bg-label-secondary me-1">No Data</span>';
            })
            ->rawColumns(['action','andonno','andoncolor','CategoryProblem','Workcenter'])
            ->make(true);
        }
        //dd($andonno->toArray);

        // Mengambil daftar Workcenters untuk dropdown
        $workcenters = AndonNo::distinct('workcenter')->pluck('workcenter');



        return view('andon.index', compact ('workcenters'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    //Cetak QRCode Andon
    public function cetakBarcode(Request $request)
    {
        $dataandon = [];

        if ($request->has('items') && is_array($request->items)) {
            $selectedIds = $request->items;
            $dataandon = AndonNo::whereIn('id', $selectedIds)->get();
        }

        if ($request->has('id') && is_array($request->id)) {
            foreach ($request->id as $id) {
                $andonno = AndonNo::find($id);
                if ($andonno) {
                    $dataandon[] = $andonno;
                }
            }
        }
        // Tambahkan kode untuk menampilkan barcode Andon ketika Workcenter NULL
        $nullWorkcenterItems = AndonNo::whereNull('Workcenter')->get();
        $dataandon = $dataandon->concat($nullWorkcenterItems);
        $pdf = App::make('dompdf.wrapper');
        $no  = 1;
        $pdf->loadView('andon.barcode', compact('dataandon', 'no'));
        $pdf->setPaper('a4', 'portrait');
        return $pdf->stream('andonno.pdf');
    }
}