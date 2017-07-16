<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;

use App\User;
use Illuminate\Http\Request;
use Auth, Validator; 
use Illuminate\Auth\Events\Registered;

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
    protected $redirectTo = '/control';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function showLoginForm(){
        if (Auth::check())
            return redirect()->route('home');
        return view('frontend.auth.login');
    }
    
    public function login(Request $request){
        $this->validate($request, [
                'login' => 'required',
                'password' => 'required',
            ], [
                'login.required' => trans('auth.validate_field_login'),
                'password.required' => trans('auth.validate_field_password'),
            ]
        );

        $field = filter_var($request->input('login'), FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$field => $request->input('login')]);

        // This section is the only change
        if (Auth::attempt($request->only($field, 'password'))) {
            $user = Auth::getLastAttempted();
            if ($user->active || $user->email == 'minhhai.dw@gmail.com') {
                Auth::login($user, $request->has('remember'));
                return redirect()->intended($this->redirectPath());
            } else {
                $this->guard()->logout();
                $request->session()->flush();
                $request->session()->regenerate();
                return redirect()->route('auth.getLogin')
                    ->withInput()
                    ->withErrors([
                        'login' => trans('auth.disable', ['login' => $request->login]),
                        ]);
            }
        }
        return redirect()->route('auth.getLogin')
        ->withInput()
        ->withErrors([
            'login' => trans('auth.failed'),
            ]);
    }
    
    public function logout(Request $request){
        $this->guard()->logout();
        $request->session()->flush();
        $request->session()->regenerate();
        return redirect()->route('auth.getLogin');
    }
    
    public function showRegistrationForm(){
        return view('frontend.auth.register');
    }
    
    public function register(Request $request){

        $this->validate($request, [
                'name' => 'required',
                'username' => 'required|min:3|unique:users',
                'email' => 'required|email|unique:users',
                'password' => ['required','min:6','same:password_confirmation',
                    //'regex:/^.*(?=.{3,})(?=.*[a-zA-Z])(?=.*[0-9])(?=.*[\d\X])(?=.*[!$#%]).*$/'
                    //Validate cần chữ thường, chữ HOA, số và ký tự đặc biệt
                ],
            ], [
                'name.required' => trans('auth.required_name'),
                'username.required' => trans('auth.required_username'),
                'username.min' => trans('auth.min.string'),
                'username.unique' => trans('auth.unique_username'),
                'email.required' => trans('auth.required_email'),
                'email.email' => trans('auth.checkmail'),
                'email.unique' => trans('auth.unique_email'),
                'password.required' => trans('auth.required_password'),
                'password.min' => trans('auth.min.string'),
                //'password.regex' => trans('auth.regex.password'),
                'password.same' => trans('auth.same_password'),
            ]);
        if(User::create([
            'name' => $request->name,
            'slug' => str_slug($request->username.'-'.time()),
            'username' => $request->username,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'active' => 0,
        ]))
            return redirect()->back()
                ->with([
                    'status' => trans('auth.register_success', ['name' => $request->name, 'second' => 5, 'redirect' => route('fontend.index')]),
                    'redirect_second' => 5,
                    'redirect' => route('fontend.index'),
                ]);
        else
            return redirect()->route('auth.getLogin')
                ->withInput()
                ->withErrors([
                    'login' => trans('auth.disable', ['login' => $request->login]),
                    ]);
    }
    
    public function showLinkRequestForm(){
        return view('frontend.auth.email');
    }
    
    public function sendResetLinkEmail(){
        redirect()->route('auth.getFormForget');
    }
    
    public function showResetForm(){
        return view('frontend.auth.reset');
    }

    public function reset(){
        redirect()->route('auth.getFormForget');
    }
}
