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
                {{-- Wali Murid --}}
                    <div class="form-group mt-3">
                        <label for="wali_id">Wali Murid (Optional)</label>
                        {!! Form::select('wali_id', $wali, null, ['class' => 'select2 form-control', 'placeholder' => 'Pilih Wali Murid']) !!}
                        <span class="text-danger">{{ $errors->first('wali_id') }}</span>
                    </div>
                    {{-- Nama --}}
                    <div class="form-group mt-3">
                        <label for="nama">Nama</label>
                        {!! Form::text('nama', null, ['class' => 'form-control', 'autofocus']) !!}
                        <span class="text-danger">{{ $errors->first('nama') }}</span>
                    </div>
                    {{-- Biaya --}}
                    <div class="form-group mt-3">
                        <label for="biaya_id">Biaya Tagihan</label>
                        {!! Form::select('biaya_id', $listBiaya, null, ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('biaya_id') }}</span>
                    </div>
                    {{-- NISN --}}
                    <div class="form-group">
                        <label for="nisn">NISN</label>
                        {!! Form::text('nisn', null, ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('nisn') }}</span>
                    </div>
                    {{-- Jurusan --}}
                    <div class="form-group mt-3">
                        <label for="jurusan">Jurusan</label>
                        {!! Form::select('jurusan', getNamaJurusan(), null, ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('jurusan') }}</span>
                    </div>
                    {{-- Kelas --}}
                    <div class="form-group mt-3">
                        <label for="kelas">Kelas</label>
                        {{-- {!! Form::selectRange('kelas',1,3, null, ['class' => 'form-control']) !!} --}}
                        {!! Form::select('kelas', getNamaKelas(), null, ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('kelas') }}</span>
                    </div>
                    {{-- Angkatan --}}
                    <div class="form-group mt-3">
                        <label for="angkatan">Angkatan</label>
                        {!! Form::selectRange('angkatan', 2019, date('Y') + 1, null, ['class' => 'form-control']) !!}
                        <span class="text-danger">{{ $errors->first('angkatan') }}</span>
                    </div>
                    {{-- Foto --}}
                    @if($model->foto != null)
                        <div class="m-3">
                            <img src="{{ \Storage::url($model->foto) }}" alt="" width="200" class="img-thumbnail">
                        </div>
                    @endif
                    <div class="form-group mt-3">
                        <label for="foto">Foto <b>(Format: jpg, jpeg, png, Ukuran Maks: 5MB)</b></label>
                        {!! Form::file('foto', ['class' => 'form-control', 'accept' => 'image/*']) !!}
                        <span class="text-danger">{{ $errors->first('foto') }}</span>
                    </div>
                {{-- Simpan --}}
                {!! Form::submit($button, ['class' => 'btn btn-sm mx-3 btn-warning  btn-round float-end']) !!}
            <a href="{{ route($routePrefix . '.index') }}" class="btn btn-sm  bg-gradient-primary  btn-round float-end">Kembali</a>

                {!! Form::close() !!}
            </div>
          </div>
        </div>
      </div>
    </div>
</div>

@endsection
