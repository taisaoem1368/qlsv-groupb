<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Hash;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\user;
use App\Http\Models\classModel;

class teacher extends Model
{
    protected $table = 'teacher';
	public $primaryKey = 'teacher_id';

	public function getTeachcher_Role()
	{
		return $this->belongsTo('App\Http\Models\role', 'teacher_role_id');
	}

	public function getClass_teacher_old() {
		return $this->belongsTo('App\Http\Models\teacher', 'class_old_teacher_id');
	}

	public function findId($id)
	{
		$kq = teacher::join('users', 'user_teacher_code', 'teacher_code')->where('teacher_id', $id)->first();
		return $kq;
	}

	public function checkTeacherExist($teacher_code)
	{
		$kq = $this->where('teacher_code', $teacher_code)->first();
		if(count($kq) <= 0)
			return false;
		return true;
	}

	public function getTeacherIdByTeacherCode($teacher_code)
	{
		$kq = $this->where('teacher_code', $teacher_code)->first();
		return $kq['teacher_id'];
	}

	public function userUpdate(Request $req)
	{
		$teacher = teacher::find($req->teacher_id);
		$teacher->teacher_email = $req->teacher_email;
		$teacher->teacher_phone = $req->teacher_phone;
		$obj = new user();
		$obj->setValue($teacher->teacher_code, null, $req->teacher_password, null);
		$teacher->save();
	}

	public function createTeacher($req)
	{
		$teacher = new teacher();
		$obj_user = new user();
		$teacher->teacher_fullname = $req->teacher_fullname;
		$teacher->teacher_code = $req->teacher_code;
		$teacher->teacher_phone = $req->teacher_phone;
		$teacher->teacher_email = $req->teacher_email;
		if(Auth::user()->user_role_id == 1){$obj_user->createValue($teacher->teacher_code, $teacher->teacher_code, $req->teacher_role_id);}
		else{$obj_user->createValue($teacher->teacher_code, $teacher->teacher_code, 3);}
		$teacher->save();
		return $teacher->teacher_id;
	}

	public function updateTeacher($req)
	{

		$teacher_logged = $this->getTeacherId();

		$teacher = $this->find($req->teacher_id);

		$obj_user = new user();
		if($req->teacher_password != ""){$password = $req->teacher_password;}
		else{$password = null;}
		if(Auth::user()->user_role_id == 1) 
		{
			
			$obj_user->setValue($teacher->teacher_code, $req->teacher_code, $password, $req->teacher_role_id);
		}	
		else 
			{$obj_user->setValue($teacher->teacher_code, $req->teacher_code, $password, null);}

		$teacher->teacher_fullname = $req->teacher_fullname;
		$teacher->teacher_code = $req->teacher_code;
		$teacher->teacher_phone = $req->teacher_phone;
		$teacher->teacher_email = $req->teacher_email;
		$teacher->save();
	}

	public function deleteTeacher($id)
	{
		$obj_class = new classModel();
		$obj_user = new user();
		$teacher = $this->find($id);
		if($obj_class->checkTeacherInClass($id) == true)
			return false;
		if($teacher->teacher_code == "superadmin")
			return false;
		$obj_user->deleteUser($teacher->teacher_code);
		$teacher->delete();
		return true;
	}

	public function getList()
	{
		return teacher::join('users', 'user_teacher_code', 'teacher_code')
		->join('role', 'role_id', 'user_role_id')
		->where('teacher_code', '<>', "superadmin")
		->paginate(10);
	}

	public function getSearch($key, $type)
	{
		if($type == "md")
		{
			$kq = teacher::where('teacher_fullname', 'like', '%'.$key.'%')
					->orWhere('teacher_code', 'like', '%'.$key.'%')
					->orWhere('teacher_phone', 'like', '%'.$key.'%')
					->orWhere('teacher_email', 'like', '%'.$key.'%')
					->paginate(10);
		}
		else if ($type == "ht")
		{
			$kq = teacher::where('teacher_fullname', 'like', '%'.$key.'%')->paginate(10);
		}
		else if($type == "mgv")
		{
			$kq = teacher::where('teacher_code', 'like', '%'.$key.'%')->paginate(10);
		}
		else if($type == "phone")
		{
			$kq = teacher::where('teacher_phone', 'like', '%'.$key.'%')->paginate(10);
		}
		else 
		{
			$kq = teacher::where('teacher_email', 'like', '%'.$key.'%')->paginate(10);
		}
		return $kq;
	}

	//================================ CHỨC NĂNG USER =============\\\

	public function setProfile($id, Request $req)
	{
		$teacher = teacher::find($id);
		$teacher->teacher_email = $req->teacher_email;
		$teacher->teacher_phone = $req->teacher_phone;
		if($req->teacher_password != "")
		{
			$obj = new user();
			$obj->setValue($teacher->teacher_code, null, $req->teacher_password, null);
		}
		$teacher->save();
	}

	function getTeacherId()
    {
    	$kq = $this->where('teacher_code', Auth::user()->user_teacher_code)->first();
        return $kq;
    }
}
