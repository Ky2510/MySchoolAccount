<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\Siswa;
use App\Models\Tagihan;
use App\Models\Pembayaran;
use Illuminate\Http\Request;
use App\Models\TagihanDetail;
use App\Models\Tagihan as Model;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\StoreTagihanRequest;
use App\Notifications\TagihanNotification;
use Illuminate\Support\Facades\Notification;

class TagihanController extends Controller
{

    private $viewIndex = 'tagihan_index';
    private $viewForm = 'tagihan_form';
    private $viewShow = 'tagihan_show';
    private $routePrefix = 'tagihan';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $models =  Model::latest();

        if ($request->filled('bulan')) {
            $models = $models->whereMonth('tanggal_tagihan', $request->bulan);
        }

        if ($request->filled('tahun')) {
            $models = $models->whereYear('tanggal_tagihan', $request->tahun);
        }


        if ($request->filled('status')) {
            $models = $models->where('status', $request->status);
        }


        if ($request->filled('search')) {
            $models = $models->search($request->search, null, true);
        }

        return view('operator.' . $this->viewIndex, [
            'models' => $models->paginate(settings()->get('app_pagination', '50')),
            'routePrefix' => $this->routePrefix,
            'title' => 'Tagihan'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        $data = [
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'Form Tagihan',
            'routePrefix' => $this->routePrefix,
        ];
        return view('operator.' . $this->viewForm, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTagihanRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTagihanRequest $request)
    {
        $requestData = $request->validated();
        DB::beginTransaction();
        // ambil semua data siswa dengan status Aktif
        $siswa = \App\Models\Siswa::currentStatus('aktif')->get();
        foreach ($siswa as $itemSiswa) {
            $requestData['siswa_id'] = $itemSiswa->id;
            $requestData['status'] = 'baru';
            $tanggalTagihan = Carbon::parse($requestData['tanggal_tagihan']);
            $bulanTagihan = $tanggalTagihan->format('m');
            $tahunTagihan = $tanggalTagihan->format('Y');
            $cekTagihan = Model::where('siswa_id', $itemSiswa->id)
                                 ->whereMonth('tanggal_tagihan', $bulanTagihan)
                                 ->whereYear('tanggal_tagihan', $tahunTagihan)
                                 ->first();
                if ($cekTagihan == null) {
                    $tagihan = Tagihan::create($requestData);
                    if ($tagihan->siswa->wali != null) {
                        Notification::send($tagihan->siswa->wali, new TagihanNotification($tagihan));
                    }
                    $biaya  = $itemSiswa->biaya->children;
                    foreach ($biaya as $itemBiaya) {
                        $detail = TagihanDetail::create([
                            'tagihan_id' => $tagihan->id,
                            'nama_biaya' => $itemBiaya->nama,
                            'jumlah_biaya' => $itemBiaya->jumlah
                        ]);
                    }
                }
        }

        DB::commit();

        // flash('Data tagihan berhasi disimpan')->success();
        // return back();
        return response()->json([
            'message' => 'Data berhasil disimpan'
        ], 200);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        $siswa =  Siswa::findOrFail($request->siswa_id);
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
        $data['kartuTagihan'] = collect($arrayData);
        $tagihan = Model::with('pembayaran')->findOrFail($id);
        $data['tagihan'] = $tagihan;
        $data['siswa'] = $tagihan->siswa;
        $data['periode'] = Carbon::parse($tagihan->tanggal_tagihan)->translatedFormat ('F Y');
        $data['model'] = new Pembayaran();
        return view('operator.' . $this->viewShow, $data, [
            'title_siswa' => 'DATA TAGIHAN SPP SISWA',
            'title_tagihan' => 'Data Tagihan',
            'title_kartuSPP' => 'Data Kartu SPP',
            'title_pembayaran' => 'Data Pembayaran',
            'title' => 'Detail Tagihan',
            'routePrefix' => $this->routePrefix
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Tagihan  $tagihan
     * @return \Illuminate\Http\Response
     */
    public function destroy(Model $tagihan)
    {
        //
    }
}
