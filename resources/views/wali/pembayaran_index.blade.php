@extends('layouts.layoutWali')

@section('tombol')
<div class="d-flex">
    {!! Form::open(['route' => 'wali.pembayaran.index', 'method' => 'GET']) !!}
    <div class="row">
        <div class="col-md-6 col-sm-12 my-1">
            <div class="input-group">
                {!! Form::selectMonth('bulan', request('bulan'), ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col-md-6 col-sm-12 my-1">
            <div class="input-group">
                {!! Form::selectRange('tahun', 2022, date('Y') + 1, request('tahun'), ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="col my-1">
            <button class="btn btn-primary float-right" type="submit">Tampil</button>
        </div>
    </div>
    {!! Form::close() !!}
</div>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>Data Pembayaran </h6>
            <div class="row">
                <div class="col-lg-6">
                    {!! Form::open(['route' => 'wali.pembayaran.index', 'method' => 'GET']) !!}
                    <div class="row">
                        <div class="col">
                            {!! Form::selectMonth('bulan', request('bulan'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="col">
                            {!! Form::selectRange('tahun', 2023, date('Y') + 1,request('tahun'), ['class' => 'form-control']) !!}
                        </div>
                        <div class="col">
                            <button class="btn btn-md  bg-gradient-primary float-end" type="submit">Tampil</button>
                        </div>
                    </div>
                    {!! Form::close() !!}
                </div>
            </div>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="container">
                <div class="table-responsive p-0">
                    <table class="table align-items-center mb-0">
                      <thead>
                      <tr>
                          <th>No</th>
                          <th>NISN</th>
                          <th>Nama</th>
                          <th>Nama Wali</th>
                          <th>Status Konfirmasi</th>
                          <th>Metode Pembayaran</th>
                      </tr>
                      </thead>
                          <tbody>
                              @foreach($models as $item)
                              <tr>

                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->tagihan->siswa->nisn }}</td>
                                <td>{{ $item->tagihan->siswa->nama }}</td>
                                <td>{{ $item->wali->name }}</td>
                                <td>{{ $item->status_konfirmasi }}</td>
                                <td>{{ $item->metode_pembayaran }}</td>
                                <td>

                                    {!! Form::open([
                                        'route' => ['wali.pembayaran.destroy', $item->id],
                                        'method' => 'DELETE',
                                        'onsubmit' => 'return confirm("Yakin menghapus data ini?")',
                                    ]) !!}
                                    <a href="{{ route('wali.pembayaran.show', $item->id) }}" class="btn btn-sm ml-3 btn-info">
                                        Detail
                                    </a>
                                    @if ($item->tanggal_konfirmasi != null)
                                        <a href="" class="btn btn-sm btn-success">Tagihan ini sudah Lunas</a>
                                    @else
                                        <button type="submit" class="btn btn-sm btn-danger">
                                            Batalkan Pembayaran
                                        </button>
                                    @endif
                                    {!! Form::close() !!}
                                </td>
                              </tr>
                              @endforeach
                          </tbody>
                      </table>
                      {!! $models->links() !!}
                  </div>
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
