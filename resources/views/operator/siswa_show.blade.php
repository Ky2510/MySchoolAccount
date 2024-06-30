@extends('layouts.appbackend')

@section('tombol')
<div class="d-flex">
    <a href="{{ route($routePrefix . '.index') }}" class="btn btn-sm ml-3 btn-success"> Kembali </a>
</div>
@endsection

@section('content')
<h4 class="card-title">{{ $title }}</h4>
<p class="card-description"> Add class <code>.table-striped</code>
</p>
<div class="card-body">
    <img src="{{ \Storage::url($model->foto ) }}" width="150">
    <div class="table-responsive">
        <table class="table table-striped table-sm">
            <thead>
                <tr>
                    <td width="15%">Status Siswa</td>
                    <td>:
                        <span class="badge {{ $model->status == 'aktif' ? 'bg-primary' : 'bg-danger'}}">
                            {{ $model->status }}
                        </span>
                    </td>
                </tr>
                <tr>
                    <td width="15%">Nama</td>
                    <td>:{{ $model->nama }}</td>
                </tr>
                <tr>
                    <td width="15%">NISN</td>
                    <td>:{{ $model->nisn }}</td>
                </tr>
                <tr>
                    <td width="15%">Jurusan</td>
                    <td>:{{ $model->jurusan }}</td>
                </tr>
                <tr>
                    <td width="15%">Kelas</td>
                    <td>:{{ $model->kelas }}</td>
                </tr>
                <tr>
                    <td width="15%">Angkatan</td>
                    <td>:{{ $model->angkatan }}</td>
                </tr>
                <tr>
                    <td width="15%">Created At</td>
                    <td>:{{ $model->created_at }}</td>
                </tr>
                <tr>
                    <td width="15%">Last Update</td>
                    <td>:{{ $model->updated_at }}</td>
                </tr>
                <tr>
                    <td width="15%">Ubdate By</td>
                    <td>:{{ $model->user->name }}</td>
                </tr>
            </thead>
        </table>
        <h4>Biaya Tagihan</h4>
        <div class="row">
            <div class="col-md-5">
                <table class="table table-bordered table-sm">
                    <thead>
                        <tr>
                            <th>No</th>
                            <th>Item Tagihan</th>
                            <th>Jumlah Tagihan</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($model->biaya->children as $item)
                            <tr>
                                <td>{{ $loop->iteration }}</td>
                                <td>{{ $item->nama }}</td>
                                <td class="text-end">{{ formatRupiah($item->jumlah) }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                    <tfoot>
                        <td colspan="2">Total Biaya Tagihan</td>
                        <td class="text-end fw-bold">{{ formatRupiah( $model->biaya->children->sum('jumlah') ) }}</td>
                    </tfoot>
                </table>
            </div>
        </div>
        <a href="{{ route('status.update', [
                'model' => 'siswa',
                'id' => $model->id,
                'status' => $model->status == 'aktif' ? 'non-aktif' : 'aktif',
            ]) }}" class="btn btn-sm my-2 {{ $model->status == 'aktif' ? 'btn-danger' : 'btn-primary' }}" onclick="return confirm('Anda Yakin?')">
                {{ $model->status == 'aktif' ? 'Non-Aktifkan Siswa Ini' : 'Aktifkan Siswa Ini' }}
        </a>
    </div>
</div>
@endsection
