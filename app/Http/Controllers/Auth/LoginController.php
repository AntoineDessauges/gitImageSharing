<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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

    /*protected function credentials(Request $request)
    {
        $field = filter_var($request->input('credentials'), FILTER_VALIDATE_EMAIL) ? 'email' : 'acronym';
        return [$field=>$request->input("credentials"),'password'=>$request->get("password")];
    }
    protected function validateLogin(Request $request)
    {
        $field = filter_var($request->input('credentials'), FILTER_VALIDATE_EMAIL) ? 'email' : 'acronym';
        $this->validate($request, [
            $field => 'required|min:2', 'password' => 'required|min:6',
        ]);
    }*/
    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest', ['except' => 'logout']);
    }
}
