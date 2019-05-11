<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Models\discipline;
use App\Http\Models\student;

class absent extends Model
{
    protected $table = 'absent_information';
	public $primaryKey = 'ai_id';
	public $timestamps = false;

	public function getAllData()
	{
		$kq = $this->join('student', 'ai_student_id','student_id')
		->join('class', 'student_class_id', 'class_id')
		->join('discipline', 'ai_discipline_id', 'discipline_id')
		->join('major', 'class_major_id', 'major_id')
		->join('teacher', 'class_teacher_id', 'teacher_id')
		->where('ai_delete', 1)
		->where('ai_year', $this->returnYearMax())
		->where('ai_semester', $this->returnSemesterMax())
		->paginate(10);

		return $kq;
	}

	public function checkIssetStudent($student_id)
	{
		$kq = $this->where('ai_student_id', $student_id)->first();
		if(count($kq) <= 0)
			return false;
		return true;
	}

	public function findAbsent($id)
	{
		$kq = $this->where('ai_id', $id)
		->join('student', 'ai_student_id','student_id')
		->join('class', 'student_class_id', 'class_id')
		->join('discipline', 'ai_discipline_id', 'discipline_id')
		->join('major', 'class_major_id', 'major_id')
		->join('course', 'class_course_id', 'course_id')
		->first();
		return $kq;
	}

	public function checkIdExist($id)
	{
		$kq = $this->find($id);
		if(count($kq) <= 0)
			return false;
		return true;
	}

	public function createAbsent($req)
	{
		$absent = new absent();
		$absent->ai_student_id = $req->ai_student_id;
		$absent->ai_absences = $req->ai_absences;
		$absent->ai_discipline_id = $req->ai_discipline_id;
		$absent->ai_semester = $req->ai_semester;
		$absent->ai_year = $req->ai_year;
		$absent->ai_delete = 1;
		$absent->ai_teacher_code_edit = Auth::user()->user_teacher_code;
		$absent->ai_time_edit = date('Y-m-d H:i:s');
		$absent->save();
	}

	public function updateAbsent($req)
	{
		$absent = $this->find($req->ai_id);
		$absent->ai_absences = $req->ai_absences;
		$absent->ai_discipline_id = $req->ai_discipline_id;
		$absent->ai_semester = $req->ai_semester;
		$absent->ai_year = $req->ai_year;
		$absent->ai_delete = 1;
		$absent->ai_teacher_code_edit = Auth::user()->user_teacher_code;
		$absent->ai_time_edit = date('Y-m-d H:i:s');
		$absent->save();
	}

	public function deleteAbsent($req)
	{
		$absent = $this->find($req->ai_id);
		$absent->ai_delete = 0;
		$absent->ai_teacher_code_edit = Auth::user()->user_teacher_code;
		$absent->ai_time_edit = date('Y-m-d H:i:s');
		$absent->save();
	}

	public function getSearch($req)
	{
		$key = $req->key;
		$type = $req->types;
		$hocky = $req->hocky;
		$nam = $req->nam;

		if($type == "md")
		{
			$kq = $this->join('student', 'ai_student_id','student_id')
			->join('class', 'student_class_id', 'class_id')
			->join('discipline', 'ai_discipline_id', 'discipline_id')
			->join('major', 'class_major_id', 'major_id')
			->join('teacher', 'class_teacher_id', 'teacher_id')
			->where('ai_delete', 1)
			->where(function($query) use ($key) {
				$query->where('class_code', 'like', '%'.$key.'%')
				->orWhere('student_fullname', 'like', '%'.$key.'%')
				->orWhere('student_code', 'like', '%'.$key.'%');
			})
			->where('ai_semester', $hocky)
			->where('ai_year', $nam)
			->paginate(10);
		}
		else
		{
			$kq = $this->join('student', 'ai_student_id','student_id')
			->join('class', 'student_class_id', 'class_id')
			->join('discipline', 'ai_discipline_id', 'discipline_id')
			->join('major', 'class_major_id', 'major_id')
			->join('teacher', 'class_teacher_id', 'teacher_id')
			->where($type, 'like', '%'.$key.'%')
			->where('ai_delete', 1)
			->where('ai_semester', $hocky)
			->where('ai_year', $nam)
			->paginate(10);
		}
		
		return $kq;
	}

	public function getArrayAbsentJson($array, $req)
	{
		$obj_student = new student();

		$obj_discipline = new discipline();
		$obj_class = new classModel();
		$kq = [];
		$ai_semester = $req->ai_semester;
		$ai_year =$req->ai_year;
		for($i = 0; $i < count($array); $i++)
		{
			$kq[$i]['student_code'] = $array[$i][2];
			$kq[$i]['student_name'] = $array[$i][3];
			$kq[$i]['class_code'] = $array[$i][4];
			$kq[$i]['class_id'] = $obj_class->getClassId($array[$i][4]);
			$kq[$i]['ai_absences'] = $array[$i][5];
			$kq[$i]['ai_semester'] =  $ai_semester;
			$kq[$i]['ai_year'] = $ai_year;
			$kq[$i]['ai_delete'] = 1;
			$kq[$i]['ai_discipline_id'] = $obj_discipline->getDisciplineId($array[$i][6]);
			$kq[$i]['discipline_name'] = $obj_discipline->getDisciplineName($array[$i][6]);
			if($obj_discipline->getDisciplineId($array[$i][6]) == 0)
			{
				$string = $array[$i][6];
				if(strlen($array[$i][6]) <= 0)
					$string = 'Đầu vào tình trạng của sinh viên bị trống';
				$req->query->add(array('discipline_name' => $string));
				$kq[$i]['ai_discipline_id'] = $obj_discipline->createDiscipline($req);
				$kq[$i]['discipline_name'] = $obj_discipline->getDisciplineIdNameById($kq[$i]['ai_discipline_id']);
			}
		}
		return $kq;
	}



	public function checkIssetData($array)
	{
		$obj_student = new student();
		for($i = 0; $i < count($array); $i++)
		{
			$student_id = $obj_student->getStudentId($array[$i]['student_code']);
			$kq = $this->where('ai_student_id', $student_id)
			->where('ai_semester', $array[$i]['ai_semester'])
			->where('ai_year', $array[$i]['ai_year'])
			->first();
			if(count($kq) > 0)
				return true;
		}
		return false;
	}

	public function getIdAbsent($student_id, $ai_semester, $ai_year)
	{
		$kq = $this->where('ai_student_id', $student_id)
					->where('ai_semester', $ai_semester)
					->where('ai_year', $ai_year)
					->first();
		return (count($kq) <= 0) ? 0 : $kq['ai_id'];
	}

	public function addJsonDataToDatabase($array, $req)
	{
		$obj_student = new student();
		for($i = 0; $i < count($array); $i++)
		{
	
			$ai_student_id = $obj_student->getStudentId($array[$i]['student_code']);
			$ai_semester = $array[$i]['ai_semester'];
			$ai_year = $array[$i]['ai_year'];
			$id_check = $this->getIdAbsent($ai_student_id, $ai_semester, $ai_year);

			if($id_check != 0)
			{

				$array[$i]['ai_id'] = $id_check;
				$req->query->add($array[$i]);
				$this->updateAbsent($req);
			}
		
			else
			{
			
				$student_id = $obj_student->getStudentId($array[$i]['student_code']);
				if($student_id == 0)
				{
					$req->query->add($this->studentValueCreate($array[$i]));
					$student_id = $obj_student->createStudent($req);
				}
				$array[$i]['ai_student_id'] = $student_id;
				$req->query->add($array[$i]);
				$this->createAbsent($req);
			}
		}
	
	}

	public function studentValueCreate($array)
	{
        $student = array (
        	'student_class_id' => $array['class_id'],
        	'student_fullname' => $array['student_name'],
        	'student_code' => $array['student_code'],
        );
        return $student;
	}

	public function returnYearMax()
	{
		$kq = $this->max('ai_year');
		if(!isset($kq))
			return 1990;
		return $kq;
	}

	public function returnSemesterMax()
	{
		$year = $this->max('ai_year');
		$check = $this->where('ai_semester', 2)->where('ai_year', $year)->first();
		if(count($check) <= 0)
			return 1;
		return 2;
	}

	//================== Chức năng User (Giáo Viên/ Cố Vấn Học Tập) ============\\\

	public function getStudentByCVHT($teacher_code)
	{

		$kq = $this->join('student', 'ai_student_id','student_id')
		->join('class', 'student_class_id', 'class_id')
		->join('discipline', 'ai_discipline_id', 'discipline_id')
		->join('major', 'class_major_id', 'major_id')
		->join('teacher', 'class_teacher_id', 'teacher_id')
		->where('teacher_code', $teacher_code)
		->where('ai_delete', 1)
		->where('ai_year', $this->returnYearMax())
		->where('ai_semester', $this->returnSemesterMax())
		->paginate(10);
		return $kq;
	}

	public function getStudentSearchByCVHT($req, $teacher_code)
	{
		$key = $req->key;
		$type = $req->types;
		$hocky = $req->hocky;
		$nam = $req->nam;

		if($type == "md")
		{
			$kq = $this->join('student', 'ai_student_id','student_id')
			->join('class', 'student_class_id', 'class_id')
			->join('discipline', 'ai_discipline_id', 'discipline_id')
			->join('major', 'class_major_id', 'major_id')
			->join('teacher', 'class_teacher_id', 'teacher_id')
			->where('ai_delete', 1)
			->where(function($query) use ($key) {
				$query->where('class_code', 'like', '%'.$key.'%')
				->orWhere('student_fullname', 'like', '%'.$key.'%')
				->orWhere('student_code', 'like', '%'.$key.'%');
			})
			->where('ai_semester', $hocky)
			->where('ai_year', $nam)
			->where('teacher_code', $teacher_code)
			->paginate(10);
		}
		else
		{
			$kq = $this->join('student', 'ai_student_id','student_id')
			->join('class', 'student_class_id', 'class_id')
			->join('discipline', 'ai_discipline_id', 'discipline_id')
			->join('major', 'class_major_id', 'major_id')
			->join('teacher', 'class_teacher_id', 'teacher_id')
			->where('teacher_code', $teacher_code)
			->where($type, 'like', '%'.$key.'%')
			->where('ai_delete', 1)
			->where('ai_semester', $hocky)
			->where('ai_year', $nam)
			->paginate(10);
		}
		
		return $kq;
	}

}
