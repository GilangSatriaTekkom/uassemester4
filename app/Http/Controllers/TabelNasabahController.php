<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TabelNasabahController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $nasabah = TabelNasabah::all();
        return response()->json($nasabah);
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
        $nasabah = new TabelNasabah;
        $nasabah->nama_nasabah = $request->nama_nasabah;
        $nasabah->alamat = $request->alamat;
        $nasabah->gender = $request->gender;
        $nasabah->no_hp = $request->no_hp;
        $nasabah->save();

        return response()->json($nasabah);
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
