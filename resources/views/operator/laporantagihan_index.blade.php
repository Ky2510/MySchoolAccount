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
                        <table class="table table-striped table-bordered">
                            <thead style="color:white; background-color: black">
                            <tr>
                                <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">No</th>
                                <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">NISN</th>
                                <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Nama</th>
                                <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Kelas</th>
                                <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Jurusan</th>
                                <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Angkatan</th>
                                <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Hari Tanggal Tagihan</th>
                                <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Status</th>
                                <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Total Tagihan</th>
                            </tr>
                            </thead>
                            <tbody>
                                @forelse ($tagihan as $item)
                                <tr>
                                    <td style="background-color: whitesmoke">
                                        <div class="d-flex px-2 py-1">
                                            <p class="text-xs  mb-0">{{ $loop->iteration }}</p>
                                        </div>
                                    </td>
                                    <td style="background-color: whitesmoke">
                                        <div class="d-flex px-2 py-1">
                                            <p class="text-xs  mb-0">{{ $item->siswa->nisn }}</p>
                                        </div>
                                    </td>
                                    <td style="background-color: whitesmoke">
                                        <div class="d-flex px-2 py-1">
                                            <p class="text-xs  mb-0">{{ $item->siswa->nama }}</p>
                                        </div>
                                    </td>
                                    <td style="background-color: whitesmoke">
                                        <div class="d-flex px-2 py-1">
                                            <p class="text-xs  mb-0">{{ $item->siswa->kelas }}</p>
                                        </div>
                                    </td>
                                    <td style="background-color: whitesmoke">
                                        <div class="d-flex px-2 py-1">
                                            <p class="text-xs  mb-0">{{ $item->siswa->jurusan }}</p>
                                        </div>
                                    </td>
                                    <td style="background-color: whitesmoke">
                                        <div class="d-flex px-2 py-1">
                                            <p class="text-xs  mb-0">{{ $item->siswa->angkatan }}</p>
                                        </div>
                                    </td>
                                    <td style="background-color: whitesmoke">
                                        <div class="d-flex px-2 py-1">
                                            <p class="text-xs  mb-0">{{ $item->tanggal_tagihan->translatedFormat('l, d F Y') }}</p>
                                        </div>
                                    </td>
                                    <td style="background-color: whitesmoke">
                                        <div class="d-flex px-2 py-1">
                                            <p class="text-xs  mb-0">{{ $item->status }}</p>
                                        </div>
                                    </td>
                                    <td style="background-color: whitesmoke">
                                        <div class="d-flex px-2 py-1">
                                            <p class="text-xs  mb-0">{{ formatRupiah($item->tagihanDetails->sum('jumlah_biaya')) }}</p>
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
@endsection
