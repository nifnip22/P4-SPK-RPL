<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PetugasController extends Controller
{
    public function index()
    {
        $users = User::where('level', 'Petugas')->get();
        // $users = User::all();

        return view('lib.petugas', [
            'title' => 'Data Petugas | PicoPick',
            'users' => $users,
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', 'min:8'],
            'level' => ['required', 'string', 'max:255'],
        ]);

        User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'level' => $request->level,
        ]);

        return redirect()->route('data-petugas.index')->with('petugas_success', 'Petugas Berhasil di Register!');
    }

    public function destroy($id)
    {
        $user = User::findOrFail($id);

        if ($user->delete()) {
            return redirect()->route('data-petugas.index')->with('deletePetugas_success', 'Petugas Berhasil di Hapus!');
        } else {
            return redirect()->route('data-petugas.index')->with('deletePetugas_error', 'Terjadi Kesalahan!');
        }
    }

    public function search(Request $request)
    {
        $query = $request->input('name');

        $users = User::where('level', 'Petugas')
            ->when($query, function ($query, $name) {
                return $query->where('name', 'LIKE', '%' . $name . '%');
            })
            ->get();

        return view('lib.petugas', [
            'title' => 'Data Petugas | PicoPick',
            'users' => $users,
        ])->with('searchInput', $request->all());
    }
}
