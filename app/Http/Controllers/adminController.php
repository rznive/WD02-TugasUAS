<?php

namespace App\Http\Controllers;

use App\Models\Obat;
use App\Models\Dokter;
use App\Models\Poli;
use App\Models\Pasien;
use Illuminate\Support\Str;

class adminController extends Controller
{

    public function pasien()
    {
        $listPasien = Pasien::latest()->get();
        return view('pages.admin.pasien', compact('listPasien'));
    }

    public function crudPasien()
    {
        $year = date('Y');
        $month = date('m');
        $prefix = $year . $month;

        $lastPasien = Pasien::where('no_rm', 'like', "$prefix-%")
            ->orderBy('no_rm', 'desc')
            ->first();

        if ($lastPasien) {
            // Ambil nomor urutan terakhir dari no_rm, misalnya: 202506-3 → 3
            $lastNumber = (int) Str::after($lastPasien->no_rm, '-');
        } else {
            $lastNumber = 0;
        }

        $no_rm = $prefix . '-' . ($lastNumber + 1);

        $data = request()->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'no_rm' => 'nullable|string|max:255',
        ]);
        $data['no_rm'] = $no_rm;

        if (request('id')) {
            $pasien = Pasien::findOrFail(request('id'));
            $pasien->update($data);
        } else {
            Pasien::create($data);
        }

        toastr()->success('Pasien berhasil disimpan!');
        return redirect()->route('pasien.admin');
    }
    public function deletePasien($id)
    {
        $pasien = Pasien::findOrFail($id);
        $pasien->delete();
        toastr('Pasien berhasil dihapus!');
        return redirect()->route('pasien.admin');
    }

    public function dokter()
    {
        $listDokter = Dokter::latest()->get();
        $listPoli = Poli::latest()->get();
        return view('pages.admin.dokter', compact('listDokter', 'listPoli'));
    }

    public function crudDokter()
    {
        $data = request()->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:15',
            'id_poli' => 'required|string|max:255',
        ]);

        if (request('id')) {
            $dokter = Dokter::findOrFail(request('id'));
            $dokter->update($data);
        } else {
            Dokter::create($data);
        }

        toastr()->success('Dokter berhasil disimpan!');
        return redirect()->route('dokter.admin');
    }

    public function deleteDokter($id)
    {
        $dokter = Dokter::findOrFail($id);
        $dokter->delete();
        toastr()->success('Dokter berhasil dihapus!');
        return redirect()->route('dokter.admin');
    }

    public function poli()
    {
        $listPoli = Poli::latest()->get();
        return view('pages.admin.poli', compact('listPoli'));
    }

    public function crudPoli()
    {
        $data = request()->validate([
            'nama_poli' => 'required|string|max:255',
            'keterangan' => 'nullable|string|max:500',
        ]);

        if (request('id')) {
            $poli = Poli::findOrFail(request('id'));
            $poli->update($data);
        } else {
            Poli::create($data);
        }

        toastr()->success('Poli berhasil disimpan!');
        return redirect()->route('poli.admin');
    }

    public function deletePoli($id)
    {
        $poli = Poli::findOrFail($id);
        $poli->delete();
        toastr()->success('Poli berhasil dihapus!');
        return redirect()->route('poli.admin');
    }

    public function obat()
    {
        $listObat = Obat::latest()->get();
        return view('pages.admin.obat', compact('listObat'));
    }
    public function crudObat()
    {
        $data = request()->validate([
            'nama_obat' => 'required|string|max:255',
            'kemasan' => 'required|string|max:255',
            'harga' => 'required|string|max:255',
        ]);

        if (request('id')) {
            $obat = Obat::findOrFail(request('id'));
            $obat->update($data);
        } else {
            Obat::create($data);
        }

        toastr()->success('Obat berhasil disimpan!');
        return redirect()->route('obat.admin');
    }
    public function deleteObat($id)
    {
        $obat = Obat::findOrFail($id);
        $obat->delete();
        toastr()->success('Obat berhasil dihapus!');
        return redirect()->route('obat.admin');
    }
}
