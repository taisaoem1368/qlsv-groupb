<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\teacher;
use App\Http\Models\user;
use Illuminate\Support\Facades\Mail;
use App\Mail\MailForgotPassword;
use App\Mail\MailNotification;
use App\Http\Models\disciplinary_information;

class SendEmailController extends Controller
{
    //-------Forgot password----//
    public function postSendEmailForClient(Request $req)
    {
    	$this->validate($req, [
    		'email_reset' => 'required|email',
    		'recaptcha' => 'required|same:captcha',
    	], [
    		'email_reset.required' => 'Nhập email là bắt buộc',
    		'email_reset.email' => 'Không đúng định dạng email',
    		'recaptcha.required' => 'Mã xác nhận là bắt buộc',
    		'recaptcha.same' => 'Mã kiểm tra không đúng',
    	]);
    	$email = $req->email_reset;

    	$obj_user = new user();

    	$teacher = teacher::where('teacher_email', $email)->first();

    	if(count($teacher) <= 0)
    		return redirect()->back()->with('message', 'Không tìm thấy email trong hệ thống');
    	$lastname = explode(' ', $teacher['teacher_fullname']);
    	$token = $obj_user->updateRememberToken($teacher['teacher_code']);
    	$data = array(
    		'teacher_name' => end($lastname),
    		'token' => $token
    	);
    	Mail::to($email)->send(new MailForgotPassword($data));
    	return redirect()->back()->with('success', 'Chúng tôi đã gửi email cho bạn đến '.$email);
    }

    public function getSendEmailForClient()
    {
    	//return view('forgotpassword-mail');
    	return view('login.forgotpassword');
    }

    public function testPage()
    {
        return view('charts');
    }




    public function postChangePassword(Request $req)
    {
    	$this->validate($req, [
    		'password' => 'required|min:6|max:32',
    		'repassword' => 'same:password',

    	], [
    		'password.required' => 'Mật khẩu là bắt buộc',
    		'password.min' => 'Mật khẩu tối thiểu là 6 kí tự',
    		'password.max' => 'Mật khẩu tối đa là 32 kí tự',
    		'repassword.same' => 'Mật khẩu không trùng khớp',
    	]);

    	$obj_user = new user();
    	$token = $req->token;
    	$password = $req->password;

    	if($obj_user->resetPassword($token, $password))
    		return redirect()->route('getLogin')->with('success', 'Thay đổi mật khẩu thành công');

    	return redirect()->route('getSendEmailForClient')->with('message', 'liên kết này đã hết hạn');
    }

    public function showResetForm($token)
    {
    	$obj_user = new user();
    	if(!$obj_user->checkExistRememberToken($token))
    		return redirect()->route('getSendEmailForClient')->with('message', 'liên kết này đã hết hạn');
    	return view('login.resetpassword')->with('token', $token);
    }

    //-------End password----//

    //-------Mail Notification --------\\
    public function getMailNotificationPage()
    {
		$obj_teacher = new teacher();
		$obj_di = new disciplinary_information();
		$hocky = $obj_di->returnSemesterMax();
        $nam = $obj_di->returnYearMax();
        $data = $obj_teacher->getTeacherComfirmIsNull($hocky, $nam);
        return view('admin.ttkyluat.teacher-not-comfirm', ['data' => $data]);
	}
	
	public function postSendNotificationForTeacher(Request $req)
	{
		$this->validate($req, [
			'hocky' => 'required|numeric',
			'nam' => 'required|numeric',
			'dealtime' => 'required|date',
		], [
			'hocky.required' => 'Học kỳ là bắt buộc',
			'hocky.numeric' => 'Học kỳ phải là số',
			'nam.required' => 'Năm học là bắt buộc',
			'nam.numeric' => 'Năm học phải là số',
			'dealtime.required' => 'Hạn chót là bắt buộc',
			'dealtime.date' => 'Hạn chót sai định dạng',
		]);

		$obj_teacher = new teacher();
		$email = $obj_teacher->getArrayEmailTeacher($obj_teacher->getTeacherComfirmIsNull($req->hocky, $req->nam));
		if(count($email) <= 0)
			return redirect()->back()->with('message', 'không tìm thấy giáo viên chưa phản hồi học kì '.$req->hocky.' năm học '.$req->nam.'-'.($req->nam+1));
		$Success = $obj_teacher->sendEmailNotification($req->dealtime, $req->hocky, $req->nam);
		return redirect()->back()->with('success', 'Gửi thành công đến '.$Success.' giáo viên');
	}

	// public function tryToOnEmailNotication(Request $req)
	// {

	// }


    //-------End Mail Notification --------\\
}
