<?php

namespace App\Http\Controllers;

use App\Models\Siswa;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WaliMuridSiswaController extends Controller
{
    public function index()
    {
      $data['models'] =  Auth::user()->siswa;
      return view('wali.siswa_index', $data);
    }

    public function show($id)
    {
        $data['model'] =  Siswa::with('biaya', 'biaya.children')->where('id', $id)->where('wali_id', auth()->user()->id)->firstOrFail();
        $data['title'] = 'Detail Siswa';
        return view('wali.siswa_show', $data);
    }
}
