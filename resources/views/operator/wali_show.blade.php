    @extends('layouts.appbackend')

@section('tombol')
<div class="d-flex">
    <a href="{{ route($routePrefix . '.index') }}" class="btn btn-sm ml-3 btn-success"> Kembali </a>
</div>
@endsection

@section('content')
<div class="container-fluid py-4">
    <div class="row">
      <div class="col-6">
        <div class="card mb-4">
          <div class="card-header pb-0">
            <h6>{{ $title }} </h6>
            {{-- <a href="{{ route($routePrefix . '.create') }}" class="btn btn-sm  bg-gradient-primary  btn-round float-end">Tambah</a> --}}
          </div>
          <div class="card-body px-0 pt-0 pb-2">
            <div class="container-fluid py-4">
                <div class="table-responsive p-0">
                  <table class="table align-items-center mb-0">
                    <thead>
                        <tr>
                            <td width="15%">ID</td>
                            <td>:{{ $model->id }}</td>
                        </tr>
                        <tr>
                            <td width="15%">Nama</td>
                            <td>:{{ $model->name }}</td>
                        </tr>
                        <tr>
                            <td width="15%">Email</td>
                            <td>:{{ $model->email }}</td>
                        </tr>
                        <tr>
                            <td width="15%">Nomor HP</td>
                            <td>:{{ $model->nohp }}</td>
                        </tr>
                        <tr>
                            <td width="15%">Tanggal dibuat</td>
                            <td>:{{ $model->created_at->format('d/m/y H:i') }}</td>
                        </tr>
                        <tr>
                            <td width="15%">Tanggal diubah</td>
                            <td>:{{ $model->updated_at->format('d/m/y H:i') }}</td>
                        </tr>
                    </thead>
                  </table>
                </div>
            </div>
          </div>
        </div>
      </div>
      <div class="col-lg-6">
        <div class="card mb-4">
            <div class="card-header pb-0">
              <h6>Tambah Anak </h6>
              {!! Form::open(['route' => 'walisiswa.store','method' => 'POST']) !!}
              {!! Form::hidden('wali_id', $model->id, []) !!}
              <div class="input-group">
                  <label for="siswa_id">Pilih data siswa  :</label>
                  {!! Form::select('siswa_id', $siswa, null, ['class' => 'form-control select2']) !!}
                  <span class="text-danger">{{ $errors->first('siswa_id') }}</span>
              </div>
              {!! Form::submit('SIMPAN', ['class' => 'btn btn-primary btn-sm float-right my-2']) !!}
              {!! Form::close() !!}
            </div>
        </div>
        <a href="{{ route($routePrefix . '.index') }}" class="btn btn-primary btn-round float-end">Kembali</a>
      </div>
      <div class="card mb-4">
        <div class="card-header pb-0">
          <h6>Data Anak </h6>
          <div class="table-responsive p-0">
            <table class="table align-items-center mb-0">
                <thead>
                    <tr>
                       <th>No</th>
                       <th>NISN</th>
                       <th>Nama</th>
                       <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($model->siswa as $item)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $item->nisn }}</td>
                            <td>{{ $item->nama }}</td>
                            <td>
                                {!! Form::open([
                                    'route' => [ 'walisiswa.update', $item->id],
                                    'method' => 'PUT',
                                    'onsubmit' => 'return confirm("Yakin menghapus data ini?")',
                                ]) !!}

                                <button type="submit" class="btn btn-sm ml-3 btn-danger">
                                    <i class="fa fa-trash"></i> Hapus
                                </button>

                                {!! Form::close() !!}
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

<div class="container-fluid py-4">

</div>

<div class="container-fluid py-4">

</div>

@endsection
