<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Support\Facades\Session;
use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider; // Ensure this class exists in the specified namespace
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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

    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(Request $request)
    {
        if ($request->isMethod('post')) {

            $this->validate($request, [
                'email' => 'required|email',
                'password' => [
                    'required',
                    'min:8',
                    'max:20',
                    // 'regex:/^[A-Za-z0-9-_]+$/'
                ],
            ], [
                'email.required' => 'Email is required.',
                'email.email' => 'Please enter a valid email address.',
                'password.required' => 'Password is required.',
                'password.min' => 'Password must be at least 8 characters.',
                'password.max' => 'Password must not exceed 20 characters.',
                // 'password.regex' => 'Password must contain only letters, numbers, hyphens, and underscores.',
            ]);


            $credentials = $request->only('email', 'password');

            if (auth()->attempt($credentials)) {
                return redirect()->route('admin.home')->with(['message' => 'You are successfully logged in.', 'type' => 'success']);
            } else {
                toastr()->error('Email-Address and Password are wrong.');
                return redirect()->route('admin.login')->with(['message' => 'Invalid credentials.', 'type' => 'error']);
            }
        }
    }

    public function logout()
    {
        Session::flush();
        Auth::logout();
        return redirect()->route('admin.login')->with(['message' => 'You have been successfully logged out.', 'type' => 'success']);
    }
}
