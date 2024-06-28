<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TabelRekeningController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $rekening = TabelRekening::all();
        return response()->json($rekening);
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
        $rekening = new TabelRekening;
        $rekening->Id_nasabah = $request->Id_nasabah;
        $rekening->nomor_akun = $request->nomor_akun;
        $rekening->jumlah_tabungan = $request->jumlah_tabungan;
        $rekening->tanggal_buat = $request->tanggal_buat;
        $rekening->tanggal_update = $request->tanggal_update;
        $rekening->save();

        return response()->json($rekening);
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
}
