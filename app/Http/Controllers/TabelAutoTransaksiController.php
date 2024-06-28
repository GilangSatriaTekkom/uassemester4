<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TabelAutoTransaksiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $autoTransaksi = TabelAutoTransaksi::all();
        return response()->json($autoTransaksi);
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
        $autoTransaksi = new TabelAutoTransaksi;
        $autoTransaksi->Id_rekening = $request->Id_rekening;
        $autoTransaksi->tipe_transaksi = $request->tipe_transaksi;
        $autoTransaksi->penerima_transaksi = $request->penerima_transaksi;
        $autoTransaksi->jumlah_transaksi = $request->jumlah_transaksi;
        $autoTransaksi->tanggal_transaksi = $request->tanggal_transaksi;
        $autoTransaksi->status_transaksi = $request->status_transaksi;
        $autoTransaksi->save();

        return response()->json($autoTransaksi);
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
