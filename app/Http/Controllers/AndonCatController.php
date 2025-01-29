<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AndonCategory;
use App\Models\Employees;

class AndonCatController extends Controller
{
    public function index()
    {
        $andcat = AndonCategory::with('employee')->get();

        return view('andcat.index', compact('andcat'));
    }

    public function edit($id)
    {
        $name = Employees::all();
        $andcat = AndonCategory::find($id);

        return view('andcat.edit', compact('andcat', 'name'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'Guard_EmployeeID' => 'required',
            'contact' => 'required',
            'nomorWA' => 'required|numeric|min:10',
        ]);

        $andcat = AndonCategory::find($id);

        $andcat->update([
            'Guard_EmployeeID' => $request->Guard_EmployeeID,
            'ContactPerson' => $request->contact,
            'HP_WA' => $request->nomorWA
        ]);

        session()->flash('updated', 'Data berhasil di update');

        return redirect()->route('andcat.index');
    }
}
