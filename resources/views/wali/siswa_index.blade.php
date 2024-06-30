@extends('layouts.layoutWali')

@section('content')
<div class="container-fluid py-4">
    <div class="row">
        <div class="col-12">
            <div class="card mb-4">
                <div class="card-header pb-0">
                    <h6> Data Siswa </h6>
                </div>
                <div class="card-body px-0 pt-0 pb-2">
                    <div class="container">
                        <div class="table-responsive p-0">
                            <table class="table {{ config('app.table_style') }}">
                                <thead style="{{ config('app.thead_background') }}">
                                    <tr>
                                        <th width="1%" class="text-uppercase {{ config('app.thead_text') }} text-xxs font-weight-bolder opacity-7">No</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs text-center font-weight-bolder opacity-7">Nama</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs text-center font-weight-bolder opacity-7">Jurusan</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs text-center font-weight-bolder opacity-7">Kelas</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs text-center font-weight-bolder opacity-7">Angkatan</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs text-center font-weight-bolder opacity-7">Kartu Tagihan</th>
                                        <th class="text-uppercase {{ config('app.thead_text') }} text-xxs text-center font-weight-bolder opacity-7">Biaya Sekolah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($models as $item)
                                    <tr>
                                        <td>
                                            <div class="d-flex px-2 py-1">
                                                <p class="text-xs font-weight-bold mb-0">{{ $loop->iteration }}</p>
                                            </div>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->nama }} ({{ $item->nisn }})</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->jurusan }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs font-weight-bold mb-0">{{ $item->kelas }}</p>
                                        </td>
                                        <td>
                                            <p class="text-xs text-center font-weight-bold mb-0">{{ $item->angkatan }}</p>
                                        </td>
                                        <td>
                                            <a href="{{ route('kartuspp.index', [
                                                        'siswa_id' => $item->id,
                                                        'tahun' => date('Y')
                                                    ])
                                                }}" target="_blank">Download
                                            </a>
                                        </td>
                                        <td>
                                            <a href="{{ route('wali.siswa.show', $item->id) }}">
                                                <p class="text-xs text-end font-weight-bold mb-0">{{ formatRupiah($item->biaya->total_tagihan) }}
                                                    <i class="fa fa-arrow-alt-circle-right"></i>
                                                </p>
                                            </a>
                                        </td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
