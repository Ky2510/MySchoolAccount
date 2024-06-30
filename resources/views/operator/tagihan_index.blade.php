@extends('layouts.appbackend')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>{{ $title }} </h6>
                    <div class="row">
                        <div class="col-lg-8">
                            {!! Form::open(['route' => $routePrefix . '.index', 'method' => 'GET']) !!}
                                <div class="row">
                                    <div class="col-md-3">
                                        {!! Form::text('search', request('search'), ['class' => 'form-control', 'placeholder' => 'Pencarian tagihan']) !!}
                                    </div>
                                    <div class="col">
                                        {!! Form::select('status', [
                                            '' => 'pilih status',
                                            'lunas' => 'Lunas',
                                            'baru' => 'Baru',
                                            'angsur' => 'Angsur',
                                        ], request('status'), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col">
                                        {!! Form::selectMonth('bulan',request('bulan'), ['class' => 'form-control','placeholder' => 'Pilih bulan...']) !!}
                                    </div>
                                    <div class="col">
                                        {!! Form::selectRange('tahun', 2023, date('Y') + 1,request('tahun'), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-md  bg-gradient-info" type="submit">Tampil</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                        <div class="col-lg-4">
                            <a href="{{ route($routePrefix . '.create') }}" class="btn btn-sm mx-2 my-2  bg-gradient-primary  btn-round float-end">Tambah</a>
                        </div>
                    </div>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container">
                        <div class="table-responsive p-0">
                            <table class="table {{ config('app.table_style') }}">
                                <thead style="{{ config('app.thead_background') }}">
                                <tr>
                                    <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">NISN</th>
                                    <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Nama</th>
                                    <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Hari Tanggal Tagihan</th>
                                    <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Status</th>
                                    <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Total Tagihan</th>
                                    <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                                </thead>
                                <tbody>
                                    @forelse ($models as $item)
                                    <tr>
                                        <td>{{ $loop->iteration }}</td>
                                        <td>{{ $item->siswa->nisn }}</td>
                                        <td>{{ $item->siswa->nama }}</td>
                                        <td>{{ $item->tanggal_tagihan->translatedFormat('l, d F Y') }}</td>
                                        <td>{{ $item->status }}</td>
                                        <td>{{ formatRupiah($item->tagihanDetails->sum('jumlah_biaya')) }}</td>
                                        <td>
                                            {!! Form::open([
                                                'route' => [$routePrefix .'.destroy', $item->id],
                                                'method' => 'DELETE',
                                                'onsubmit' => 'return confirm("Yakin menghapus data ini?")',
                                            ]) !!}


                                            <a href="{{ route($routePrefix .'.show', [
                                                        $item->id,
                                                        'siswa_id' => $item->siswa_id,
                                                        'bulan' =>  $item->tanggal_tagihan->format('m'),
                                                        'tahun' => $item->tanggal_tagihan->format('Y'),
                                                        ])
                                                    }}" class="btn btn-sm ml-3 btn-info">
                                                Detail
                                            </a>
                                            {{--
                                                <a href="{{ route($routePrefix .'.edit', $item->id) }}" class="btn btn-sm mr-2 btn-warning">
                                                    <i class="fa fa-edit"></i> Edit
                                                </a> --}}

                                            <button type="submit" class="btn btn-sm btn-danger">
                                                Hapus
                                            </button>

                                            {!! Form::close() !!}
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
            <div class="float-end">
                {!! $models->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection
