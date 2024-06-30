<?php

namespace App\Http\Controllers;

use App\Models\Pembayaran;
use Illuminate\Http\Request;

class LaporanPembayaranController extends Controller
{
    public function index(Request $request)
    {
        $pembayaran = Pembayaran::query();
        $title = "";

        if ($request->filled('bulan')) {
            $pembayaran = $pembayaran->whereMonth('tanggal_bayar', $request->bulan);
            $title = $title . " Bulan " . ubahNamaBulan($request->bulan);
        }

        if ($request->filled('tahun')) {
            $pembayaran = $pembayaran->whereYear('tanggal_bayar', $request->tahun);
            $title = $title . " " . $request->tahun;
        }

        if ($request->filled('status')) {
            $pembayaran = $pembayaran->where('status', $request->status);
            $title = $title . " Status Tagihan " . '"' . $request->status . '"';
        }

        if ($request->filled('angkatan')) {
            $pembayaran = $pembayaran->whereHas('tagihan', function($q) use ($request){
                $q->whereHas('siswa', function($q) use ($request){
                   $q->where('angkatan', $request->angkatan);
                });
            });
            $title = $title . " Angkatan " . $request->angkatan;
        }

        if ($request->filled('kelas')) {
            $pembayaran = $pembayaran->whereHas('tagihan', function($q) use ($request){
                $q->whereHas('siswa', function($q) use ($request){
                    $q->where('kelas', $request->kelas);
                 });
            });
            $title = $title . " Kelas " . $request->kelas;
        }

        $pembayaran = $pembayaran->get();

        return view('operator.laporanpembayaran_index', compact('pembayaran','title'));

    }
}
