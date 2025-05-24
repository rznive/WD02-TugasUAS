<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class authController extends Controller
{
    public function register(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string|max:255',
            'no_ktp' => 'required|string|max:255|unique:users,no_ktp',
            'no_hp' => 'required|string|max:255',
            'no_rm' => 'nullable|string|max:255',
        ]);

        $year = date('Y');
        $month = date('m');
        $count = User::whereYear('created_at', $year)
            ->whereMonth('created_at', $month)
            ->count();
        $no_rm = $year . $month . '-' . ($count + 1);

        $user = User::create([
            'nama' => $request->nama,
            'alamat' => $request->alamat,
            'no_ktp' => $request->no_ktp,
            'no_hp' => $request->no_hp,
            'no_rm' => $no_rm,
        ]);
        return response()->json([
            'message' => 'Registrasi berhasil',
            'user' => $user
        ], 201);
    }
}
