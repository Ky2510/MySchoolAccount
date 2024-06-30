@extends('layouts.appbackend')

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
                            {{-- Nama --}}
                            <div class="form-group mt-3">
                                <label for="bank_id">Nama Bank</label>
                                {!! Form::select('bank_id', $listbank, null, ['class' => 'form-control select2']) !!}
                                <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                            </div>
                            {{-- Nama Rekening --}}
                            <div class="form-group mt-3">
                                <label for="nama_rekening">Nama Pemilik Rekening</label>
                                {!! Form::text('nama_rekening', null, ['class' => 'form-control', 'autofocus']) !!}
                                <span class="text-danger">{{ $errors->first('nama_rekening') }}</span>
                            </div>
                            {{-- Nomor Rekening --}}
                            <div class="form-group mt-3">
                                <label for="no_rekening">Nomor Rekening</label>
                                {!! Form::text('no_rekening', null, ['class' => 'form-control', 'autofocus']) !!}
                                <span class="text-danger">{{ $errors->first('no_rekening') }}</span>
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
