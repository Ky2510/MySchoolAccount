<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class KartuSppController extends Controller
{
    public function index(Request $request)
    {
        if (auth()->user()->akses == 'wali') {
            $siswa =  Siswa::where('wali_id', auth()->user()->id)
                           ->where('id',$request->siswa_id)
                           ->firstOrFail();
        }else{
            $siswa =  Siswa::findOrFail($request->siswa_id);
        }

        $tahun = $request->tahun;
        $arrayData = [];
        foreach (bulanTagihan() as $bulan) {
            if ($bulan == 1) {
                $tahun = $tahun + 1;
            }
            $tagihan = Tagihan::where('siswa_id', $request->siswa_id)
                                      ->whereYear('tanggal_tagihan', $tahun)
                                      ->whereMonth('tanggal_tagihan', $bulan)
                                      ->first();
                        $tanggalBayar = '';
                        if ($tagihan != null && $tagihan->status != 'baru') {
                            $tanggalBayar = $tagihan->pembayaran->first()->tanggal_bayar->format('d/m/y');
                        }
            $arrayData[] = [
                'bulan' => ubahNamaBulan($bulan),
                'tahun' => $tahun,
                'total_tagihan' => $tagihan->total_tagihan ?? 0,
                'status_tagihan' => ($tagihan == null) ? false:true,
                'status_pembayaran' => ($tagihan == null) ? 'Belum Bayar' : $tagihan->status,
                'tanggal_bayar' => $tanggalBayar,
            ];
        }

        if (request('output') == 'pdf') {
            $pdf = Pdf::loadView('kartuspp', [
                    'kartuTagihan' => collect($arrayData),
                    'siswa' => $siswa
                ]);
            $namaFile = "Kartu Tagihan " . $siswa->nama . ' Tahun ' .  $request->tahun . '.pdf';
            return $pdf->stream($namaFile);
        }

        return view('kartuspp', [
            'kartuTagihan' => collect($arrayData),
            'siswa' => $siswa
        ]);
    }
}
