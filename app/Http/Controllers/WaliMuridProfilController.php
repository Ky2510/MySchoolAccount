<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class WaliMuridProfilController extends Controller
{
    private $viewIndex = 'user_index';
    private $viewForm = 'user_form';
    private $viewEdit = 'user_form';
    private $viewShow = 'user_show';
    private $routePrefix = 'wali.profil';
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            'model' => User::findOrFail(auth()->user()->id),
            'method' => 'POST',
            'route' => $this->routePrefix . '.store',
            'button' => 'UBAH',
            'title' => 'Form Profil'
        ];

        return view('wali.profil_form', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $id = auth()->user()->id;
        $requestData = $request->validate([
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'nohp' => 'required|unique:users,nohp,' . $id,
            'password' => 'nullable'
        ]);

        $model = User::findOrFail($id);

        if ($requestData['password'] == "") {
            unset($requestData['password']);
        }else{
            $requestData['password'] = Hash::make($requestData['password']);
        }

        $model->fill($requestData);
        $model->save();
        flash('Data berhasil diubah');
        return redirect()->back();
    }
}
