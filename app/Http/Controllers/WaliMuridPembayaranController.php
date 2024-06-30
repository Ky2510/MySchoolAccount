<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\User;
use App\Models\Tagihan;
use App\Models\WaliBank;
use App\Models\Pembayaran;
use App\Models\BankSekolah;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Notification;
use App\Notifications\PembayaranNotification;

class WaliMuridPembayaranController extends Controller
{
    public function index()
    {
        $pembayaran =  Pembayaran::where('wali_id', auth()->user()->id)
                                   ->latest()->orderBy('tanggal_konfirmasi', 'desc')
                                   ->paginate(50);
        $data['models'] = $pembayaran;
        return view('wali.pembayaran_index', $data);
    }

    public function create(Request $request)
    {
        $data['listWaliBank'] = WaliBank::where('wali_id', Auth::user()->id)->get()->pluck('nama_bank_full', 'id');
        $data['tagihan'] = Tagihan::waliSiswa()->findOrFail($request->tagihan_id);
        $data['model'] = new Pembayaran();
        $data['method'] = 'POST';
        $data['route'] = 'wali.pembayaran.store';
        $data['listBankSekolah'] = BankSekolah::pluck('nama_bank', 'id');
        $data['listBank'] = Bank::pluck('nama_bank', 'id');
        if ($request->bank_sekolah_id != '') {
            $data['bankYangDipilih'] = BankSekolah::findOrFail($request->bank_sekolah_id);
        }
        $data['url'] = route('wali.pembayaran.create', [
                'tagihan_id' => $request->tagihan_id,
            ]);
        return view('wali.pembayaran_form', $data);
    }

    public function store(Request $request)
    {
        if ($request->wali_bank_id == '' && $request->no_rekening == '') {
            flash()->addError('Silahkan pilih bank pengirim');
            return back();
        }

        if($request->nama_rekening != '' && $request->no_rekening != ''){
            // Wali membuat rekening baru
            $bankId = $request->bank_id;
            $bank = Bank::findOrFail($bankId);
            if ($request->filled('simpan_data_rekening')) {
                $requestDataBank = $request->validate([
                    'nama_rekening' => 'required',
                    'no_rekening' => 'required',
                ]);
                $waliBank = WaliBank::firstOrCreate(
                   $requestDataBank,
                    [
                        'nama_rekening' => $requestDataBank['nama_rekening'],
                        'wali_id' => Auth::user()->id,
                        'kode' => $bank->sandi_bank,
                        'nama_bank' => $bank->nama_bank,
                    ]
                );
            }
        }else{
            // Ambil Data Wali Bank dari database
            $waliBankId = $request->wali_bank_id;
            $waliBank = WaliBank::findOrFail($waliBankId);
        }

        $jumlahDibayar = str_replace('.', '', $request->jumlah_dibayar);
        $validasiPembayaran = Pembayaran::where('jumlah_dibayar',  $jumlahDibayar)
                                        ->where('tagihan_id', $request->tagihan_id)
                                        // ->where('status_konfirmasi', 'Belum Konfirmasi')
                                        ->first();
        if ($validasiPembayaran != null) {
            flash()->addError('Data Pembayaran sudah dilakukan sebelumnya dan akan segera dikonfirmasi oleh operator');
            return back();
        }

        $request->validate([
            'tanggal_bayar' => 'required',
            'jumlah_dibayar' => 'required',
            'bukti_bayar' => 'required|mimes:jpeg,png,jpg,gif,svg|max:5048'
        ]);

        $buktiBayar = $request->file('bukti_bayar')->store('public');
        $dataPembayaran = [
            'bank_sekolah_id' => $request['bank_sekolah_id'],
            'wali_bank_id' => $waliBank->id,
            'tagihan_id' => $request['tagihan_id'],
            'wali_id' => auth()->user()->id,
            'tanggal_bayar' => $request->tanggal_bayar,
            'jumlah_dibayar' => $jumlahDibayar,
            'bukti_bayar' => $buktiBayar,
            'metode_pembayaran' => 'transfer',
            'user_id' => 0,
        ];

        $tagihan = Tagihan::findOrFail($request->tagihan_id);
        if ($jumlahDibayar >= $tagihan->total_tagihan) {
            DB::beginTransaction();
            try {
                $pembayaran = Pembayaran::create($dataPembayaran);
                $userOperator = User::where('akses','operator')->get();
                    
                DB::commit();
            } catch (\Throwable $th) {
                DB::rollback();
                flash()->addError('Gagal menyimpan pembayaran,' . $th->getMessage());
            }
            flash()->addSuccess('Pembayaran telah selesai dan akan segera dikonfirmasi oleh admin, TERIMA KASIH');
            return redirect()->route('wali.pembayaran.show', $pembayaran->id);
        }else{
            flash()->addError('Jumlah pembayaran tidak boleh kurang dari total tagihan');
            return back();
        }
    }

     /**
     * Display the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function show(Pembayaran $pembayaran)
    {
        auth()->user()->unreadNotifications->where('id', request('id'))->first()?->markAsRead();
        return view('wali.pembayaran_show', [
            'model' => $pembayaran,
            'route' => ['pembayaran.update', $pembayaran->id],
            'method' => 'PUT'
        ]);
    }

    public function destroy($id)
    {
        $pembayaran = Pembayaran::findOrFail($id);
        if ($pembayaran->tanggal_konfirmasi != null) {
            flash()->addError('Pembayaran sudah dikonfirmasi,tidak bisa dibatalkan');
            return redirect()->back();
        }
        Storage::delete($pembayaran->bukti_bayar);
        $pembayaran->delete();
        flash()->addSuccess('Pembayaran berhasil dibatalkan');
        return redirect()->route('wali.pembayaran.index');
    }

}
