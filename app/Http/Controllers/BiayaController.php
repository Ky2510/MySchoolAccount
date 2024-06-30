<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBiayaRequest;
use App\Http\Requests\UpdateBiayaRequest;
use Illuminate\Http\Request;
use App\Models\Biaya as Model;

class BiayaController extends Controller
{
    private $viewIndex = 'biaya_index';
    private $viewForm = 'biaya_form';
    private $viewEdit = 'biaya_form';
    private $viewShow = 'biaya_show';
    private $routePrefix = 'biaya';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->filled('search')) {
            $models = Model::with('user')->whereNull('parent_id')->search($request->search)->paginate(settings()->get('app_pagination', '50'));
        }else{
           $models =  Model::with('user')->whereNull('parent_id')->latest()->paginate(settings()->get('app_pagination', '50'));
        }
        return view('operator.' . $this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Biaya'
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        $biaya = new Model();
        if ($request->filled('parent_id')) {
            $biaya =  Model::with('children')->findOrFail($request->parent_id);
        }
        $data = [
            'parentData' => $biaya,
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'Biaya',
            'routePrefix' => $this->routePrefix
        ];
        return view('operator.' . $this->viewForm, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBiayaRequest $request)
    {
        Model::create($request->validated());
        flash('Data berhasil disimpan')->success();
        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {

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
            'model' => Model::findOrFail($id),
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'UPDATE',
            'title' => 'Form Biaya',
            'routePrefix' => $this->routePrefix
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
    public function update(UpdateBiayaRequest $request, $id)
    {
        $model = Model::findOrFail($id);
        $model->fill($request->validated());
        $model->save();

        flash('Data berhasil diubah')->warning();
        return redirect()->route('biaya.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Model::findOrFail($id);

        // Validasi relasi ke table children
        if ($model->children->count() >= 1) {
            flash('Data berhasil dihapus karena masih memiliki item biaya. Hapus item biaya terlebih dahulu')->error();
            return redirect()->back();
        }
        // Validasi relasi ke table siswa
        if ($model->siswa->count() >= 1) {
            flash('Data tidak bisa dihapus karena masih memiliki relasi ke data siswa')->success();
            return redirect()->back();
        }
        $model->delete();
        flash('Data berhasil dihapus')->success();
        return redirect()->back();
    }

    public function deleteItem($id)
    {
        $model = Model::findOrFail($id);
        $model->delete();
        flash('Data berhasil dihapus')->success();
        return redirect()->back();
    }
}
