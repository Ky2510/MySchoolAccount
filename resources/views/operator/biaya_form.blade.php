@extends('layouts.appbackend')

@section('tombol')
<div class="d-flex">
    <a href="{{ route($routePrefix . '.index') }}" class="btn btn-sm ml-3 btn-success"> Kembali </a>
</div>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>{{ $title }} </h6>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="container">
                {!! Form::model($model, ['route' => $route,'method' => $method, 'files' => true]) !!}
                    @if (request()->filled('parent_id'))
                        <h3>Info {{ $parentData->nama }}</h3>
                        {!! Form::hidden('parent_id', $parentData->id, []) !!}
                        <div class="row">
                            <div class="col-lg-7">
                                <table class="table">
                                    <thead>
                                        <tr class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                            <th width="4%">Parent ID</th>
                                            <th>Nama Biaya</th>
                                            <th>Jumlah</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($parentData->children as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->nama }}</td>
                                            <td>{{ formatRupiah($item->jumlah) }}</td>
                                            <td>
                                                <a href="{{ route('delete-biaya.item', $item->id) }}" class="btn btn-sm btn-danger" onclick="return confirm('Anda Yakin?')">
                                                    Hapus
                                                </a>
                                            </td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    @endif
                    {{-- Nama --}}
                    <div class="form-group mt-3">
                        <label for="nama">Nama Biaya</label>
                        {!! Form::text('nama', null, ['class' => 'form-control', 'autofocus']) !!}
                        <span class="text-danger">{{ $errors->first('nama') }}</span>
                    </div>
                    {{-- Jumlah --}}
                    <div class="form-group mt-3">
                        <label for="jumlah">Jumlah / Nominal</label>
                        {!! Form::text('jumlah', null, ['class' => 'form-control rupiah', 'autofocus']) !!}
                        <span class="text-danger">{{ $errors->first('jumlah') }}</span>
                    </div>
                    {{-- Simpan --}}
                    {!! Form::submit($button, ['class' => 'btn btn-sm mx-3  btn-round btn-success float-end']) !!}
                    <a href="{{ route($routePrefix . '.index') }}" class="btn btn-sm  bg-gradient-primary  btn-round float-end">Kembali</a>

                {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
