<?php

namespace App\Http\Controllers;

use App\Models\Pelanggan;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\StorePelangganRequest;
use App\Http\Requests\UpdatePelangganRequest;

class PelangganController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Daftar Member Pelanggan | PicoPick";

        return view('lib.pelanggan', [
            'title' => $title,
        ]);
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
    public function store(StorePelangganRequest $request)
    {
        $request->validate([
            'nama_pelanggan' => ['required', 'unique:pelanggans,nama_pelanggan' ,'string', 'max:255'],
            'alamat' => ['required', 'string'],
            'no_telp' => ['required', 'string', 'max:15'],
        ]);

        Pelanggan::create([
            'nama_pelanggan' => $request->input('nama_pelanggan'),
            'alamat' => $request->input('alamat'),
            'no_telp' => $request->input('no_telp'),
        ]);

        return redirect()->route('daftar-pelanggan.index')->with('tambahMember_success', 'Pelanggan Berhasil Menjadi Member!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePelangganRequest $request, Pelanggan $pelanggan)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pelanggan $pelanggan)
    {
        //
    }
}
