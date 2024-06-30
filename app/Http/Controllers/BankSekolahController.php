<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreBankSekolahRequest;
use App\Http\Requests\UpdateBankSekolahRequest;
use App\Models\Bank;
use Illuminate\Http\Request;
use App\Models\BankSekolah as model;

class BankSekolahController extends Controller
{
    private $viewIndex = 'banksekolah_index';
    private $viewForm = 'banksekolah_form';
    private $viewEdit = 'banksekolah_form';
    private $viewShow = 'banksekolah_show';
    private $routePrefix = 'banksekolah';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->filled('search')) {
            $models = Model::search($request->search)->paginate(settings()->get('app_pagination', '50'));
        }else {
            $models = Model::latest()->paginate(settings()->get('app_pagination', '50'));
        }
        return view('operator.' . $this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Bank Sekolah'
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
            'model' => new Model(),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'SIMPAN',
            'title' => 'Form Bank Sekolah',
            'routePrefix' => $this->routePrefix,
            'listbank' => \App\Models\Bank::pluck('nama_bank', 'id')
        ];
        return view('operator.' . $this->viewForm, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreBankSekolahRequest $request)
    {
        $requestData = $request->validated();
        $bank = Bank::find($request['bank_id']);
        unset($requestData['bank_id']);
        $requestData['kode'] = $bank->sandi_bank;
        $requestData['nama_bank'] = $bank->nama_bank;

        Model::create($requestData);
        flash('Data berhasil disimpan')->success();
        return redirect()->route('banksekolah.index');
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
            'title' => 'Form Bank Sekolah',
            'routePrefix' => $this->routePrefix,
            'listbank' => \App\Models\Bank::pluck('nama_bank', 'id')
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
    public function update(UpdateBankSekolahRequest $request, $id)
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
        $model = Model::firstOrFail();
        $model->delete();
        flash('Data berhasil dihapus')->success();
        return redirect()->route('biaya.index');
    }
}
