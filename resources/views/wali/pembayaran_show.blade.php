@extends('layouts.layoutWali')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <h3><center>Data Pembayaran</center></h3>
        <div class="col-lg-12 col-md-5">
            <div class="card mb-3">
                <div class="container">
                    <h5>Informasi Tagihan</h5>
                    <div class="card-body px-0 pt-0 pb-2">
                        <h7>No : {{ $model->id }}</h7> <br>
                        <h7>ID Tagihan : {{ $model->tagihan_id }}</h7> <br>
                        <h7>Nama Siswa : {{ $model->tagihan->siswa->nama }}</h7> <br>
                        <h7>Nama Wali : {{ $model->wali->name }}</h7>
                        <hr>
                        <h5><center>Item Tagihan</center></h5>
                        <table class="table align-items-center mb-0">
                            <thead>
                                <tr>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama Biaya</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Biaya</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($model->tagihan->tagihanDetails as $item)
                                <tr>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->nama_biaya }}</p>
                                        </div>
                                    </td>
                                    <td>
                                        <div class="d-flex px-2 py-1">
                                            <p class="text-xs font-weight-bold mb-0">{{ formatRupiah($item->jumlah_biaya) }}</p>
                                        </div>
                                    </td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <div class="d-flex px-2 py-1">
                            <div class="text-sm font-weight-bold mb-0 "><b>Total Tagihan</b>
                                : <i>{{ formatRupiah($model->tagihan->tagihanDetails->sum('jumlah_biaya')) }}</i>
                               ({{ $model->tagihan->getStatusTagihanWali() }})
                               <a href="{{ route('invoice.show', $model->tagihan_id)}}" target="_blank"> Cetak</a>
                            </div>
                            <br>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            @if ($model->metode_pembayaran != "manual")
            <div class="col-lg-6 col-md-6">
                <div class="card mb-3">
                    <div class="container">
                        <h5><center>Informasi Pembayaran</center></h5>
                        <hr>
                        <div class="card-body px-0 pt-0 pb-2">
                            <table class="table">
                                <thead>
                                        <p><b><i>Bank Pengirim</i></b></p>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bank Pengirim</tr>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> :</tr>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> {{ $model->waliBank->nama_bank }}</tr>
                                        <br>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor Rekening</tr>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> :</tr>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> {{ $model->waliBank->no_rekening }}</tr>
                                        <br>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Pemilik Rekening</tr>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> :</tr>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> {{ $model->waliBank->nama_rekening }}</tr>
                                        <br>
                                        <hr>
                                        <p><b><i>Bank Tujuan</i></b></p>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bank Tujuan Transfer</tr>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> :</tr>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> {{ $model->bankSekolah->nama_bank }}</tr>
                                        <br>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nomor Rekening</tr>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> :</tr>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> {{ $model->bankSekolah->no_rekening }}</tr>
                                        <br>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Atas Nama</tr>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> :</tr>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> {{ $model->bankSekolah->nama_rekening }}</tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            @endif
            <div class="col-lg-6 col-md-6">
                <div class="card mb-3">
                    <div class="container">
                        <h5><center>Detail Pembayaran</center></h5>
                        <hr>
                        <div class="card-body px-0 pt-0 pb-2">
                            <table class="table">
                                <thead>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Metode Pembayaran</tr>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> :</tr>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> {{ $model->metode_pembayaran }}</tr>
                                    <br>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Bayar</tr>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> :</tr>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> {{ optional($model->tanggal_bayar)->translatedFormat('d F Y H:i') }}</tr>
                                    <br>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Total Tagihan</tr>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> :</tr>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> {{ formatRupiah($model->tagihan->tagihanDetails->sum('jumlah_biaya')) }}</tr>
                                    <br>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jumlah Yang Dibayar</tr>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> :</tr>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> {{ formatRupiah($model->jumlah_dibayar) }}</tr>
                                    <br>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Bukti Pembayaran</tr>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> :</tr>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                        <a  href="javascript:void[0]"
                                            onclick="popupCenter({url: '{{ \Storage::url($model->bukti_bayar) }}', title: 'Bukti Pembayaran', w: 800, h: 400}); "
                                            style="color:blue">
                                            Lihat Bukti Bayar
                                        </a>
                                    </tr>
                                    <br>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status Konfirmasi</tr>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> :</tr>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> {{ $model->status_konfirmasi }}</tr>
                                    <br>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Konfirmasi</tr>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> :</tr>
                                    <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7"> {{ optional($model->tanggal_konfirmasi)->translatedFormat('d F Y H:i') }}</tr>
                                    <br>
                                    <hr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
                {!! Form::open(['route' => $route,'method' => $method,
                                'onsubmit' => 'return confirm("Apakah Anda Yakin?")'
                               ])
                !!}
                @if ($model->tanggal_konfirmasi != null)
                    <div class="alert alert-success" role="alert">
                        <center>  <h6 style="color:white">Tagihan ini sudah Lunas</h6>
                            <a href="{{ route('kwitansipembayaran.show', $model->id) }}" target="_blank"><i class="fa fa file-pdf"></i> Download Kwitansi</a>
                        </center>
                    </div>
                @else
                    <div class="alert alert-danger" role="alert">
                        <center>  <h6 style="color:white">Tagihan ini belum dikonfirmasi</h6></center>
                    </div>
                @endif
            </div>
        </div>

    </div>
</div>
@endsection
