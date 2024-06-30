@extends('layouts.appbackend')

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
                                        <input type="text" name="search" class="form-control" placeholder="Cari Nama Bank" value="{{ request('search') }}">
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
                        <div class="table-responsive p-0">
                            <table class="table {{ config('app.table_style') }} align-items-center mb-0">
                                <thead  style="{{ config('app.thead_background') }}">
                                    <tr>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Nama Bank</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Kode Transfer</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Pemilik Rekening</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Nomor Rekening</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">Aksi</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($models as $item)
                                    <tr>
                                    <td>{{ $loop->iteration }}</td>
                                    <td>{{ $item->nama_bank }}</td>
                                    <td>{{ $item->kode }}</td>
                                    <td>{{ $item->nama_rekening }}</td>
                                    <td>{{ $item->no_rekening }}</td>
                                    <td>
                                        {!! Form::open([
                                            'route' => [$routePrefix .'.destroy', $item->id],
                                            'method' => 'DELETE',
                                            'onsubmit' => 'return confirm("Yakin menghapus data ini?")',
                                        ]) !!}


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
                </div>
            </div>
            <div class="float-end">
                {!! $models->links() !!}
            </div>
        </div>
    </div>
</div>
@endsection
