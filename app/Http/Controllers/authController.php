<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Support\Facades\Auth;
use App\Models\Pasien;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class authController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'no_rm' => 'nullable|string|max:255',
        ]);

        if (Pasien::where('no_ktp', $request->no_ktp)->exists()) {
            toastr()->error('No KTP sudah terdaftar');
            return redirect()->back()->withInput();
        }

        $year = date('Y');
        $month = date('m');
        $prefix = $year . $month;

        $lastPasien = Pasien::where('no_rm', 'like', "$prefix-%")
            ->orderBy('no_rm', 'desc')
            ->first();

        if ($lastPasien) {
            $lastNumber = (int) Str::after($lastPasien->no_rm, '-');
        } else {
            $lastNumber = 0;
        }

        $no_rm = $prefix . '-' . ($lastNumber + 1);

        $user = Pasien::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'no_rm' => $no_rm,
        ]);

        toastr()->success('Registrasi berhasil, silahkan login untuk melanjutkan');
        return redirect()->route('loginPasien');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        $pasien = Pasien::where('nama', $request->nama)
            ->where('alamat', $request->alamat)
            ->first();

        if ($pasien) {
            Auth::guard('pasien')->login($pasien);
            toastr()->success('Login berhasil, selamat datang ' . $pasien->nama);
            return redirect()->route('dashboard.pasien');
        }

        toastr()->error('User tidak ditemukan, silakan periksa kembali data yang Anda masukkan.');
        return redirect()->back()->withInput();
    }


    public function registerDokter(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_hp' => 'required|string|max:255',
            'id_poli' => 'required|integer',
        ]);

        $user = Pasien::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_hp' => $request->no_hp,
        ]);
        return response()->json([
            'message' => 'Registrasi dokter berhasil',
            'user' => $user
        ], 201);
    }

    public function loginDokter(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);


        $admin = User::where('nama', $request->nama)
            ->where('alamat', $request->alamat)
            ->first();

        if ($admin) {
            Auth::guard('web')->login($admin);
            toastr()->success('Autentikasi berhasil. Selamat datang, Admin ' . $admin->nama);
            return redirect()->route('dashboard.admin');
        }


        $dokter = Dokter::where('nama', $request->nama)
            ->where('alamat', $request->alamat)
            ->first();

        if ($dokter) {
            Auth::guard('dokter')->login($dokter);
            toastr()->success('Autentikasi berhasil. Selamat datang, Dokter ' . $dokter->nama);
            return redirect()->route('dashboard.dokter');
        }

        toastr()->error('Data tidak ditemukan. Pastikan nama dan alamat Anda benar.');
        return redirect()->back()->withInput();
    }
}
