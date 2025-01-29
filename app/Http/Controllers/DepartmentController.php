<?php

namespace App\Http\Controllers;

use App\Models\Department;
use Illuminate\Http\Request;

class DepartmentController extends Controller
{
    public function index()
    {

        $dept = Department::all();
        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('department.index', compact('dept'));
    }

    public function create()
    {
        // tampilkan halaman create
        return view('department.create');
    }

    public function store(Request $request)
    {
        // validasi data
        $validated = $request->validate([
            'name' => 'required|unique:tbldepartment',
        ], [
            'name.unique' => 'The Department Name already exists.',
        ]);

        // insert data ke table roles
        $department = Department::create([
            'name' => $request->name,
        ]);

        // membuat session message
        session()->flash('added', 'Data berhasil ditambahkan');

        // alihkan halaman ke halaman roles
        return redirect()->route('department.index');
    }

    public function edit($id)
    {
        // ambil data role berdasarkan id
        $department = Department::find($id);

        // tampilkan view edit dan passing data role
        return view('department.edit', compact('department'));
    }

    public function update(Request $request, $id)
    {
        // validasi data
        $validated = $request->validate([
            'name' => 'required',
        ]);

        // ambil data role berdasarkan id
        $department = Department::find($id);

        // update data role
        $department->update([
            'name' => $request->name,
        ]);

        // membuat session message
        session()->flash('updated', 'Data berhasil di update');

        // alihkan halaman ke halaman roles
        return redirect()->route('department.index');
    }

    public function destroy($id)
    {
        // ambil data role berdasarkan id
        $department = Department::find($id);

        // hapus data role
        $department->delete();

        // menampilkan pesan success di session
        session()->flash('deleted', 'Data Berhasil Dihapus.');

        // alihkan halaman ke department.index
        return redirect()->route('department.index');
    }
}
