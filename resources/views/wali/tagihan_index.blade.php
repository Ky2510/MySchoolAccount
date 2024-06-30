@extends('layouts.layoutWali')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6> Data Tagihan SPP </h6>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="table-responsive p-0">
              <table class="table align-items-center mb-0">
                <thead>
                  <tr>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">No</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Nama</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Jurusan</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Kelas</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Tanggal Tagihan</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Status Pembayaran</th>
                    <th class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">Aksi</th>
                    <th class="text-secondary opacity-7"></th>
                  </tr>
                </thead>
                <tbody>
                    @foreach($tagihan as $item)
                    <tr>
                        <td>
                        <div class="d-flex px-2 py-1">
                            <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                        </div>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $item->siswa->nama }}</p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $item->siswa->jurusan }}</p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $item->siswa->kelas }}</p>
                        </td>
                        <td>
                            <p class="text-xs font-weight-bold mb-0">{{ $item->tanggal_tagihan->translatedFormat('F  Y') }}</p>
                        </td>
                        <td>
                            @if ($item->pembayaran->count() >= 1)
                                <a href="{{ route('wali.pembayaran.show', $item->pembayaran->first()->id) }}" class="btn btn-sm {{ $item->pembayaran->first()->tanggal_konfirmasi == null ? 'btn-info ' : 'btn-success' }} btn-round">
                                    <p class="text-xs font-weight-bold mb-0">
                                        {{ $item->pembayaran->first()->tanggal_konfirmasi == null ? 'Belum dikonfirmasi' : 'Sudah dibayar' }}
                                    </p>
                                </a>
                             @else
                                <p class="text-xs font-weight-bold mb-0">{{ $item->getStatusTagihanWali() }}</p>
                            @endif
                        </td>
                        <td>
                            @if ($item->status == 'baru' || $item->status == 'angsur')
                                <a href="{{ route('wali.tagihan.show', $item->id) }}" class="btn btn-primary btn-sm btn-round">Lakukan Pembayaran</a>
                            @else
                                <a href="" class="btn btn-success btn-sm btn-round">Pembayaran Sudah Lunas</a>
                            @endif
                        </td>
                    </tr>
                    @endforeach
                </tbody>
              </table>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
