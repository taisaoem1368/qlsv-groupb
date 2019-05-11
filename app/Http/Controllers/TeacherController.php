<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\teacher;
use Illuminate\Support\Facades\Auth;
class TeacherController extends Controller
{
    public function index()
	{
		$obj = new teacher();
		$teacher = $obj->getList();

		return view('admin.teacher.tables', ['teacher' => $teacher]);
	}
	public function getAddTeacher()
	{
		return view('admin.teacher.add');
	}

	public function postAddTeacher(Request $req)
	{
		$this->validate($req, [
			'teacher_fullname' => 'required',
			'teacher_code' => 'required',
		], [
			'teacher_fullname.required' => 'Họ Tên giáo viên là bắt buộc',
			'teacher_code.required' => 'Mã giáo viên là bắt buộc',
		]);
		$obj = new teacher();
		$obj->createTeacher($req);
		return redirect()->back()->with('success', 'Thêm thành công');
	}

	public function getEditTeacher($id)
	{
		
		$obj = new teacher();
		$item = $obj->findId($id);
		return view('admin.teacher.edit', ['item' => $item]);
	}

	public function postEditTeacher(Request $req)
	{
		$obj = new teacher();
		$teacher_loggin = $obj->getTeacherId();
		$teacher_editting = $obj->findId($req->teacher_id);
		if($teacher_editting->teacher_code == "superadmin" && $teacher_loggin->teacher_code != "superadmin")
		{
			return redirect()->back()->with('message', 'Bạn không có quyền thay đổi thông tin superadmin');
		}

		$this->validate($req, [
			'teacher_fullname' => 'required',
			'teacher_code' => 'required',
		], [
			'teacher_fullname.required' => 'Họ Tên giáo viên là bắt buộc',
			'teacher_code.required' => 'Mã giáo viên là bắt buộc',
		]);
		if($req->teacher_password != '')
		{
			$this->validate($req, [
				'teacher_password' => 'min:6',
			], [
				'teacher_password.min' => 'password phải lớn hơn 6 kí tự',
			]);
		}
		
		$obj->updateTeacher($req);
		return redirect()->back()->with('success', 'Thay đổi thành công');
	}

	public function postDeleteTeacher(Request $req)
	{
		$this->validate($req, [
			'teacher_id' => 'required|numeric',
		], [
			'teacher_id.required' => 'Xóa thất bại, mã teacher truyền vào là bắt buộc',
			'teacher_id.numeric' => 'Xóa thất bại, mã teacher truyền vào phải là số',
		]);
		$obj = new teacher();
		if($obj->deleteTeacher($req->teacher_id) == false)
			return redirect()->back()->with('message', 'Xóa thất bại. Giáo viên này đang quản lí lớp nên không thể xóa.');

		return redirect()->back()->with('success', 'Xóa Thành Công!');
	}

	public function getAddFromFileTeacher()
	{
		return view('admin.teacher.add-file');
	}

	public function getSearchTeacher(Request $req)
	{
		$obj = new teacher();
		$teacher = $obj->getSearch($req->key, $req->types);
		$teacher_count = $teacher->total();
		return view('admin.teacher.tables', ['teacher' => $teacher, 'teacher_count' => $teacher_count]);
	}

	public function getProfileAdmin()
	{
		$obj = new teacher();
		$teacher = $obj->getTeacherId();

		if(!isset($teacher))
			return view('admin.index');
		$item = $obj->findId($teacher->teacher_id);	
		return view('admin.profile', ['item' => $item]);
	}

	//=============== CHỨC NĂNG CỦA USER ===================\\

	public function getProfile()
	{
		$obj = new teacher();
		$teacher = $obj->getTeacherId();
		$item = $obj->findId($teacher->teacher_id);
		return view('user.profile', ['item' => $item]);
	}

	public function postProfileUser(Request $req)
	{
		$obj = new teacher();
		$teacher = $obj->getTeacherId();
		$obj->setProfile($teacher->teacher_id, $req);
		return redirect()->back()->with('success', 'Thay đổi thành công');
	}

	

}
