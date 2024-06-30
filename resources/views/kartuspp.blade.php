@extends('layouts.appbackendblank')

@section('content')
<div class="container mt-5">
    <div class="d-flex justify-content-center row">
        <div class="col-md-8">
            <div class="p-3 bg-white rounded">
                <div class="row">
                    <div class="col-md-12">
                        <h1 class="text-uppercase">KARTU SPP</h1>
                        <div class="billed"><span class="font-weight-bold">Nama Sekolah:</span><span class="ml-1">SMK Dimana Saja</span></div>
                        <div class="billed"><span class="font-weight-bold">Nama Siswa:</span><span class="ml-1">{{ $siswa->nama }}</span></div>
                        <div class="billed"><span class="font-weight-bold">Kelas:</span><span class="ml-1">{{ $siswa->kelas }}</span></div>
                        <div class="billed"><span class="font-weight-bold">Jurusan:</span><span class="ml-1">{{ $siswa->jurusan }}</span></div>
                        <div class="billed"><span class="font-weight-bold">Angkatan:</span><span class="ml-1">{{ $siswa->angkatan }}</span></div>
                        <div class="mt-3">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead style="background-color: grey;">
                                        <tr>
                                            <th>No</th>
                                            <th>Bulan Tagihan</th>
                                            <th>Jumlah Tagihan</th>
                                            <th>Tanggal Bayar</th>
                                            <th>Paraf</th>
                                            <th>Keterangan</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($kartuTagihan as $item)
                                            <tr>
                                                <td>{{ $loop->iteration }}</td>
                                                <td>{{ $item['bulan']. ' ' . $item['tahun'] }}</td>
                                                <td>{{ formatRupiah($item['total_tagihan']) }}</td>
                                                <td>{{ $item['tanggal_bayar'] }}</td>
                                                <td>&nbsp;</td>
                                                <td>&nbsp;</td>
                                            </tr>
                                        @endforeach

                                    </tbody>
                                </table>
                                <div class="my-5">
                                    <table width="100%">
                                        <tr>
                                            <td colspan="1">
                                                Los Santos, {{ now()->translatedFormat('d F Y') }} <br>
                                                Mengetahui, <br>
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <br>
                                                Bendahara
                                            </td>
                                        </tr>
                                    </table>
                                </div>
                                <center>
                                    <a href="{{ url()->full() . '&output=pdf' }}">Download PDF</a> |
                                    <a href="#" onclick="window.print()">Cetak</a>
                                </center>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
