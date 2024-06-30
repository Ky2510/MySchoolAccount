@extends('layouts.appbackend')

@section('tombol')
<div class="d-flex">
    <a href="{{ route($routePrefix . '.create') }}" class="btn btn-sm ml-3 mr-2 btn-success"> Tambah Data </a>
    {!! Form::open(['route' => $routePrefix . '.index', 'method' => 'GET']) !!}
        <div class="input-group">
            <input type="text" name="search" value="{{ Request('search') }}" class="form-control" placeholder="Cari nama siswa.." aria-label="Cari data biaya" aria-describedby="basic-addon2" />
            <div class="input-group-append">
                <button class="btn btn-sm btn-primary" type="submit"> Cari </button>
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
                    <h6>{{ $title }} </h6>
                    <div class="row">
                        <div class="col-md-7">
                            {!! Form::open(['route' => $routePrefix. '.index', 'method' => 'GET' ]) !!}
                                <div class="d-flex">
                                    <div class="input-group">
                                        <input type="text" name="search" class="form-control" placeholder="Cari Nama Biaya" value="{{ request('search') }}">
                                        <button type="submit" class="input-group-text text-body"><i class="fas fa-search" aria-hidden="true"></i></button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                        </div>
                    </div>
                    <a href="{{ route($routePrefix . '.create') }}" class="btn btn-sm  bg-gradient-primary  btn-round float-end">Tambah</a>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container">
                        <table class="table {{ config('app.table_style') }}">
                            <thead style="{{ config('app.thead_background') }}">
                                <tr>
                                    <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">No</th>
                                    <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Nama Biaya</th>
                                    <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Total Tagihan</th>
                                    <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Dibuat oleh</th>
                                    <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($models as $item)
                                <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama }}</td>
                                    <td>{{ formatRupiah($item->total_tagihan) }}</td>
                                    <td>{{ $item->user->name }}</td>
                                    <td>
                                        {!! Form::open([
                                            'route' => [$routePrefix .'.destroy', $item->id],
                                            'method' => 'DELETE',
                                            'onsubmit' => 'return confirm("Yakin menghapus data ini?")',
                                        ]) !!}
                                        <a href="{{ route($routePrefix .'.create', ['parent_id' => $item->id]) }}" class="btn btn-sm mr-2 btn-info">
                                            Items
                                        </a>
                                    
                                        <a href="{{ route($routePrefix .'.edit', $item->id) }}" class="btn btn-sm mr-2 btn-warning">
                                            Edit
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
                <div class="float-end">
                    {!! $models->links() !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
