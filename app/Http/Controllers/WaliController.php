<?php

namespace App\Http\Controllers;

use App\Models\User as Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WaliController extends Controller
{
    private $viewIndex = 'wali_index';
    private $viewForm = 'wali_form';
    private $viewEdit = 'wali_form';
    private $viewShow = 'wali_show';
    private $routePrefix = 'wali';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        if ($request->filled('search')) {
            $models = Model::where('akses', 'wali')->search($request->search)->paginate(settings()->get('app_pagination', '50'));
        }else{
            $models = Model::where('akses', 'wali')->latest()->paginate(settings()->get('app_pagination', '50'));
        }
        return view('operator.' . $this->viewIndex, [
            'models' => $models,
            'routePrefix' => $this->routePrefix,
            'title' => 'Data Wali Murid'
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
            'title' => 'Form data wali murid',
            'routePrefix' => $this->routePrefix,

        ];
        return view('operator.' . $this->viewForm, $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $requestData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users',
            'nohp' => 'required|unique:users',
            'password' => 'required'
        ]);

        $requestData['password'] = Hash::make($requestData['password']);
        $requestData['email_verified_at'] = now();
        $requestData['akses'] = 'wali';

        Model::create($requestData);
        flash()->addSuccess('Data berhasil disimpan');
        return redirect()->route('wali.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        return view('operator.' . $this->viewShow, [
            'siswa' => \App\Models\Siswa::pluck('nama', 'id'),
            'model' => Model::with('siswa')->wali()->where('id', $id)->firstOrFail(),
            'routePrefix' => $this->routePrefix,
            'title' => 'Detail data wali',
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
            'model' => Model::findOrFail($id),
            'method' => 'PUT',
            'route' => [$this->routePrefix . '.update', $id],
            'button' => 'UPDATE',
            'routePrefix' => $this->routePrefix,
            'title' => 'Form data wali murid'
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
    public function update(Request $request, $id)
    {
        $requestData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'nohp' => 'required|unique:users,nohp,' . $id,
            'password' => 'nullable'
        ]);

        $model = Model::findOrFail($id);

        if ($requestData['password'] == "") {
            unset($requestData['password']);
        }else{
            $requestData['password'] = Hash::make($requestData['password']);
        }

        $model->fill($requestData);
        $model->save();
        flash()->addSuccess('Data berhasil diubah');
        return redirect()->route('wali.index');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $model = Model::where('akses', 'wali')->firstOrFail();

        $model->delete();
        flash('Data berhasil dihapus');
        return redirect()->route('wali.index');
    }
}
