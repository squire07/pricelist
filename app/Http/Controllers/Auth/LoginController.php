<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Auth;
use Hash;
use Session;
use Artisan;

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

    public function username()
    {
        return 'username';
    }

    protected function authenticated(Request $request, $user)
    {
        $redirect = [
            1 => 'sales-orders',
            2 => 'sales-invoice/for-invoice',
            3 => 'sales-orders',
            4 => 'sales-invoice/for-invoice',
            5 => 'sales-invoice/all',
            6 => 'sales-invoice/all',
            7 => 'sales-invoice/all',
            8 => 'sales-invoice/for-validation',
            9 => 'sales-invoice/all',
            10 => 'sales-invoice/all',
            11 => 'sales-invoice/all',
            12 => 'sales-invoice/all',
        ];
    
        $page = $redirect[$user->role_id] ?? 'sales-orders';
        return redirect('/' . $page);
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Session::flush();
        Artisan::call('cache:clear');
        Auth::logout();
        return redirect('/');
    }
}
