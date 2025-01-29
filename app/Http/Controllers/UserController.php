<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use App\Models\AndonCategory;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    public function index()
    {
        $user = User::with('role', 'andoncat')->get();

        $title = 'Delete User!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('user.index', compact('user'));
    }

    public function create()
    {
        // Tampilkan halaman create
        $roles = Role::all();
        $andoncat = AndonCategory::all();
        return view('user.create', compact('roles', 'andoncat'));
    }

    public function store(Request $request)
    {
        $rules = [
            'username' => 'required|unique:users',
            'password' => 'required|min:8',
            'role' => 'required',
        ];

        // Periksa apakah peran yang dipilih adalah 'admin'
        if ($request->role == 2) {
            // Jika bukan 'admin', tambahkan validasi 'andoncat'
            $rules['andoncat'] = 'required';
        }

        $validated = $request->validate($rules, [
            'username.unique' => 'Username already exists.',
        ]);

        // Simpan data ke database
        $user = User::create([
            'username' => $request->username,
            'password' => bcrypt($request->password),
            'role_id' => $request->role,
            'andoncat_id' => ($request->role == 2) ? $request->andoncat : null
        ]);

        if ($request->role == 2) {
            $user->andoncat_id = $request->andoncat;
        } else {
            // Jika peran yang dipilih adalah 'admin', pastikan 'andoncat' di-set ke null
            $user->andoncat_id = null;
        }

        // menampilkan message success
        session()->flash('added', 'Data Berhasil Ditambahkan.');

        // Arahkan ke halaman
        return redirect()->route('user.index');
    }

    public function edit($id)
    {
        // Ambil data user berdasarkan id
        $user = User::find($id);

        $roles = Role::all();
        $andoncat = AndonCategory::all();

        // Tampilkan halaman edit dengan passing data user dan roles
        return view('user.edit', compact('user', 'roles', 'andoncat'));
    }

    public function update(Request $request, $id)
    {
        // Validasi
        $validated = $request->validate([
            'username' => 'required|unique:users,username,' . $id,
            'password' => 'nullable|min:8',
            'role' => 'required',
        ], [
            'username.unique' => 'Username already exists.',
        ]);

        // Periksa apakah peran yang dipilih adalah 'admin'
        if ($request->role == 2) {
            // Jika 'Andon', tambahkan validasi 'andoncat'
            $validated = $request->validate([
                'andoncat' => 'required',
            ]);
        }

        // Ambil data user yang akan diedit
        $user = User::find($id);

        if (!$user) {
            return redirect()->back()->with('error', 'User not found.');
        }

        // Update data user
        $user->username = $request->username;

        // Hanya jika password diisi, maka update password
        if (!empty($request->password)) {
            $user->password = bcrypt($request->password);
        }

        $user->role_id = $request->role;

        // Hanya jika peran yang dipilih bukan 'admin', maka update 'andoncat'
        if ($request->role == 2) {
            $user->andoncat_id = $request->andoncat;
        } else {
            // Jika peran yang dipilih adalah 'admin', pastikan 'andoncat' di-set ke null
            $user->andoncat_id = null;
        }

        $user->save();

        // Menampilkan pesan sukses
        session()->flash('updated', 'Data Berhasil Di Update.');

        // Arahkan ke halaman yang sesuai
        return redirect()->route('user.index');
    }

    public function destroy($id)
    {
        // Ambil data user berdasarkan id
        $user = User::find($id);

        // Hapus data user
        $user->delete();

        // menampilkan pesan success di session
        session()->flash('deleted', 'Data Berhasil Dihapus.');

        // Redirect ke halaman user.index
        return redirect()->route('user.index');
    }
}
