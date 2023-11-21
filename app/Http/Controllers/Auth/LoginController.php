<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Foundation\Auth\ThrottlesLogins;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use App\Models\PermissionModule;
use App\Models\User;
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
    use ThrottlesLogins;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = RouteServiceProvider::HOME;

    protected $maxAttempts = 3; // maximum number of login attempts
    // protected $decayMinutes = 2;
    protected $warning = 2;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        // $this->middleware('throttle:3,0')->only('login');
    }

    public function username()
    {
        return 'username';
    }

    // protected function authenticated(Request $request, $user)
    // {
    //     $redirect = [
    //         1 => 'sales-orders',
    //         2 => 'sales-invoice/for-invoice',
    //         3 => 'sales-orders',
    //         4 => 'sales-invoice/for-invoice',
    //         5 => 'sales-invoice/all',
    //         6 => 'sales-invoice/all',
    //         7 => 'sales-invoice/all',
    //         8 => 'sales-invoice/for-validation',
    //         9 => 'sales-invoice/all',
    //         10 => 'sales-invoice/all',
    //         11 => 'sales-invoice/all',
    //         12 => 'sales-invoice/all',
    //     ];
    
    //     $page = $redirect[$user->role_id] ?? 'sales-orders';
    //     return redirect('/' . $page);
    // }

    protected function authenticated(Request $request, $user) 
    {
        // get the first allowed module of user
        $permissions = json_decode($user->permission->user_permission, true);


        $has_value_one = false;
        foreach ($permissions as $permission) {
            if (in_array(1, $permission)) {
                $has_value_one = true;
                break;
            }
        }


        $module_ids = [];

        if ($has_value_one) {
            foreach ($permissions as $key => $sub_array) {
                if (isset($sub_array["1"]) && $sub_array["1"] === 1) {
                    $module_ids[] = $key;
                }
            }

            if(in_array($user->role_id, [1,3]) && in_array(1, $module_ids)) {
                $redirect = 'sales-orders';
            } else if(in_array($user->role_id, [2,4]) && in_array(2, $module_ids)) {
                $redirect = 'sales-invoice/for-invoice';
            } else if(in_array($user->role_id, [8]) && in_array(4, $module_ids)) {
                $redirect = 'sales-invoice/for-validation';
            } elseif (in_array($user->role_id, [5, 6, 7, 9, 10, 11, 12]) && in_array(6, $module_ids)) {
                $redirect = 'sales-invoice/all';
            } else {

                // First rule: find the user's first allowed module
                $module_id = null;

                foreach ($permissions as $key => $sub_array) {
                    if (isset($sub_array["1"]) && $sub_array["1"] === 1) {
                        $module_id = $key;
                        break;
                    }
                }

                $permission_module = PermissionModule::find($module_id);
                $redirect = $permission_module ? $permission_module->redirect : 'sales-orders'; // Fallback to default
            }

            /*
            * For Main Navigation Use
            * SESSION: get all the module id's that has "1":1  `index`:allowed  and store in session to be used by main navigation
            */
            Session::put('navigation_ids', $module_ids);
            // END of Main Navigation Use

            return redirect('/' . $redirect);
        } else {
            Auth::guard('web')->logout();
            Session::flush();
            Artisan::call('cache:clear');
            Auth::logout();
            return redirect('/login')->with('error-login', 'You currently do not have any accessible permission sets. Please contact your administrator.');
        }
    }

    public function logout(Request $request)
    {
        Auth::guard('web')->logout();
        Session::flush();
        Artisan::call('cache:clear');
        Auth::logout();
        return redirect('/');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'password' => 'required',
        ]);

        $credentials = $request->only('username', 'password');

        $user = User::with('permission')->whereUsername($request->username)->first();
        if($user && $user->blocked == 1) {
            return redirect()->back()->with('error-login', "Your account has been blocked! Please contact your administrator.");
        } else if ($user && $user->active == 0) {
            return redirect()->back()->with('error-login', "Your account has been deactivated! Please contact your administrator.");
        } else if($user) {
            if (Auth::attempt($credentials)) {
                $user->attempts = 0; // Reset login attempts on successful login
                $user->update();
                // redirect
                return $this->authenticated($request, $user);
            } else {
                $user->attempts++; // Increment login attempts
                $user->update();

                $remaining_attempts = max(0, 3 - $user->attempts); // Calculate remaining attempts
                $attempts_label = ($remaining_attempts === 1) ? 'attempt' : 'attempts';
                $lockout_message = "Invalid password. You have {$remaining_attempts} {$attempts_label} remaining.";
        
                if ($user->attempts >= 3) {
                    $user->blocked = 1; // Block the user after 3 failed attempts
                    $user->update();
                    return $this->sendLockoutResponse($request);
                }
                return redirect('/login')->with('error-login', $lockout_message);
            }
        } else {
            return redirect('/login')->with('error-login', 'Your username is not valid!');
        }
    }

    protected function sendLockoutResponse(Request $request)
    {
        return redirect()->back()->with('error-login', "Your account has been blocked! Please contact your administrator.");
    }
}
