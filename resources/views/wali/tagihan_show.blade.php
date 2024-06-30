@extends('layouts.layoutWali')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6> Data Tagihan SPP {{ strtoupper($siswa->nama) }}</h6>
          </div>
            <div class="card-body px-0 pt-0 pb-2">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-4 col-sm-12">
                            <img src="{{ \Storage::url($siswa->foto)  }}" alt="{{ $siswa->nama }}" width="150" />
                            <div class="table-responsive p-0">
                                <table class="table  table-borderless align-items-center mb-0">
                                    <tr>
                                        <td width="50">NISN</td>
                                        <td>: {{ $siswa->nisn }}</td>
                                    </tr>
                                    <tr>
                                        <td> Nama</td>
                                        <td>: {{ $siswa->nama }}</td>
                                    </tr>
                                    <tr>
                                        <td> Jurusan</td>
                                        <td>: {{ $siswa->jurusan }}</td>
                                    </tr>
                                    <tr>
                                        <td> Angkatan</td>
                                        <td>: {{ $siswa->angkatan }}</td>
                                    </tr>
                                    <tr>
                                        <td> Kelas</td>
                                        <td>: {{ $siswa->kelas }}</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-8">
                            <p class="float-end">No. Tagihan : #SMKDS-{{ $tagihan->id }} <br>
                                                 Tgl. Tagihan : {{ $tagihan->tanggal_tagihan->translatedFormat('d F Y') }} <br>
                                                 Tgl. Jatuh Tempo : {{ $tagihan->tanggal_jatuh_tempo->translatedFormat('d F Y') }} <br>
                                                 Status Pembayaran : {{ $tagihan->getStatusTagihanWali() }} <br>
                            </p>
                            <p class="float-end"></p><br>
                            <table class="table table-bordered table-stripped  mb-0">
                                <thead class="thead-dark">
                                  <tr>
                                    <th width="1%" class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama </th>
                                    <th class="text-uppercase text-secondary text-end text-xxs font-weight-bolder opacity-7">Jumlah Tagihan</th>
                                  </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tagihan->tagihanDetails as $item)
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
                                            <div class="d-flex float-end px-2 py-1">
                                                <p class="text-xs font-weight-bold mb-0">{{ formatRupiah($item->jumlah_biaya) }}</p>
                                            </div>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">
                                            <div class="d-flex px-2 py-1">
                                                <p class="text-xs font-weight-bold mb-0">Total Pembayaran</p>
                                            </div>
                                        </td>
                                        <td>
                                            <div class="d-flex float-end px-2 py-1">
                                                <p class="text-xs font-weight-bold mb-0">
                                                    {{ formatRupiah($tagihan->tagihanDetails->sum('jumlah_biaya')) }}
                                                </p>

                                            </div>
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            <div class="d-flex float-end px-2 py-1">
                                <p class="text-xs font-weight-bold mb-0">
                                    <a href="{{ route('invoice.show', $tagihan->id)}}" target="_blank"><p>Cetak Invoice Tagihan</p>
                                    </a>
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="container-fluid py-4">
            <div class="alert alert-secondary mt-2 text-light" role="alert">
                Pembayaran bisa dilakukan dengan cara langsung keoperator atau ditransfer melalui rekening
                 milik sekolah dibawah ini. <br/>
                 <u><i>Jangan Melakukan transfer ke Rekening selain dari rekening dibawah ini.</i></u><br>
                Silahkan lihat tata cara melakukan pembayaran melalui <a href="">ATM</a> atau <a href=""> Internet Banking.</a> <br>
                 Setelah melakukan pembayaran, silahkan upload bukti pembayaran melalui tombol konfirmasi yang dibawah ini:
            </div>
            <ul>
                <li><a href="http://" class="text-gradient-secondary">Lihat Cara Pembayaran Melalui ATM</a></li>
                <li><a href="http://" class="text-gradient-secondary">Lihat Cara Pembayaran Melalui Internet Banking</a></li>
            </ul>
            <div class="row justify-content-center">
                @foreach ($bankSekolah as $itemBank)
                <div class="col-xl-4 col-sm-6 mb-xl-0 mb-4">
                    <div class="card">
                        <div class="card-body p-3">
                            <div class="row">
                                <div class="col-12">
                                    <div class="numbers">
                                    <p class="text-sm mb-0 text-capitalize font-weight-bold">Atas Nama</p>
                                    <h5 class="font-weight-bolder mb-0">
                                        {{ $itemBank->nama_rekening }} <br>
                                        <span class="text-secondary text-sm font-weight-bolder">{{ $itemBank->nama_bank }}</span><br>
                                        <span class="text-secondary text-sm font-weight-bolder">No Rek.  {{ $itemBank->no_rekening }}</span>
                                    </h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr>
                        <div class="container">
                            <a href="{{ route('wali.pembayaran.create', [
                                'tagihan_id' => $tagihan->id,
                                'bank_sekolah_id' => $itemBank->id
                            ]) }}" class="btn btn-sm bg-gradient-dark float-end">Konfirmasi Pembayaran</a>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
      </div>
    </div>
</div>
@endsection
