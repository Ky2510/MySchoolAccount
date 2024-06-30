@extends('layouts.layoutWali')

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
                        {!! Form::model($model, ['route' => $route,'method' => $method]) !!}
                            {{-- Name --}}
                            <div class="form-group mt-3">
                                <label for="name">Nama</label>
                                {!! Form::text('name', null, ['class' => 'form-control', 'autofocus']) !!}
                                <span class="text-danger">{{ $errors->first('name') }}</span>
                            </div>
                            {{-- Email --}}
                            <div class="form-group">
                                <label for="email">Email</label>
                                {!! Form::text('email', null, ['class' => 'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('email') }}</span>
                            </div>
                            {{-- No Handphone --}}
                            <div class="form-group">
                                <label for="nohp">No HP</label>
                                {!! Form::text('nohp', null, ['class' => 'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('nohp') }}</span>
                            </div>
                            {{-- Akses --}}
                            @if (\Route::is('user.create'))
                                <div class="form-group">
                                    <label for="akses">Hak Akses</label>
                                    {!! Form::select('akses',[
                                        'operator' => 'Operator Sekolah',
                                        'admin' => 'Administrator',
                                        'wali' => 'Wali Murid'
                                    ], null, ['class' => 'form-control']) !!}
                                    <span class="text-danger">{{ $errors->first('akses') }}</span>
                                </div>
                            @endif
                            {{-- Password --}}
                            <div class="form-group">
                                <label for="password">Password</label>
                                {!! Form::password('password', ['class' => 'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('password') }}</span>
                            </div>
                            {{-- Simpan --}}
                            {!! Form::submit($button, ['class' => 'btn btn-sm ml-3 btn-success float-end']) !!}
                            <a href="{{ route('user.index') }}" class="btn btn-sm btn-secondary float-end mx-2">Kembali</a>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
