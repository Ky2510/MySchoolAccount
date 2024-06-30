<?php

namespace App\Http\Controllers;

use App\Models\BankSekolah;
use App\Models\Tagihan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliMuridTagihanController extends Controller
{
    public function index()
    {
        $data['tagihan'] = Tagihan::WaliSiswa()->get();
        return view('wali.tagihan_index', $data);
    }

    public function show($id)
    {
        $tagihan = Tagihan::WaliSiswa()->findOrFail($id);
        $data['bankSekolah'] = BankSekolah::all();
        $data['tagihan'] = $tagihan;
        $data['siswa'] = $tagihan->siswa;
        return view('wali.tagihan_show', $data);
    }
}
