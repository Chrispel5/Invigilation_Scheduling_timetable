<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Models\User;
use Hash;


class LoginController extends Controller
{
    
    public function index()
    {
        return view('auth.login');
    }  
      
    
    public function postLogin(Request $request)
    {
        $request->validate([
            'faculty' => 'required',
            'email' => 'required',
            'password' => 'required',
        ]);
   
        $credentials = $request->only('email', 'faculty', 'password');
        if (Auth::attempt($credentials)) {
            return redirect()->intended('dashboard')
                        ->withSuccess('You have Successfully loggedin');
        }
  
        return redirect("login")->withSuccess('Opps! You have entered invalid credentials');
    }
      
  
    public function postRegistration(Request $request)
    {  
        $request->validate([
            'faculty' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }
    

    public function logout() {
        Session::flush();
        Auth::logout();
  
        return Redirect('login');
    }
}