<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\disciplinary_information;

class LoginController extends Controller
{
    /**
     * Handle an authentication attempt.
     *
     * @return Response
     */
    use AuthenticatesUsers;
    private $username = 'user_teacher_code';

    public function getLogin($id = "login")
    {
        return view('login.login');
    }

    public function postLoginWebsite(Request $request)
    {   
 
        $auth = array('user_teacher_code' => $request->user_teacher_code, 'password' => $request->password); 

        if(Auth::attempt($auth))
        {
            if(Auth::user()->user_role_id == 3)
            {
                return redirect('/user/');
            }
            else
            {
                return redirect('/admin/');
            }
        } else {
            return redirect()->back()->with('message', 'Sai tài khoản hoặc mật khẩu');
        }//phong1333@gmail.com
    }



    public function Logout()
    {
        Auth::logout();
        return redirect('/auth/login');
    }
    public function username()
    {
        return $username;
    }

}
