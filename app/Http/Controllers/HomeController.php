<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use \App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class HomeController extends Controller
{
    public function index() {
        return view('home');
    }

    public function login(){
        return view('auth.login');
    }

    public function loginStore(Request $request){
        $data = $request->validate([
            "email" => "required|string",
            "password"=>"required|string",
        ]);
        $user = User::where('email', $data["email"])->where('active',"S")->first();
        $remember = $request->has('remember');
        if ($user && Hash::check($data["password"], $user->password)) {
            Auth::login($user);
            return redirect()->route('home')->with("success", "Bienvenido");
        }

        else return redirect()->back()->with("error", "Correo o contraseña equivocados");
    }

    public function logout(){
        Auth::logout();
        return redirect()->route('login');
    }

    public function register(){
        return view('auth.register');
    }

    public function registerStore(Request $request){
        return redirect()->route('login')->with('success', 'Registration successful. Please log in.');
    }

    public function forgotPassword(){
        return view('auth.forgot');
    }

    public function forgotPasswordStore(){

    }

    public function profile(){
        return view('home.profile');
    }

    public function settings(){
        return view('settings.index');
    }

    public function settingsPassword(){}

    public function settingsLenguaje(){}

}
