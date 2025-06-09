<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Pasien;
use Illuminate\Http\Request;

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
            // return response()->json([
            //     'message' => 'No KTP sudah terdaftar',
            // ], 400);
            toastr()->error('No KTP sudah terdaftar');
            return redirect()->back()->withInput();
        }

        $year = date('Y');
        $month = date('m');
        $count = Pasien::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();
        $no_rm = $year . $month . '-' . ($count + 1);

        $user = Pasien::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'no_rm' => $no_rm,
        ]);
        // return response()->json([
        //     'message' => 'Registrasi berhasil',
        //     'user' => $user
        // ], 201);

        toastr()->success('Registrasi berhasil, silahkan login untuk melanjutkan');
        return redirect()->route('login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
        ]);

        $user = Pasien::where('nama', $request->nama)
            ->where('alamat', $request->alamat)
            ->first();

        if (!$user) {
            toastr()->error('User tidak ditemukan, silahkan periksa kembali data yang anda masukkan');
            return redirect()->back()->withInput();
        }
        Auth::login($user);
        toastr()->success('Login berhasil, selamat datang ' . $user->nama);
        return redirect()->route('dashboard.pasien');
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
}
