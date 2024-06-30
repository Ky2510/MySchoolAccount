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
                        {!! Form::model($model, ['route' => $route,'method' => $method, 'id' => 'form-ajax']) !!}
                            {{-- Tanggal Tagihan --}}
                            <div class="form-group mt-3">
                                <label for="tanggal_tagihan">Tanggal Tagihan</label>
                                <input type="date" name="tanggal_tagihan" class="form-control" id="tanggal_tagihan" value="{{  $model->tanggal_tagihan ?? date('Y-m-').'01' }}">
                                {{-- {!! Form::date('tanggal_tagihan', $model->tanggal_tagihan ?? date('Y-m-d'), ['class' => 'form-control rupiah', 'autofocus']) !!} --}}
                                <span class="text-danger">{{ $errors->first('tanggal_tagihan') }}</span>
                            </div>

                            {{-- Tanggal Jatuh Tempo --}}
                            <div class="form-group mt-3">
                                <label for="tanggal_jatuh_tempo">Tanggal Jatuh Tempo</label>
                                <input type="date" name="tanggal_jatuh_tempo" class="form-control" id="tanggal_jatuh_tempo" value="{{  $model->tanggal_jatuh_tempo ?? date('Y-m-').'10' }}">
                                {{-- {!! Form::date('tanggal_jatuh_tempo', $model->tanggal_jatuh_tempo ?? date('Y-m-d'), ['class' => 'form-control rupiah', 'autofocus']) !!} --}}
                                <span class="text-danger">{{ $errors->first('tanggal_jatuh_tempo') }}</span>
                            </div>

                            {{-- Keterangan --}}
                            <div class="form-group mt-3">
                                <label for="keterangan">keterangan</label>
                                {!! Form::textarea('keterangan', null, ['class' => 'form-control', 'rows' => '3', 'placeholder' => 'Masukan keterangan']) !!}
                                <span class="text-danger">{{ $errors->first('angkatan') }}</span>
                            </div>
                            <button  type="submit" class="btn btn-sm mx-3 bg-gradient-primary btn-round float-end">
                                {{ $button }}
                                <span id="loading-spinner" class="spinner-border spinner-border-sm" role="status"></span>
                            </button>
                            {{-- {!! Form::submit($button, ['class' => 'btn btn-sm  btn-success btn-round float-end']) !!} --}}
                            <a href="{{ route($routePrefix . '.index') }}" class="btn btn-sm mx-3 bg-gradient-secondary  btn-round float-end">Kembali</a>
                        {!! Form::close() !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('js')
<script>
    $(document).ready(function() {
        $("#loading-spinner").hide();
        $("#form-ajax").submit(function (e) {
            $.ajax({
                type: $(this).attr('method'),
                url:  $(this).attr('action'),
                data: $(this).serialize(),
                dataType: "json",
                beforeSend : function () {
                    $("#loading-spinner").show();
                    $("#overlay").removeClass('d-none');
                },
                success: function (response) {
                    $("#alert-message").removeClass('d-none');
                    $("#alert-message").addClass('alert-success');
                    $("#alert-message").html(response.message);
                    $("#overlay").addClass('d-none');
                    $("#loading-spinner").hide();
                },
                error: function(xhr, status, error){
                    $("#alert-message").removeClass('d-none');
                    $("#alert-message").addClass('alert-danger');
                    $("#alert-message").html(xhr.responseJSON.message);
                    $("#overlay").addClass('d-none');
                    $("#loading-spinner").hide();
                }
            });
            e.preventDefault();
            return;
        });
    });
</script>
@endsection
