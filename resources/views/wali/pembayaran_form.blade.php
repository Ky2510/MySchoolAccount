@extends('layouts.layoutWali')

@section('js')
<script>
    $(function () {
        $("#checkboxToggle").click(function () {
            if ($(this).is(":checked")) {
                $("#pilihan_bank").fadeOut();
                $("#form_bank_pengirim").fadeIn();
            } else {
                $("#pilihan_bank").fadeIn();
                $("#form_bank_pengirim").fadeOut();
            }
        });
    });
    $(document).ready(function(){
        @if (count($listWaliBank) >= 1)
            // Sudah pernah bayar
            $("#form_bank_pengirim").hide();
        @else
            // Pertama kali bayar
            $("#form_bank_pengirim").show();
        @endif
        $("#pilih_bank").change(function(e){
            var bankId = $(this).find(":selected").val();
            window.location.href = "{!! $url !!}&bank_sekolah_id=" + bankId;
        });
    });

</script>
@endsection

@section('content')
<div class="container-fluid py-4">
    {!! Form::model($model, ['route' => $route, 'method' => $method, 'files' => true]) !!}
    {!! Form::hidden('tagihan_id', request('tagihan_id'),[]) !!}
    <div class="row">
        <h6> <center>Konfirmasi Pembayaran</center> </h6>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="container-fluid">
                            <h6>INFORMASI BANK TUJUAN</h6>
                            {{-- Bank Tujuan --}}
                            <div class="form-group mt-3">
                                <label for="bank_sekolah_id"> Bank Tujuan Pembayaran</label>
                                {!! Form::select('bank_sekolah_id', $listBankSekolah, request('bank_sekolah_id'), [
                                        'class' => 'form-control',
                                        'placeholder' => 'pilih bank tujuan transfer',
                                        'id' => 'pilih_bank',
                                    ])
                                !!}
                                <span class="text-danger">{{ $errors->first('bank_sekolah_id') }}</span>
                            </div>
                            @if (request('bank_sekolah_id') != '')
                                <div class="row">
                                    <div class="col-12">
                                        <div class="numbers">
                                        <p class="text-sm mb-0 text-capitalize font-weight-bold">Atas Nama</p>
                                        <h5 class="font-weight-bolder mb-0">
                                            {{ $bankYangDipilih->nama_rekening }} <br>
                                            <span class="text-secondary text-sm font-weight-bolder">{{ $bankYangDipilih->nama_bank }}</span><br>
                                            <span class="text-secondary text-sm font-weight-bolder">No Rek.  {{ $bankYangDipilih->no_rekening }}</span>
                                        </h5>
                                        </div>
                                    </div>
                                </div>
                            @endif
                            {{-- Tanggal Bayar --}}
                            <div class="form-group mt-3">
                                <label for="tanggal_bayar">Tanggal Bayar</label>
                                {!! Form::date('tanggal_bayar', $model->tanggal_bayar ?? date('Y-m-d'), ['class' => 'form-control', 'autofocus']) !!}
                                <span class="text-danger">{{ $errors->first('tanggal_bayar') }}</span>
                            </div>
                            {{-- Jumlah dibayar --}}
                            <div class="form-group mt-3">
                                <label for="jumlah_dibayar">Jumlah yang dibayarkan</label>
                                {!! Form::text('jumlah_dibayar', $tagihan->tagihanDetails->sum('jumlah_biaya'), ['class' => 'form-control rupiah']) !!}
                                <span class="text-danger">{{ $errors->first('jumlah_dibayar') }}</span>
                            </div>
                            {{-- Bukti bayar --}}
                            <div class="form-group mt-3">
                                <label for="bukti_bayar">
                                    Bukti Pembayaran <br>
                                    <span class="text-danger"> (File harus jpg, jpeg, png. Ukuran file maksimal 5MB)</span>
                                </label>
                                {!! Form::file('bukti_bayar', ['class' => 'form-control']) !!}
                                <span class="text-danger">{{ $errors->first('bukti_bayar') }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <div class="card-body px-0 pt-0 pb-2">
                        <div class="container-fluid">
                            <h6>INFORMASI REKENING PENGIRIM</h6>
                            @if (count($listWaliBank) >= 1)
                            {{-- Bank Pengirim --}}
                            <div class="form-group mt-3" id="pilihan_bank">
                                <label for="wali_bank_id"> Pilih Bank Pengirim</label>
                                {!! Form::select('wali_bank_id', $listWaliBank, null, ['class' => 'form-control select2', 'placeholder' => 'Pilih Nomor Rek.Pengirim']) !!}
                                <span class="text-danger">{{ $errors->first('wali_bank_id') }}</span>
                            </div>
                            {{-- Rekening Baru --}}
                            <div class="form-check form-switch ps-0">
                                {!! Form::checkbox('pilihan_bank', 1, false, ['class' => 'form-check-input ms-auto', 'id' => 'checkboxToggle']) !!}
                                <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="checkboxToggle">
                                    Saya punya rekening baru
                                </label>
                            </div>
                            @endif
                            <div class="informasi pengirim" id="form_bank_pengirim">
                                <div class="alert alert-secondary" role="alert">
                                    <p class="text-sm text-light">
                                        Informasi yang dibutuhkan agar operator dapat memverifikasi pembayaran
                                        yang dilakukan oleh wali murid melalui bank.
                                    </p>
                                </div>
                                {{-- Bank Pengirim --}}
                                <div class="form-group mt-3">
                                    <label for="bank_id"> Nama Bank Pengirim</label>
                                    {!! Form::select('bank_id', $listBank, null, ['class' => 'form-control select2']) !!}
                                    <span class="text-danger">{{ $errors->first('bank_id') }}</span>
                                </div>
                                {{-- Pemilik Rekening --}}
                                <div class="form-group mt-3">
                                    <label for="nama_rekening"> Nama Pemilik Rekening</label>
                                    {!! Form::text('nama_rekening', null, ['class' => 'form-control']) !!}
                                    <span class="text-danger">{{ $errors->first('nama_rekening') }}</span>
                                </div>
                                {{-- Nomor Rekening Bank Pengirim--}}
                                <div class="form-group mt-3">
                                    <label for="no_rekening"> Nomor Rekening Bank Pengirim</label>
                                    {!! Form::text('no_rekening', null, ['class' => 'form-control']) !!}
                                    <span class="text-danger">{{ $errors->first('no_rekening') }}</span>
                                </div>
                                  {{-- Rekening Baru --}}
                                <div class="form-check form-switch ps-0">
                                    {!! Form::checkbox('simpan_data_rekening', 1, true, ['class' => 'form-check-input ms-auto', 'id' => 'defaultCheck3']) !!}
                                    <label class="form-check-label text-body ms-3 text-truncate w-80 mb-0" for="defaultCheck3">
                                        Simpan data untuk memudahkan pembayaran
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            {!! Form::submit('simpan', ['class' => 'btn btn-primary float-end']) !!}
            {!! Form::close() !!}
        </div>
    </div>
</div>
@endsection
