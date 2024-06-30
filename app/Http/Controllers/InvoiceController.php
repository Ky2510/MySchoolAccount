<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class InvoiceController extends Controller
{
    public function show($id)
    {
        if (auth()->user()->akses == 'wali') {
            $tagihan =  Tagihan::waliSiswa()->findOrFail($id);
        }else{
            $tagihan =  Tagihan::findOrFail($id);
        }
        $title = "Cetak Invoice Tagihan Bulan" . $tagihan->tanggal_tagihan->translatedFormat('F Y');
        if (request('output') == 'pdf') {
            $pdf = Pdf::loadView('invoice', compact('tagihan','title'));
            $namaFile = "Invoice Tagihan " . $tagihan->siswa->nama . ' Bulan ' .  $tagihan->tanggal_tagihan->translatedFormat('F Y') . '.pdf';
            return $pdf->download($namaFile);
        }
        return view('invoice', compact('tagihan','title'));
    }
}
