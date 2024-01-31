<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;

class RegisterController extends Controller
{
    use RegistersUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest');
    }

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'phone' => ['required', 'string', 'max:15'], // Updated to 'phone'
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    protected function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = $this->create($request->all());

        // can add additional logic here (e.g., sending email verification)

        return redirect()->route('login')->with('success', 'Registration successful! Please log in.');
    }

    protected function create(array $data)
    {
        $role = isset($data['role']) ? $data['role'] : 1;
    
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'phone' => $data['phone'],
            'password' => Hash::make($data['password']),
            'role' => $role,
        ]);
    }
    
}
