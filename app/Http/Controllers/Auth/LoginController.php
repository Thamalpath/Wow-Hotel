<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Foundation\Auth\AuthenticatesUsers;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;
use App\Models\User;

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
    protected $redirectTo = '/dashboard';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('auth')->only('logout');
    }

    public function username()
    {
        return 'username';
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password1' => 'required',
            'password2' => 'required',
        ]);

        $user = User::where('username', $credentials['username'])->first();

        if ($user && 
            Hash::check($credentials['password1'], $user->password1) && 
            Hash::check($credentials['password2'], $user->password2)) {
            
            Auth::login($user);
            
            return redirect()->intended($this->redirectTo)
            ->with('toastr', [
                'type' => 'success',
                'message' => 'Signed in successful!'
            ]);
        }

        return back()
            ->with('toastr', [
                'type' => 'error',
                'message' => 'Invalid credentials'
            ])
            ->withInput($request->except(['password1', 'password2']));
    }
}
