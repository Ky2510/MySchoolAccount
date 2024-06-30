@extends('layouts.appbackend')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6>Form Laporan</h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container">
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Laporan Tagihan</h4>
                                {!! Form::open(['route' => 'laporantagihan.index', 'method' => 'GET', 'target' => '_blank']) !!}
                                    <div class="row">
                                        <div class="col-md-2 col-sm-12">
                                            <label for="kelas">Kelas</label>
                                            {!! Form::select('kelas', getNamaKelas(), null, ['class' => 'form-control',  'placeholder' => 'Pilih Kelas']) !!}
                                            <span class="text-danger">{{ $errors->first('kelas') }}</span>
                                        </div>
                                        <div class="col-md-2 col-sm-12">
                                            <label for="angkatan">Angkatan</label>
                                            {!! Form::selectRange('angkatan', 2019, date('Y') + 1, null, ['class' => 'form-control', 'placeholder' => 'Pilih Angkatan']) !!}
                                            <span class="text-danger">{{ $errors->first('angkatan') }}</span>
                                        </div>
                                        <div class="col col-md-2 col-sm-12">
                                            <label for="status">Status Tagihan</label>
                                            {!! Form::select('status', [
                                                '' => 'pilih status',
                                                'lunas' => 'Lunas',
                                                'baru' => 'Baru',
                                                'angsur' => 'Angsur',
                                            ], request('status'), ['class' => 'form-control']) !!}
                                        </div>
                                        <div class="col col-md-2 col-sm-12">
                                            <label for="bulan">Bulan</label>
                                            {!! Form::selectMonth('bulan',request('bulan'), ['class' => 'form-control','placeholder' => 'Pilih bulan...']) !!}
                                        </div>
                                        <div class="col col-md-2 col-sm-12">
                                            <label for="tahun">Tahun</label>
                                            {!! Form::selectRange('tahun', 2023, date('Y') + 1,request('tahun'), ['class' => 'form-control']) !!}
                                        </div>
                                        <div class="col col-md-2 col-sm-12">
                                            <button class="btn btn-md  my-4 bg-gradient-info" type="submit">Tampil</button>
                                        </div>
                                    </div>
                                {!! Form::close() !!}
                            </div>
                        </div>
                        <hr>
                        <div class="row">
                            <div class="col-md-12">
                                <h4>Laporan Pembayaran</h4>
                                {!! Form::open(['route' =>  'laporanpembayaran.index', 'method' => 'GET', 'target' => '_blank']) !!}
                                <div class="row">
                                    <div class="col-md-2 col-sm-12">
                                        <label for="kelas">Kelas</label>
                                        {!! Form::select('kelas', getNamaKelas(), null, ['class' => 'form-control',  'placeholder' => 'Pilih Kelas']) !!}
                                        <span class="text-danger">{{ $errors->first('kelas') }}</span>
                                    </div>
                                    <div class="col-md-2 col-sm-12">
                                        <label for="angkatan">Angkatan</label>
                                        {!! Form::selectRange('angkatan', 2019, date('Y') + 1, null, ['class' => 'form-control', 'placeholder' => 'Pilih Angkatan']) !!}
                                        <span class="text-danger">{{ $errors->first('angkatan') }}</span>
                                    </div>
                                    <div class="col-md-3">
                                        <label for="status">Status Pembayaran</label>
                                        {!! Form::select('status', [
                                            '' => 'pilih status...',
                                            'sudah-konfirmasi' => 'Sudah Dikonfirmasi',
                                            'belum-konfirmasi' => 'Belum Dikonfirmasi',
                                        ], request('status'), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col">
                                        <label for="bulan">Bulan</label>
                                        {!! Form::selectMonth('bulan',request('bulan'), ['class' => 'form-control','placeholder' => 'Pilih bulan...']) !!}
                                    </div>
                                    <div class="col">
                                        <label for="tahun">Tahun</label>
                                        {!! Form::selectRange('tahun', 2023, date('Y') + 1,request('tahun'), ['class' => 'form-control']) !!}
                                    </div>
                                    <div class="col">
                                        <button class="btn btn-md  my-3 bg-gradient-info" type="submit">Tampil</button>
                                    </div>
                                </div>
                            {!! Form::close() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
