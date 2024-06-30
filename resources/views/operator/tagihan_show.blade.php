@extends('layouts.appbackend')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-5">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>{{ $title_tagihan }} {{ strtoupper($periode) }} </h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container-fluid py-4">
                        <div class="table-responsive p-0">
                            <table class="table align-items-center mb-0">
                                <tr>
                                    <td rowspan="8" width="100">
                                        <img src="{{ \Storage::url($siswa->foto)  }}" alt="{{ $siswa->nama }}" width="150" />
                                    </td>
                                </tr>
                                <tr>
                                    <td width="50">NISN</td>
                                    <td>: {{ $siswa->nisn }}</td>
                                </tr>
                                <tr>
                                    <td> Nama</td>
                                    <td>: {{ $siswa->nama }}</td>
                                </tr>
                                <tr>
                                    <td> Kelas</td>
                                    <td>: {{ $siswa->kelas }}</td>
                                </tr>
                                <tr>
                                    <td> Jurusan</td>
                                    <td>: {{ $siswa->jurusan }}</td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-xl-12 grid-margin">
                <div class="card">
                    <div class="card-body">
                        <h4 class="card-title"> {{ $title_tagihan }} {{ $periode }}</h4>
                        <div class="table-responsive">
                            <table class="table {{ config('app.table_style') }}">
                                <thead style="{{ config('app.thead_background') }}">
                                    <th>No</th>
                                    <th>Nama</th>
                                    <th>Jumlah Tagihan</th>
                                </thead>
                                <tbody>
                                    @foreach ($tagihan->tagihanDetails as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama_biaya }}</td>
                                            <td>{{ formatRupiah($item->jumlah_biaya) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td colspan="2">Total Pembayaran</td>
                                        <td>{{ formatRupiah($tagihan->tagihanDetails->sum('jumlah_biaya')) }}</td>
                                    </tr>
                                </tfoot>
                            </table>
                            <a href="{{ route('invoice.show', $tagihan->id) }}" target="_blank">Download Invoice</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="card my-4">
                <div class="card-header pb-0">
                    <h6>{{ $title_tagihan }} {{ strtoupper($periode) }} </h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container-fluid py-4">
                        <div class="table-responsive p-0">
                            <table class="table table-bordered table-stripped table-sm">
                                <thead>
                                    <tr>
                                        <th><center>#</center></th>
                                        <th><center>Tanggal</center></th>
                                        <th><center>Jumlah</center></th>
                                        <th><center>Metode</center></th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($tagihan->pembayaran as $item)
                                        <tr>
                                            <td>
                                                <center> <a href="{{ route('kwitansipembayaran.show', $item->id) }}" target="_blank"><i class="fa fa-print"></i></a></center>
                                            </td>
                                            <td><center>{{ $item->tanggal_bayar->translatedFormat('d/m/Y') }}</center></td>
                                            <td><center>{{ $item->jumlah_dibayar }}</center></td>
                                            <td><center>{{ $item->metode_pembayaran }}</center></td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                            <h5 class="my-4">Status Pembayaran : "{{ strtoupper($tagihan->status) }}"</h5>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-7">
            <div class="card">
                <div class="card-body">
                    <h5><div class="card-title">Kartu Tagihan</div></h5>
                    <div class="container">
                        <div class="table-responsive">
                            <table class="table {{ config('app.table_style') }}">
                                <thead style="{{ config('app.thead_background') }}">
                                    <tr>
                                        <th>No</th>
                                        <th>Bulan Tagihan</th>
                                        <th>Jumlah Tagihan</th>
                                        <th>Tanggal Bayar</th>
                                        <th>Paraf</th>
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
                                        </tr>
                                    @endforeach

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="my-1">
                    <center>
                        <a href="{{ route('kartuspp.index',[
                            'siswa_id' => $siswa->id,
                            'tahun' => request('tahun')
                        ]) }}" class="btn btn-sm btn-primary btn-round" target="_blank">Download PDF</a>
                    </center>
                </div>
            </div>
            <div class="card my-4">
                <div class="card-header pb-0">
                    <h6>{{ $title_tagihan }} {{ strtoupper($periode) }} </h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container-fluid py-4">
                        <h4 class="card-title mb-1"> {{ $title_pembayaran }}</h4>
                        {!! Form::model($model, ['route' => 'pembayaran.store', 'method' => 'POST']) !!}
                            {!! Form::hidden('tagihan_id', $tagihan->id, []) !!}
                            <div class="form-group">
                                <label for="tanggal_bayar">Tanggal Pembayaran</label>
                                {!! Form::date('tanggal_bayar', $model->tanggal_bayar ?? \Carbon\Carbon::now(), ['class' => 'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                            </div>
                            <div class="form-group">
                                <label for="jumlah_dibayar">Jumlah yang dibayarkan</label>
                                {!! Form::text('jumlah_dibayar', $tagihan->total_tagihan, ['class' => 'form-control rupiah']) !!}
                                <span class="text-danger">{{ $errors->first('jumlah_dibayar') }}</span>
                            </div>
                            {!! Form::submit('SIMPAN', ['class' => 'btn btn-primary btn-sm float-right']) !!}
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
