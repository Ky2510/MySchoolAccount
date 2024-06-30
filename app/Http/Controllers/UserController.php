<?php

namespace App\Http\Controllers;

use App\Models\User as Model;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    private $viewIndex = 'user_index';
    private $viewForm = 'user_form';
    private $viewEdit = 'user_form';
    private $viewShow = 'user_show';
    private $routePrefix = 'user';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $models = Model::where('akses', '<>', 'wali')->latest();

        if ($request->filled($request->search)) {
            $models =  $models->search($request->search);
        }

        return view('operator.' . $this->viewIndex, [
            'models' => $models->paginate(settings()->get('app_pagination', 'My APP')),
            'routePrefix' => $this->routePrefix,
            'title' => 'Data User'
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
            'title' => 'Form data user'
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
            'akses' => 'required|in:operator,admin',
            'password' => 'required'
        ]);

        $requestData['password'] = Hash::make($requestData['password']);
        $requestData['email_verified_at'] = now();
        Model::create($requestData);
        flash('Data berhasil disimpan');
        return redirect()->route('user.index');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
            'title' => 'Form data user'
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
            'akses' => 'required|in:operator,admin',
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
        flash('Data berhasil diubah');
        return redirect()->route('user.index');
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

        if ($model->id == 1) {
            flash('Data tidak bisa dihapus')->error();
            return back();
        }

        $model->delete();
        flash('Data berhasil dihapus');
        return back();
    }
}
