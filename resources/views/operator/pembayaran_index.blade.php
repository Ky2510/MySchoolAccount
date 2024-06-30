@extends('layouts.appbackend')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Data Pembayaran </h6>
                    {!! Form::open(['route' =>  'pembayaran.index', 'method' => 'GET']) !!}
                        <div class="row float-end">
                            <div class="col-md-3">
                                {!! Form::text('search', request('search'), ['class' => 'form-control', 'placeholder' => 'Pencarian tagihan...']) !!}
                            </div>
                            <div class="col-md-3">
                                {!! Form::select('status', [
                                    '' => 'pilih status...',
                                    'sudah-konfirmasi' => 'Sudah Dikonfirmasi',
                                    'belum-konfirmasi' => 'Belum Dikonfirmasi',
                                ], request('status'), ['class' => 'form-control']) !!}
                            </div>
                            <div class="col">
                                {!! Form::selectMonth('bulan',request('bulan'), ['class' => 'form-control','placeholder' => 'Pilih bulan...']) !!}
                            </div>
                            <div class="col">
                                {!! Form::selectRange('tahun', 2023, date('Y') + 1,request('tahun'), ['class' => 'form-control']) !!}
                            </div>
                            <div class="col">
                                <button class="btn btn-md  bg-gradient-primary" type="submit">Tampil</button>
                            </div>
                        </div>
                    {!! Form::close() !!}
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container">
                        <div class="table-responsive p-0">
                            <table class="table {{ config('app.table_style') }}">
                                <thead style="{{ config('app.thead_background') }}">
                                    <tr>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7"><center>No </center></th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7"><center>NISN</center></th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7"><center>Nama</center></th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7"><center>Nama Wali</center></th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7"><center>Status Konfirmasi</center></th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7"><center>Metode Pembayaran</center></th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7"><center>Tanggal Konfirmasi</center></th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7"><center>Aksi</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($models as $item)
                                    <tr>
                                        <td> <center>{{ $loop->iteration }}</center></td>
                                        <td> <center>{{ $item->tagihan->siswa->nisn }}</center></td>
                                        <td> <center>{{ $item->tagihan->siswa->nama }}</center></td>
                                        <td> <center>{{ $item->wali->name }}</center></td>
                                        <td> <center>{{ $item->status_konfirmasi }}</center></td>
                                        <td> <center>{{ $item->metode_pembayaran }}</center></td>
                                        <td> <center>{{ $item->tanggal_konfirmasi }}</center></td>
                                        <td>
                                            {!! Form::open([
                                                'route' => ['pembayaran.destroy', $item->id],
                                                'method' => 'DELETE',
                                                'onsubmit' => 'return confirm("Yakin menghapus data ini?")',
                                            ]) !!}


                                            <a href="{{ route('pembayaran.show', $item->id) }}" class="btn btn-sm ml-3 btn-info">
                                                Detail
                                            </a>

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Hapus
                                            </button>

                                            {!! Form::close() !!}
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="float-end">
                {!! $models->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection
