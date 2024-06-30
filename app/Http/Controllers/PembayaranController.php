<?php

namespace App\Http\Controllers;

use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Http\Requests\StorePembayaranRequest;
use App\Notifications\PembayaranKonfirmasiNotification;

class PembayaranController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $models = Pembayaran::latest();

        if ($request->filled('bulan')) {
            $models = $models->whereMonth('tanggal_bayar', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $models = $models->whereYear('tanggal_bayar', $request->tahun);
        }


        if ($request->filled('status')) {

            if ($request->status == "sudah-konfirmasi") {
                $models =  $models->whereNotNull('tanggal_konfirmasi');
            }

            if ($request->status == "belum-konfirmasi") {
                $models =  $models->whereNull('tanggal_konfirmasi');
            }
        }


        if ($request->filled('search')) {
            $models = $models->search($request->search, null, true);
        }

        return view('operator.pembayaran_index', [
            'models' => $models->orderBy('tanggal_konfirmasi', 'desc')->paginate(settings()->get('app_pagination', '50')),
            'title' => 'Pembayaran'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePembayaranRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePembayaranRequest $request)
    {
        $requestData = $request->validated();
        $requestData['tanggal_konfirmasi'] = now();
        $requestData['metode_pembayaran'] = 'manual';
        $tagihan = Tagihan::findOrFail($requestData['tagihan_id']);
        $requestData['wali_id'] = $tagihan->siswa->wali_id ?? 0;
        if ($requestData['jumlah_dibayar'] >= $tagihan->tagihanDetails->sum('jumlah_biaya')) {
            $tagihan->status = 'lunas';
            $tagihan->tanggal_lunas = now();
        }else {
            $tagihan->status = 'angsur';
        }

        $tagihan->save();
        $pembayaran = Pembayaran::create($requestData);
        $waliNotify = $pembayaran->wali;
        $waliNotify->notify(new PembayaranKonfirmasiNotification($pembayaran));
        flash()->addSuccess('Pembayaran berhasil disimpan');
        return back();
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
        return view('operator.pembayaran_show', [
            'model' => $pembayaran,
            'route' => ['pembayaran.update', $pembayaran->id],
            'method' => 'PUT'
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function edit(Pembayaran $pembayaran)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePembayaranRequest  $request
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Pembayaran $pembayaran)
    {
        $waliNotify = $pembayaran->wali;
        $waliNotify->notify(new PembayaranKonfirmasiNotification($pembayaran));
        $pembayaran->tanggal_konfirmasi = now();
        $pembayaran->user_id = auth()->user()->id;
        $pembayaran->save();
        $pembayaran->tagihan->status = 'lunas';
        $pembayaran->tagihan->tanggal_lunas = $pembayaran->tanggal_bayar;
        $pembayaran->tagihan->save();
        flash()->addSuccess('Data pembayaran berhasil dikonfirmasi');
        return back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Pembayaran  $pembayaran
     * @return \Illuminate\Http\Response
     */
    public function destroy(Pembayaran $pembayaran)
    {
        //
    }
}
