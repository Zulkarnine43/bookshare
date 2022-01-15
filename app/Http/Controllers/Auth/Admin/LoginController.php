<?php

namespace App\Http\Controllers\Auth\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use App\Admin;
use Auth;
use Symfony\Component\HttpFoundation\Session\Session;


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
    protected $redirectTo = '/adminn';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    public function showLoginForm()
    {
        return view('backend.auth.login');
    }

    public function login(Request $request)
    {
        $this->validate($request, [
            'email' => 'required|email',
            'password' => 'required',
        ]);



        if (Auth::guard('ame')->attempt(['email' => $request->email, 'password' => $request->password], $request->remember)) {

            // Log Him Now
            return redirect()->intended(route('admin.index'));
        } else {
            session()->flash('sticky_error', 'Invalid Login');
            return back()->with('error', 'Invalid login');
        }
    }

    public function logout()
    {
        Auth::guard('ame')->logout();
        return redirect()->route('index');
    }
}
