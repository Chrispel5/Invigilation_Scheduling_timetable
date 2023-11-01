<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use App\Models\User;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    use RegistersUsers;

    /**
     * Where to redirect users after registration.
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
        $this->middleware('guest');
    }

    /**
     * Show the registration form.
     *
     * @return \Illuminate\View\View
     */

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {  
        $request->validate([
            'department_id' => ['required', 'string', 'max:255'],
            'faculty_id' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:6', 'confirmed'],
        ]);
        
        $user = $this->create($request->all());
        
        Auth::login($user);
        
        return redirect()->route('dashboard')->with('success', 'Welcome in!');
    }


     public function postRegistration(Request $request)
    {  
        $request->validate([
            'department_id' => 'required',
            'faculty_id' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
        ]);
           
        $data = $request->all();
        $check = $this->create($data);
         
        return redirect("dashboard")->withSuccess('Great! You have Successfully loggedin');
    }

    
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'department_id' => ['required', 'string', 'max:255'],
            'faculty_id' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

 
    protected function create(array $data)
    {
        return User::create([
            'department_id' => $data['department_id'],
            'faculty_id' => $data['faculty_id'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }
}
