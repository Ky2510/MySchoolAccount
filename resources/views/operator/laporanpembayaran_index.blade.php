@extends('layouts.appbackendblank')

@section('content')
<div class="d-flex justify-content-center row">
    <div class="col-md-12">
        <div class="p-3 bg-white rounded">
            <div class="row">
                <div class="col-md-12">
                    @include('komponen.kop-sekolah')
                    Laporan Bedasarkan {{ $title }}
                    <div class="mt-3">
                        <div class="table-responsive p-0">
                            <table class="table table-striped table-bordered">
                                <thead style="color:white; background-color: black">
                                    <tr>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">NISN</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Nama</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Angkatan</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Tanggal Bayar</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Metode Pembayaran</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Status Konfirmasi</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Tanggal Konfirmasi</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Jumlah Bayar</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse ($pembayaran as $item)
                                    <tr>
                                        <td style="background-color: whitesmoke">
                                            <div class="d-flex px-2 py-1">
                                                <p class="text-xs  mb-0">{{ $loop->iteration }}</p>
                                            </div>
                                        </td>
                                        <td style="background-color: whitesmoke">
                                            <div class="d-flex px-2 py-1">
                                                <p class="text-xs  mb-0">{{ $item->tagihan->siswa->nisn }}</p>
                                            </div>
                                        </td>
                                        <td style="background-color: whitesmoke">
                                            <div class="d-flex px-2 py-1">
                                                <p class="text-xs  mb-0">{{ $item->tagihan->siswa->nama }}</p>
                                            </div>
                                        </td>
                                        <td style="background-color: whitesmoke">
                                            <div class="d-flex px-2 py-1">
                                                <p class="text-xs  mb-0">{{ $item->tagihan->siswa->angkatan }}</p>
                                            </div>
                                        </td>
                                        <td style="background-color: whitesmoke">
                                            <div class="d-flex px-2 py-1">
                                                <p class="text-xs  mb-0">{{ $item->tanggal_bayar->translatedFormat('d-M-Y') }}</p>
                                            </div>
                                        </td>
                                        <td style="background-color: whitesmoke">
                                            <div class="d-flex px-2 py-1">
                                                <p class="text-xs  mb-0">{{ $item->metode_pembayaran }}</p>
                                            </div>
                                        </td>
                                        <td style="background-color: whitesmoke">
                                            <div class="d-flex px-2 py-1">
                                                <p class="text-xs  mb-0">{{ $item->status_konfirmasi }}</p>
                                            </div>
                                        </td>
                                        <td style="background-color: whitesmoke">
                                            <div class="d-flex px-2 py-1">
                                                <p class="text-xs  mb-0">{{ $item->tanggal_konfirmasi->translatedFormat('d-M-Y') }}</p>
                                            </div>
                                        </td>
                                        <td style="background-color: whitesmoke">
                                            <div class="d-flex px-2 py-1">
                                                <p class="text-xs  mb-0">{{ formatRupiah($item->jumlah_dibayar) }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @empty
                                    <tr>
                                        <td colspan="7">Data Tidak Ada</td>
                                    </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
