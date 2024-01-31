<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request; 
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

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

    protected function login(Request $request)
{
        $credentials = $request->validate([
            'name' => 'required',
            'password' => 'required'
        ]);

        if (Auth::attempt($credentials)) {
            $user_role = Auth::user()->role;
            switch ($user_role) {
                case 1:
                    return $this->redirectToWithMessage('/user', 'Login successful for user role 1');
                case 2:
                    return $this->redirectToWithMessage('/staff', 'Login successful for user role 2');
                case 3:
                    return $this->redirectToWithMessage('/admin', 'Login successful for user role 3');
                default:
                    Auth::logout();
                    return $this->redirectToWithMessage('/login', 'Oops! Something went wrong', 'error');
            }
        } else {
            return view('auth.login')->with('error', 'Incorrect username or password');
        }
    }

    private function redirectToWithMessage($route, $message, $type = 'success')
    {
        return redirect($route)->with($type, $message);
    }
}
