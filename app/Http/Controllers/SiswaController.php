<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Biaya;
use Illuminate\Http\Request;
use App\Models\Siswa as Model;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\StoreSiswaRequest;
use App\Http\Requests\UpdateSiswaRequest;

class SiswaController extends Controller
{
    private $viewIndex = 'siswa_index';
    private $viewForm = 'siswa_form';
    private $viewEdit = 'siswa_form';
    private $viewShow = 'siswa_show';
    private $routePrefix = 'siswa';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $models = Model::with('wali', 'user')->latest();

        if ($request->filled('search')) {
            $models = $models->search($request->search);
        }

        return view('operator.' . $this->viewIndex, [
            'models' => $models->paginate(settings()->get('app_pagination', '50')),
            'routePrefix' => $this->routePrefix,
            'title' => 'Siswa'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'listBiaya' => Biaya::has('children')->whereNull('parent_id')->pluck('nama', 'id'),
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'routePrefix' => $this->routePrefix,
            'button' => 'SIMPAN',
            'title' => 'Form Siswa',
            'wali' => User::where('akses', 'wali')->pluck('name', 'id'),
        ];
        return view('operator.' . $this->viewForm, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreSiswaRequest $request)
    {
        $requestData = $request->validated();

        if ($request->hasFile('foto')) {
            $requestData['foto'] = $request->file('foto')->store('public');
        }

        if ($request->filled('wali_id')) {
            $requestData['wali_status'] = 'OK';
        }

        Model::create($requestData);
        flash()->addSuccess('Data berhasil disimpan');
        return redirect()->route('siswa.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return view('operator.' . $this->viewShow, [
            'model' => Model::findOrFail($id),
            'title' => 'Detail Siswa',
            'routePrefix' => $this->routePrefix ,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = [
            'listBiaya' => Biaya::has('children')->whereNull('parent_id')->pluck('nama', 'id'),
            'model' => Model::findOrFail($id),
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'UPDATE',
            'routePrefix' => $this->routePrefix,
            'title' => 'Form Siswa',
            'wali' => User::where('akses', 'wali')->pluck('name', 'id'),
        ];
        return view('operator.' . $this->viewEdit, $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateSiswaRequest $request, $id)
    {
        $requestData = $request->validated();
        $model = Model::findOrFail($id);

        if ($request->hasFile('foto')) {
            if ($model->foto != null && Storage::exists($model->foto)) {
                Storage::delete($model->foto);
            }

            $requestData['foto'] = $request->file('foto')->store('public');
        }

        if ($request->filled('wali_id')) {
            $requestData['wali_status'] = 'OK';
        }

        $model->fill($requestData);
        $model->save();

        flash()->addSuccess('Data berhasil diubah');
        return redirect()->route('siswa.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $siswa = Model::findOrFail($id);
    if ($siswa->tagihan->count() >= 1) {
            flash('Data tidak bisa dihapus karena masih relasi tagihan')->error();
            return redirect()->route('siswa.index');
        }
        $siswa->delete();
        flash('Data berhasil dihapus');
        return redirect()->route('siswa.index');
    }
}
