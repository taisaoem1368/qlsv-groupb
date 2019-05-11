<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Models\teacher;
use App\Http\Models\course;
use App\Http\Models\student;
use App\Http\Models\major;

class classModel extends Model
{
    protected $table = 'class';
	public $primaryKey = 'class_id';
	public $timestamps = false;
	public function getClass_teacher() {
		return $this->belongsTo('App\Http\Models\teacher', 'class_teacher_id');
	}
	public function getClass_teacher_old() {
		return $this->belongsTo('App\Http\Models\teacher', 'class_old_teacher_id');
	}
	public function getClass_course() {
		return $this->belongsTo('App\Http\Models\course', 'class_course_id');
	}
	public function getClass_major() {
		return $this->belongsTo('App\Http\Models\major', 'class_major_id');
	}

	public function getList()
	{
		$kq = classModel::join('course', 'course_id', '=', 'class_course_id')
			->join('teacher', 'teacher_id', '=', 'class_teacher_id')
			->join('major', 'major_id', '=', 'class_major_id')
			->paginate(15);
		return $kq;
	}

	public function CourseInClass($course_id)
	{
		$kq = $this->where('class_course_id', $course_id)->first();

		if(count($kq) <= 0)
			return false;
		return true;
	}

	public function checkTeacherInClass($teacher_id)
	{
		$kq = $this->where('class_teacher_id', $teacher_id)->first();
		if(count($kq) <= 0)
			return false;
		return true;
	}

	public function getClassId($class_code)
	{
		$kq = $this->where('class_code', $class_code)->first();
		return (count($kq) <= 0) ? 0 : $kq['class_id'];
	}

	public function getCodeById($id)
	{
		$kq = $this->find($id);
		return $kq['class_code'];
	}

	public function findId($id)
	{
		return classModel::find($id);
	}

	public function findClassByMajorId($id)
	{
		$kq = $this->where('class_major_id', $id)->first();
		if(count($kq) <= 0)
			return false;
		return true;
	}

	public function createClass($req)
	{
		$class = new classModel();
		$class->class_id = $req->class_id;
		$class->class_name = $req->class_name;
		$class->class_code = $req->class_code;
		$class->class_teacher_id = $req->class_teacher_id;
		$class->class_course_id = $req->class_course_id;
		$class->class_major_id = $req->class_major_id;
		$class->save();
	}

	public function deleteClass($req)
	{
		$obj_student = new student();
		if($obj_student->getStudentByClassId($req->class_id) == true)
			return false;
		$this->find($req->class_id)->delete();
		return true;
	}

	public function updateClass($req)
	{
		$class = classModel::find($req->class_id);
		$class->class_name = $req->class_name;
		$class->class_code = $req->class_code;
		$class->class_old_teacher_id = $class->class_teacher_id;
		$class->class_teacher_id = $req->class_teacher_id;
		$class->class_major_id = $req->class_major_id;
		$class->class_course_id = $req->class_course_id;
		if($req->class_old_teacher_id != "-1")
		{$class->class_old_teacher_id = $req->class_old_teacher_id;}

		$class->save();
	}


	public function searchClass($req)
	{

		if($req->types == "md")
		{
			$kq = classModel::join('course', 'course_id', '=', 'class_course_id')
			->join('teacher', 'teacher_id', '=', 'class_teacher_id')
			->join('major', 'major_id', '=', 'class_major_id')
			->where('teacher_fullname', 'like', '%'.$req->key.'%')
			->orWhere('class_name','like', '%'.$req->key.'%')
			->orWhere('class_code','like', '%'.$req->key.'%')
			->orWhere('course_name','like', '%'.$req->key.'%')
			->orWhere('course_code','like', '%'.$req->key.'%')
			->orWhere('teacher_fullname','like', '%'.$req->key.'%')
			->orWhere('teacher_code','like', '%'.$req->key.'%')
			->orWhere('major_name','like', '%'.$req->key.'%')
			->paginate(15);
		}
		else
		{
			$kq = classModel::join('course', 'course_id', '=', 'class_course_id')
			->join('teacher', 'teacher_id', '=', 'class_teacher_id')
			->join('major', 'major_id', '=', 'class_major_id')
			->where($req->types, 'like', '%'.$req->key.'%')
			->paginate(15);
		}
		return $kq;
	}

	public function getStudentInClassId($class_id)
	{
		$kq = classModel::join('student', 'student_class_id', 'class_id')
		->where('student_class_id', $class_id)->get();
		return $kq;
	}

	public function getClassFromCourseId($id)
	{
		$kq = classModel::join('course', 'course_id', 'class_course_id')
		->where('class_course_id', $id)->get();
		return $kq;
	}
	
		//==============================Excel =============================\\
	/**
     * Lấy những học sinh thuộc class_code
     * @return string
     */
	public function getStudentsByClassCode($array, $id)
	{
		$kq = [];
		for($i = 0; $i < count($array); $i++)
		{
			$class = $array[$i][$id];
			$temp = $this->where('class_code', $class)->first();
			if(count($temp) > 0) { $kq[] = $array[$i]; }
		}
		return $kq;
	}

	public function conVertToArrayTableClass($array, Request $req)
	{
		$obj_major = new major();
		$obj_course = new course();
		$kq = [];
		for($i = 0; $i < count($array); $i++)
		{
			$kq[$i]['teacher_role_id'] = 3;
			$kq[$i]['class_code'] = $array[$i][1];
			$kq[$i]['course_code'] = 'CDCQ-K'.mb_substr($array[$i][1], 2,2);
			$kq[$i]['major_symbol'] = mb_substr($array[$i][1], 4,2);
			$kq[$i]['teacher_code'] = $array[$i][2];
			$kq[$i]['teacher_fullname'] = $array[$i][3];
			$kq[$i]['class_name_number'] =  mb_substr($array[$i][1], 6);
			$kq[$i]['class_major_id'] = $obj_major->findMajorIdBySymbol(mb_substr($array[$i][1], 4,2));
			$kq[$i]['major_name'] = $obj_major->getMajorNameById($obj_major->findMajorIdBySymbol(mb_substr($array[$i][1], 4,2)));
			$kq[$i]['class_name'] = $obj_major->getClassName(mb_substr($array[$i][1], 4,2), mb_substr($array[$i][1], 6));
			$kq[$i]['class_course_id'] = $obj_course->checkCourseExitCreateNew('CDCQ-K'.mb_substr($array[$i][1], 2,2), $req);
		}
		return $kq;
	}

	public function addArrayJsonToDatabase($array, Request $req)
	{
		$obj_MyExcel = new MyExcel();
		$obj_Class = new classModel();
		$obj_major = new major();
		$obj_course = new course();
		$obj_teacher = new teacher();

		$exist = 0;
		for($i = 0; $i < count($array); $i++)
		{

			$teacher_check = $obj_teacher->checkTeacherExist($array[$i]['teacher_code']);
			if($teacher_check)
			{
				if(!$this->checkClassExist($array[$i]['class_code']))
				{
					$array[$i]['class_teacher_id'] = $obj_teacher->getTeacherIdByTeacherCode($array[$i]['teacher_code']);
					$req->query->add($array[$i]);
					$this->createClass($req);
				}
			}
			else
			{
				$req->query->add($array[$i]);
				$teacher_id = $obj_teacher->createTeacher($req);
				if(!$this->checkClassExist($array[$i]['class_code']))
				{
					$array[$i]['class_teacher_id'] = $teacher_id;
					$req->query->add($array[$i]);
					$this->createClass($req);
				}
			}
		}
	}

	public function checkClassExist($class_code)
	{
		$kq = $this->where('class_code', $class_code)->first();
		if(count($kq) <= 0)
			return false;
		return true;
	}




	//============================== End Excel =============================\\

	//======================= USER Function
	public function getClassManage($id_teacher)
	{
		return classModel::where('class_teacher_id', $id_teacher)->paginate(15);
	}
	public function countClassDangQuanLy($teacher_id)
	{
		$kq = $this->where('class_teacher_id', $teacher_id)->get();
		return count($kq);
	}

	public function countAllClass()
	{
		$kq = $this->all();
		return count($kq);
	}

}
