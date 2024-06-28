<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Toggle;
use Illuminate\Support\Facades\DB;

class ToggleController extends Controller
{
    public function controlRelay(Request $request)
{
    // Validasi request
    $request->validate([
        'action' => 'required|in:start,stop',
    ]);

    // Ambil id yang spesifik, misalnya id 1
    $id = 1;

    // Ambil model Relay berdasarkan id
    $relay = Toggle::findOrFail($id);

    // Ubah state berdasarkan action
    if ($request->action === 'start') {
        $newState = 1;
    } elseif ($request->action === 'stop') {
        $newState = 0;
    }

    // Update state
    $relay->update([
        'value' => $newState
    ]);

    // Redirect atau response JSON sesuai kebutuhan
    return redirect()->back()->with('success', 'Status relay berhasil diubah.');
}

    public function getStatus()
    {
        $toggle = Toggle::first();
        $status = $toggle ? $toggle->value : 0;

        return response()->json(['status' => $status]);
    }
}
