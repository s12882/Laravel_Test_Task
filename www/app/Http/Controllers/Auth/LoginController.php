<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Models\User;
use Auth;

class LoginController extends Controller {

use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('guest')->except('logout');
    }

    public function index() {
        return view('auth.login');
    }

    public function login(Request $request) {
        $login = $request->get('login');
        $password = $request->get('password');
        $remember = isset($request['remember']) ? 'true' : '';

        if (Auth::viaRemember() || Auth::attempt(array('login' => $login, 'password' => $password, 'is_active' => 1),$remember)) {
            return redirect()->route('home');
        } else {
          $user = User::select('is_active')->where('login', $login)->first();
          if($user != null && $user->is_active === 0){
            $info = trans('actions.user_disabled');
          }else{
            $info = trans('actions.wrong_username');
          }
          return redirect()->route('login')->with('message', $info);
        }
    }

    public function guest() {

        if (Auth::viaRemember() || Auth::attempt(array('login' => "guest", 'password' => "1234", 'is_active' => 1))) {
            return redirect()->route('home');
        } else {
          return redirect()->route('login')->with('message', 'Error occured');
        }
    }

    public function logout() {
        Auth::logout();
        return redirect()->route('login');
    }

}
