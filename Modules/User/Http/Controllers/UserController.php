<?php

namespace Modules\User\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;

use Modules\User\Http\Requests\LoginRequest;
use Auth;

class UserController extends Controller
{
    protected $redirectTo = '/thanh-vien';

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
    /**
     * Display a listing of the resource.
     * @return Response
     */
    public function index()
    {
        return view('user::index');
    }

    /**
     * Show the form for creating a new resource.
     * @return Response
     */
    public function create()
    {
        return view('user::create');
    }

    /**
     * Store a newly created resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function store(Request $request)
    {
    }

    /**
     * Show the specified resource.
     * @return Response
     */
    public function show()
    {
        return view('user::show');
    }

    /**
     * Show the form for editing the specified resource.
     * @return Response
     */
    public function edit()
    {
        return view('user::edit');
    }

    /**
     * Update the specified resource in storage.
     * @param  Request $request
     * @return Response
     */
    public function update(Request $request)
    {
    }

    /**
     * Remove the specified resource from storage.
     * @return Response
     */
    public function destroy()
    {
    }

    public function getLogin(){
        return view("user::frontend.login");
    }

    public function getLogout(){
        Auth::logout();
        return redirect()->route('frontend.user.login')->withSuccess(trans('user::messages.successfully logged in'));
    }

    public function postLogin(LoginRequest $request){
        $field = filter_var($request->login, FILTER_VALIDATE_EMAIL) ? 'email' : 'username';
        $request->merge([$field => $request->login]);
        $credentials = [
            $field => $request->login,
            'password' => $request->password,
        ];
        $remember = (bool) $request->get('remember', false);

        $error = Auth::attempt($credentials, $remember);

        if (Auth::attempt($credentials, $remember)) {
            $user = Auth::getLastAttempted();
            if ($user->active) {
                //return redirect()->intended($this->redirectPath());
                return redirect()->intended()
                    ->withSuccess(trans('user::messages.successfully logged in'));
            }
            return redirect()->route('frontend.user.login')
                ->withInput()
                ->withErrors([
                    'active' => '<label>Tài khoản đang tạm khóa, vui lòng liên hệ <a href="mailto: minhhai.dw@gmail.com?subject=Yêu cầu kích hoạt tài khoản '.$request->login.'">quản trị viên</a>!</label>'
                    ]);
        }

        return redirect()->route('frontend.user.login')
            ->withInput()
            ->withErrors([
                //'login' => trans('user::auth.failed login error'),
                'login' => 'Thông tin đăng nhập không đúng, vui lòng thử lại!',
                ]);
    }
}
