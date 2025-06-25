<?php

namespace App\Http\Controllers;

use App\Models\jadwalPeriksa;
use Illuminate\Http\Request;
use App\Models\DaftarPoli;
use App\Models\detailPeriksa;
use App\Models\Obat;
use App\Models\Periksa;

class dokterController extends Controller
{
    public function riwayatPeriksa()
    {
        $dokter = auth()->user();
        $jadwalDokter = JadwalPeriksa::where('id_dokter', $dokter->id)->pluck('id');
        $listPeriksa = DaftarPoli::whereIn('id_jadwal', $jadwalDokter)
            ->with([
                'pasien',
                'periksa.detailPeriksa.obat'
            ])
            ->get();

        return view('pages.dokter.riwayatPeriksa', compact('listPeriksa'));
    }

    public function jadwalPeriksa()
    {
        $dokter = auth()->user();
        $jadwalPeriksa = $dokter->jadwalPeriksa()->latest()->get();
        return view('pages.dokter.jadwal', compact('jadwalPeriksa'));
    }

    public function periksaPasien()
    {
        $dokter = auth()->user();
        $hariMap = [
            'Sunday'    => 'Minggu',
            'Monday'    => 'Senin',
            'Tuesday'   => 'Selasa',
            'Wednesday' => 'Rabu',
            'Thursday'  => 'Kamis',
            'Friday'    => 'Jumat',
            'Saturday'  => 'Sabtu',
        ];

        $hariIni = $hariMap[date('l')];

        $jadwalHariIni = JadwalPeriksa::where('id_dokter', $dokter->id)
            ->where('hari', $hariIni)
            ->pluck('id');

        $listPeriksa = DaftarPoli::whereIn('id_jadwal', $jadwalHariIni)
            ->whereDoesntHave('periksa')
            ->with('pasien')
            ->get();

        $listObat = Obat::all();

        return view('pages.dokter.periksa', compact('listPeriksa', 'listObat'));
    }


    public function CRUDPeriksa(Request $request)
    {
        $request->validate([
            'id_daftar_poli' => 'required|exists:daftar_polis,id',
            'tgl_periksa' => 'required|date',
            'catatan' => 'required|string',
            'biaya_periksa' => 'required|numeric',
            'obat' => 'nullable|array',
            'obat.*' => 'exists:obats,id',
        ]);

        $existing = Periksa::where('id_daftar_poli', $request->id_daftar_poli)->first();
        if ($existing) {
            toastr()->error('Pasien ini sudah pernah diperiksa, tidak bisa mengedit!');
            return redirect()->back();
        }

        $periksa = Periksa::create([
            'id_daftar_poli' => $request->id_daftar_poli,
            'tgl_periksa' => $request->tgl_periksa,
            'catatan' => $request->catatan,
            'biaya_periksa' => $request->biaya_periksa,
        ]);

        foreach ($request->obat ?? [] as $obat_id) {
            detailPeriksa::create([
                'id_periksa' => $periksa->id,
                'id_obat' => $obat_id,
            ]);
        }

        toastr()->success('Data periksa pasien berhasil disimpan!');
        return redirect()->route('periksaPasien.dokter');
    }



    public function CRUDJadwal(Request $request)
    {
        $dokter = auth()->user();

        // Toggle is_active Saja
        if (
            $request->filled('id') &&
            !$request->filled('hari') &&
            !$request->filled('jam_mulai') &&
            !$request->filled('jam_selesai')
        ) {
            $jadwal = $dokter->jadwalPeriksa()->findOrFail($request->id);

            // Kalau akan aktifkan
            if (!$jadwal->is_active) {
                // Nonaktifkan semua dulu
                $dokter->jadwalPeriksa()->update(['is_active' => false]);
                $jadwal->update(['is_active' => true]);
            } else {
                // Kalau mau matikan jadwal ini
                $jadwal->update(['is_active' => false]);
            }

            toastr()->success('Status jadwal berhasil diubah!');
            return redirect()->route('jadwalPeriksa.dokter');
        }


        // Validasi untuk tambah/update isi jadwal
        $request->validate([
            'id' => 'nullable|exists:jadwal_periksas,id',
            'hari' => 'required|string|max:255',
            'jam_mulai' => 'required|date_format:H:i',
            'jam_selesai' => 'required|date_format:H:i|after:jam_mulai',
        ]);

        if ($request->filled('id')) {
            $jadwal = $dokter->jadwalPeriksa()->findOrFail($request->id);

            if ($jadwal->hari === now()->format('l')) {
                toastr()->error('Tidak dapat mengubah jadwal di hari H!');
                return redirect()->back();
            }

            $bentrok = $dokter->jadwalPeriksa()
                ->where('id', '!=', $jadwal->id)
                ->where('hari', $request->hari)
                ->where(function ($q) use ($request) {
                    $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhere(function ($q2) use ($request) {
                            $q2->where('jam_mulai', '<=', $request->jam_mulai)
                                ->where('jam_selesai', '>=', $request->jam_selesai);
                        });
                })->exists();

            if ($bentrok) {
                toastr()->error('Jadwal bertabrakan dengan jadwal lain!');
                return redirect()->back();
            }

            $jadwal->update([
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
            ]);

            toastr()->success('Jadwal berhasil diperbarui!');
        } else {
            // Tambah baru
            $bentrok = $dokter->jadwalPeriksa()
                ->where('hari', $request->hari)
                ->where(function ($q) use ($request) {
                    $q->whereBetween('jam_mulai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhereBetween('jam_selesai', [$request->jam_mulai, $request->jam_selesai])
                        ->orWhere(function ($q2) use ($request) {
                            $q2->where('jam_mulai', '<=', $request->jam_mulai)
                                ->where('jam_selesai', '>=', $request->jam_selesai);
                        });
                })->exists();

            if ($bentrok) {
                toastr()->error('Jadwal bertabrakan dengan jadwal lain!');
                return redirect()->back();
            }

            $dokter->jadwalPeriksa()->update(['is_active' => false]);

            $dokter->jadwalPeriksa()->create([
                'hari' => $request->hari,
                'jam_mulai' => $request->jam_mulai,
                'jam_selesai' => $request->jam_selesai,
                'is_active' => true,
            ]);

            toastr()->success('Jadwal berhasil ditambahkan!');
        }

        return redirect()->route('jadwalPeriksa.dokter');
    }


    public function editProfile(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
        ]);

        $dokter = auth()->user();
        $dokter->update($request->only(['nama', 'alamat', 'no_hp']));

        toastr()->success('Profile berhasil diperbarui!');

        return redirect()->route('profile.dokter');
    }
}
