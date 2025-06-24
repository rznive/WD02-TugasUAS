<?php

namespace App\Http\Controllers;

use App\Models\DaftarPoli;
use App\Models\jadwalPeriksa;
use App\Models\Poli;
use Illuminate\Http\Request;

class pasienController extends Controller
{
    public function Poli()
    {
        $poliList = Poli::latest()->get();
        $showDaftarPoli = DaftarPoli::where('id_pasien', auth()->user()->id)->get();
        return view('pages.pasien.poli', compact('poliList', 'showDaftarPoli'));
    }
    public function getJadwalByPoli($id_poli)
    {
        $jadwalList = jadwalPeriksa::whereHas('dokter', function ($query) use ($id_poli) {
            $query->where('id_poli', $id_poli);
        })->where('is_active', true)->get();

        return response()->json($jadwalList);
    }


    public function CRUDPoli(Request $request)
    {
        $request->validate([
            'keluhan' => 'required|string',
            'id_jadwal' => 'required',
        ]);

        $id_pasien = auth()->user()->id;

        // Hitung no antrian
        $lastAntrian = DaftarPoli::where('id_jadwal', $request->id_jadwal)->max('no_antrian');
        $no_antrian = $lastAntrian ? $lastAntrian + 1 : 1;

        DaftarPoli::create([
            'id_pasien' => $id_pasien,
            'id_jadwal' => $request->id_jadwal,
            'keluhan' => $request->keluhan,
            'no_antrian' => $no_antrian,
        ]);

        toastr()->success('Berhasil mendaftar poli');
        return redirect()->back();
    }
}
