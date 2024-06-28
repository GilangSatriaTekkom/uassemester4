<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TabelNotifikasiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $notifikasi = TabelNotifikasi::all();
        return response()->json($notifikasi);
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
        $notifikasi = new TabelNotifikasi;
        $notifikasi->Id_nasabah = $request->Id_nasabah;
        $notifikasi->pesan = $request->pesan;
        $notifikasi->is_read = $request->is_read;
        $notifikasi->tanggal_buat = $request->tanggal_buat;
        $notifikasi->save();

        return response()->json($notifikasi);
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
