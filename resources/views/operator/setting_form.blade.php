@extends('layouts.appbackend', ['title' => 'Pengaturan'])

@section('content')
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-12">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6><center>Pengaturan</center></h6>
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="container">
                    {!! Form::open([
                            'route' => 'setting.store',
                            'method' => 'POST'
                        ])
                    !!}
                    <h6>Pengaturan Instansi</h6>
                    {{-- Nama Instansi --}}
                    <div class="form-group mt-3">
                        <label for="app_name">Nama Instansi</label>
                        {!! Form::text('app_name', settings()->get('app_name'), ['class' => 'form-control', 'autofocus']) !!}
                        <span class="text-danger">{{ $errors->first('app_name') }}</span>
                    </div>
                    {{-- Email Instansi --}}
                    <div class="form-group mt-3">
                        <label for="app_email">Email Instansi</label>
                        {!! Form::text('app_email', settings()->get('app_email'), ['class' => 'form-control', 'autofocus']) !!}
                        <span class="text-danger">{{ $errors->first('app_email') }}</span>
                    </div>
                    {{-- Nomor Telpon Instansi --}}
                    <div class="form-group mt-3">
                        <label for="app_phone">Nomor Telpon Instansi</label>
                        {!! Form::text('app_phone', settings()->get('app_phone'), ['class' => 'form-control', 'autofocus']) !!}
                        <span class="text-danger">{{ $errors->first('app_phone') }}</span>
                    </div>
                    {{-- Alamat Instansi --}}
                    <div class="form-group mt-3">
                        <label for="app_address">Alamat Instansi</label>
                        {!! Form::textarea('app_address',  settings()->get('app_address'), [
                            'class' => 'form-control',
                            'rows' => 3
                        ]) !!}
                        <span class="text-danger">{{ $errors->first('app_address') }}</span>
                    </div>
                    <h6>Pengaturan Aplikasi</h6>
                    {{-- Paginate --}}
                    <div class="form-group mt-3">
                        <label for="app_pagination">Data Perhalaman</label>
                        {!! Form::number('app_pagination', settings()->get('app_pagination'), ['class' => 'form-control', 'autofocus']) !!}
                        <span class="text-danger">{{ $errors->first('app_pagination') }}</span>
                    </div>
                    <hr>
                    {{-- Simpan --}}
                    {!! Form::submit('UPDATE', ['class' => 'btn btn-sm mx-3  btn-round btn-success float-end']) !!}
                    <a href="{{ route('operator.beranda') }}" class="btn btn-sm ml-3  btn-round btn-secondary float-end"> Kembali </a>

                {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
</div>
@endsection
