<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */

    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function loginUrl(Request $request)
    {
        if (! $request->hasValidSignature()) {
            abort(401);
        }
        $user = Auth::loginUsingId($request->user_id);
        return redirect($request->url);
    }

    /**
     * Show the application's login form.
     *
     * @return \Illuminate\View\View
     */
    public function showLoginForm()
    {
        return view('layouts.login');
    }

    public function showLoginFormWali()
    {
        return view('layouts.login_wali');
    }

    public function authenticated(Request $request, $user)
    {
        if($user->akses == 'operator' || $user->akses == 'admin'){
            return redirect()->route('operator.beranda');
        }elseif($user->akses == 'wali'){
            return redirect()->route('wali.beranda');
        }else{
            Auth::logout();
            flash()->addSuccess('Anda tidak memiliki hak akses')->error();
            return redirect()->route('login');
        }
    }
}
