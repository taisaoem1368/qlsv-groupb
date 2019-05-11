<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Models\student;
use App\Http\Models\teacher;
use App\Http\Models\classModel;
use App\Http\Models\discipline;
use App\Http\Models\major;

use Auth;
date_default_timezone_set('Asia/Ho_Chi_Minh'); 

class disciplinary_information extends Model
{
    protected $table = 'disciplinary_information';
	public $primaryKey = 'di_id';

	public function getDI_Student() {
		return $this->belongsTo('App\Http\Models\student', 'di_student_id');
	}

	public function getDI_Class() {
		return $this->belongsTo('App\Http\Models\student', 'di_student_id');
	}

	public function getAll()
	{
		$kq = $this->join('student', 'di_student_id', '=', 'student_id')
			->join('class', 'student_class_id', '=', 'class_id')
			->join('course', 'class_course_id', '=', 'course_id')
			->join('discipline', 'di_discipline_id', 'discipline_id')
			->join('major', 'class_major_id', 'major_id')
			->where('di_delete', 1)
			->get();
		return $kq;
	}

	public function checkDI($discipline_id)
	{
		$kq = $this->where('di_discipline_id', $discipline_id)->first();
        if(count($kq) <= 0)
            return false;
        return true;
	}

	public function findDiByStudentId($id)
	{
		$check = $this->where('di_student_id', $id)->first();
		if(count($check) <= 0)
			return false;
		return true;
	}

	public function findId($id)
	{
		$kq = disciplinary_information::where('di_id', $id)
		->join('student', 'di_student_id', '=', 'student_id')
		->join('class', 'student_class_id', '=', 'class_id')
		->join('discipline', 'di_discipline_id', '=', 'discipline_id')
		->join('course', 'class_course_id', '=', 'course_id')
		->join('major', 'class_major_id', 'major_id')
		->first();
		return $kq;
	}

	public function createDI($req)
	{
		$di = new disciplinary_information();
		$di->di_student_id = $req->di_student_id;
		$di->di_TBC = $req->di_TBC;
		$di->di_TCTL = $req->di_TCTL;
		$di->di_TC_debt = $req->di_TC_debt;
		$di->di_TBCTL = $req->di_TBCTL;
		$di->di_DTB10 = $req->di_DTB10;
		$di->di_student_year = $req->di_student_year;
		$di->di_teacher_confirm = $req->di_teacher_confirm;
		$di->di_falcuty_confirm = $req->di_falcuty_confirm;
		$di->di_discipline_id = $req->di_discipline_id;
		$di->di_note = $req->di_note;
		$di->di_dicision = $req->di_dicision;
		$di->di_semester = $req->di_semester;
		$di->di_year = $req->di_year;
		$di->di_last_result = $req->di_last_result;
		$di->di_admin_edit_code = Auth::user()->user_teacher_code;
		$di->di_admin_edit_time = date('Y-m-d H:i:s');
		$di->di_delete = 1;
		$di->save();
	}

	public function updateDI($req)
	{
		
		$di = $this->find($req->di_id);
		$di->di_TBC = $req->di_TBC;
		$di->di_TCTL = $req->di_TCTL;
		$di->di_TC_debt = $req->di_TC_debt;
		$di->di_TBCTL = $req->di_TBCTL;
		$di->di_DTB10 = $req->di_DTB10;
		$di->di_student_year = $req->di_student_year;
		$di->di_teacher_confirm = $req->di_teacher_confirm;
		$di->di_falcuty_confirm = $req->di_falcuty_confirm;
		$di->di_discipline_id = $req->di_discipline_id;
		$di->di_note = $req->di_note;
		$di->di_dicision = $req->di_dicision;
		$di->di_semester = $req->di_semester;
		$di->di_year = $req->di_year;
		$di->di_last_result = $req->di_last_result;
		$di->di_admin_edit_code = Auth::user()->user_teacher_code;
		$di->di_admin_edit_time = date('Y-m-d H:i:s');
		$di->di_delete = 1;
		$di->save();
	}


	public function deleteDI($req)
	{
		$student = $this->find($req->di_id);
		$student->di_delete = 0;
		$di->di_admin_edit_code = Auth::user()->user_teacher_code;
		$di->di_admin_edit_time = date('Y-m-d H:i:s');
		$student->save();
	}

	public function getAllDataNew()
	{
		$data = $this
		->join('student', 'di_student_id', '=', 'student_id')
		->join('class', 'student_class_id', '=', 'class_id')
		->join('course', 'class_course_id', '=', 'course_id')
		->join('discipline', 'di_discipline_id', 'discipline_id')
		->join('major', 'class_major_id', 'major_id')
		->where('di_semester', $this->returnSemesterMax())
		->where('di_year', $this->returnYearMax())
		->where('di_delete', 1)
		->paginate(15);
		return $data;
	}

	public function returnYearMax()
	{
		$kq = $this->max('di_year');
		if(!isset($kq))
			return 1990;
		return $kq;
	}

	public function returnSemesterMax()
	{
		$year = $this->max('di_year');
		$check = $this->where('di_semester', 2)->where('di_year', $year)->first();
		if(count($check) <= 0)
			return 1;
		return 2;
	}

	public function userUpdate(Request $req)
	{
		$di = disciplinary_information::find($req->di_id);
		$di->di_last_result = $di->di_teacher_confirm;
		$di->di_teacher_confirm = $req->di_teacher_confirm;
		$di->save();
	}

	public function getAdminSearch($req)
	{
		$key = $req->key;
		$type = $req->types;
		$hocky = $req->hocky;
		$nam = $req->nam;
		if($type == "md")
		{
			$kq = disciplinary_information::join('student', 'di_student_id', '=', 'student_id')
			->join('class', 'student_class_id', '=', 'class_id')
			->join('discipline', 'di_discipline_id', 'discipline_id')
			->join('major', 'class_major_id', 'major_id')
			->where(function($query) use ($key) {
				$query->where('class_code', 'like', '%'.$key.'%')
				->orWhere('student_fullname', 'like', '%'.$key.'%')
				->orWhere('student_code', 'like', '%'.$key.'%');
			})
			->where('di_delete', 1)
			->where('di_semester', $hocky)
			->where('di_year', $nam)
			->paginate(15);
		}
		else if($type == "cph")
		{
			$kq = disciplinary_information::join('student', 'di_student_id', '=', 'student_id')
			->join('class', 'student_class_id', '=', 'class_id')
			->join('discipline', 'di_discipline_id', 'discipline_id')
			->join('major', 'class_major_id', 'major_id')
			->where(function($query) {
				$query->where('di_teacher_confirm', '')
				->orWhere('di_teacher_confirm', null);
			})
			->where('di_delete', 1)
			->where('di_semester', $hocky)
			->where('di_year', $nam)
			->paginate(15);
		}
		else
		{
			$kq = disciplinary_information::join('student', 'di_student_id', '=', 'student_id')
			->join('class', 'student_class_id', '=', 'class_id')
			->join('discipline', 'di_discipline_id', 'discipline_id')
			->join('major', 'class_major_id', 'major_id')
			->where($type, 'like', '%'.$key.'%')
			->where('di_delete', 1)
			->where('di_semester', $hocky)
			->where('di_year', $nam)
			->paginate(15);
		}
		
		return $kq;
	}


	
	public function convertToDisciplinary($array, $di_dicision, $di_semester, $di_year, $req)
	{
		$obj_discipline = new discipline();
		$obj_major = new major();
		$obj_class = new classModel();
		$obj_student = new student();

		$kq = [];

		for($i = 0; $i < count($array); $i++)
		{
			$kq[$i]['student_code'] = $array[$i][0];
			$kq[$i]['student_name'] = $array[$i][1].' '.$array[$i][2];
			$kq[$i]['student_birth'] = $array[$i][3];
			$kq[$i]['student_level_edu'] = $array[$i][4];
			$kq[$i]['student_type_edu'] = $array[$i][5];
			$kq[$i]['class_code'] = $array[$i][6];
			$kq[$i]['class_id'] = $obj_class->getClassId($array[$i][6]);
			$kq[$i]['major_id'] = $obj_major->getMajorId($array[$i][7]);
			$kq[$i]['major_name'] = $obj_major->getMajorName($array[$i][7]);
			$kq[$i]['di_TBC'] = $array[$i][9];
			$kq[$i]['di_TCTL'] = $array[$i][10];
			$kq[$i]['di_TC_debt'] = $array[$i][11];
			$kq[$i]['di_TBCTL'] = $array[$i][12];
			$kq[$i]['di_DTB10'] = $array[$i][13];
			$kq[$i]['di_student_year'] = $array[$i][14];
			$kq[$i]['di_falcuty_confirm'] = $array[$i][15];
			$kq[$i]['di_note'] = $array[$i][18];
			$kq[$i]['di_last_result'] = $array[$i][19];
			$kq[$i]['di_dicision'] = $di_dicision;
			$kq[$i]['di_semester'] = $di_semester;
			$kq[$i]['di_year'] = $di_year;
			$kq[$i]['discipline_id'] = $obj_discipline->getDisciplineId($array[$i][16]);
			$kq[$i]['discipline_name'] = $obj_discipline->getDisciplineName($array[$i][16]);
			if($obj_discipline->getDisciplineId($array[$i][16]) == 0)
			{
				$string = $array[$i][16];
				if(strlen($array[$i][16]) <= 0)
					$string = 'Đầu vào tình trạng của sinh viên bị trống';
				$req->query->add(array('discipline_name' => $string));
				$kq[$i]['discipline_id'] = $obj_discipline->createDiscipline($req);
			}
		}

		return $kq;
	}

	public function changeInformationInJson($kq, $req, $nameFile)
	{
		$obj_discipline = new discipline();
		$obj_major = new major();
		$obj_class = new classModel();
		$obj_MyExcel = new MyExcel();

		$i = $req->edit_id;
		$kq[$i]['student_code'] = $req->student_code;
		$kq[$i]['student_name'] = $req->student_name;
		$kq[$i]['student_birth'] = $req->student_birth;
		$kq[$i]['student_level_edu'] = $req->student_level_edu;
		$kq[$i]['student_type_edu'] = $req->student_type_edu;
		$kq[$i]['class_id'] = $req->class_id;
		$kq[$i]['class_code'] = $obj_class->getCodeById($req->class_id);
		$kq[$i]['major_id'] = $req->major_id;
		$kq[$i]['major_name'] = $obj_major->getMajorNameById($req->major_id);
		$kq[$i]['di_TBC'] = $req->di_TBC;
		$kq[$i]['di_TCTL'] = $req->di_TCTL;
		$kq[$i]['di_TC_debt'] = $req->di_TC_debt;
		$kq[$i]['di_TBCTL'] = $req->di_TBCTL;
		$kq[$i]['di_DTB10'] = $req->di_DTB10;
		$kq[$i]['di_student_year'] = $req->di_student_year;
		$kq[$i]['di_falcuty_confirm'] = $req->di_falcuty_confirm;
		$kq[$i]['discipline_id'] = $req->discipline_id;
		$kq[$i]['discipline_name'] = $obj_discipline->getDisciplineIdNameById($req->discipline_id);
		$kq[$i]['di_note'] = $req->di_note;
		$kq[$i]['di_last_result'] = $req->di_last_result;
		$kq[$i]['di_dicision'] = $req->di_dicision;
		$kq[$i]['di_semester'] = $req->di_semester;
		$kq[$i]['di_year'] = $req->di_year;
		$obj_MyExcel->wirteToFile($nameFile, $kq);
		return $kq;
	}



	public function addArrayToDatabaseTTKLQuestion($array, Request $req)
	{
		$obj_student = new student();
		for($i = 0; $i < count($array); $i++) {
			$checkStudent = $obj_student->getStudentId($array[$i]['student_code']);
			if($checkStudent == 0)
			{
				$this->removeParameter($req);
				$req->query->add($obj_student->getStudentValue($array, $i));

				$student_id = $obj_student->createStudent($req);
			}
			else
			{
				$student_id = $checkStudent;
				$student_update = $this->StudentUpdateValue($array, $i, $student_id);
				$this->removeParameter($req);
				$req->query->add($student_update);
				$obj_student->updateStudentQ($req);
			}
			$this->removeParameter($req);
			$req->query->add($this->DIValueInput($array, $i, $student_id));

			$this->createDI($req);
		}
	}

	public function addArrayToDatabaseTTKLOverride($array, Request $req)
	{
		$obj_student = new student();
		for($i = 0; $i < count($array); $i++) {
		
			$checkStudent = $obj_student->getStudentId($array[$i]['student_code']);
			if($checkStudent == 0)
			{
				$this->removeParameter($req);
				$req->query->add($obj_student->getStudentValue($array, $i));

				$student_id = $obj_student->createStudent($req);
			}
			else
			{

				$student_id = $checkStudent;
				$student_update = $this->StudentUpdateValue($array, $i, $student_id);
				$student_update['student_id'] = $student_id;
				
				$this->removeParameter($req);
				$req->query->add($student_update);
				$update = $obj_student->updateStudent($req);

				
			}

			$check = $this->where('di_student_id', $student_id)->where('di_semester', $array[$i]['di_semester'])->where('di_year', $array[$i]['di_year'])->first();
			if(count($check) <= 0)
			{
				$this->removeParameter($req);
				$req->query->add($this->DIValueInput($array, $i, $student_id));
				$this->createDI($req);
			}
			else
			{
				$this->removeParameter($req);
				$req->query->add($this->DIValueInputUpdate($array, $i, $student_id, $check['di_id']));
				$this->updateDI($req);
			}
		}
	}

	public function removeParameter($req)
	{
		$array = array_keys($req->query());
		foreach($array as $v)
		{
			$req->request->remove($v);
		}
	}

	public function StudentUpdateValue($array, $i, $student_id)
	{

		$student = array(
			'student_id' => $student_id,
			'student_code' => $array[$i]['student_code'],
			'student_fullname' => $array[$i]['student_name'],
			'student_birth' => $array[$i]['student_birth'],
			'student_level_edu' => $array[$i]['student_level_edu'],
			'student_type_edu' => $array[$i]['student_type_edu'],
			'student_class_id' => $array[$i]['class_id'],
		);
		return $student;
	}

	public function DIValueInputUpdate($array, $i, $student_id, $di_id)
	{
		$di_update = array(
			'di_id' => $di_id,
			'di_student_id' => $student_id,
			'di_TBC' => $array[$i]['di_TBC'],
			'di_TCTL' => $array[$i]['di_TCTL'],
			'di_TC_debt' => $array[$i]['di_TC_debt'],
			'di_TBCTL' => $array[$i]['di_TBCTL'],
			'di_DTB10' => $array[$i]['di_DTB10'],
			'di_student_year' => $array[$i]['di_student_year'],
			'di_teacher_confirm' => '',
			'di_falcuty_confirm' => $array[$i]['di_falcuty_confirm'],
			'di_discipline_id' => $array[$i]['discipline_id'],
			'di_note' => $array[$i]['di_note'],
			'di_dicision' => $array[$i]['di_dicision'],
			'di_semester' => $array[$i]['di_semester'],
			'di_year' => $array[$i]['di_year'],
			'di_last_result' => $array[$i]['di_last_result'],
		);
		return $di_update;
	}

	public function DIValueInput($array, $i, $student_id)
	{
		$di_new = array(
			'di_student_id' => $student_id,
			'di_TBC' => $array[$i]['di_TBC'],
			'di_TCTL' => $array[$i]['di_TCTL'],
			'di_TC_debt' => $array[$i]['di_TC_debt'],
			'di_TBCTL' => $array[$i]['di_TBCTL'],
			'di_DTB10' => $array[$i]['di_DTB10'],
			'di_student_year' => $array[$i]['di_student_year'],
			'di_teacher_confirm' => '',
			'di_falcuty_confirm' => $array[$i]['di_falcuty_confirm'],
			'di_discipline_id' => $array[$i]['discipline_id'],
			'di_note' => $array[$i]['di_note'],
			'di_dicision' => $array[$i]['di_dicision'],
			'di_semester' => $array[$i]['di_semester'],
			'di_year' => $array[$i]['di_year'],
			'di_last_result' => $array[$i]['di_last_result'],
		);
		return $di_new;
	}


	public function identicalCheckTTKL($array)
	{
		$obj_student = new student();
		$array_result = [];
		
		for($i = 0; $i < count($array); $i++)
		{

			$student_id = $obj_student->getStudentId($array[$i]['student_code']);

			$check = $this->where('di_student_id', $student_id)->where('di_semester', $array[$i]['di_semester'])->where('di_year', $array[$i]['di_year'])->first();

			if(count($check) > 0)
			{
				$array_result += $array[$i];
			}
		}
	
		return $array_result;
	}

	public function convertArrayInputToArrayValue($array, $number)
	{
		$array_localti = $array;
		for ($i = 0; $i < count($array_localti); $i++) {
			if($array_localti[$i] == 'student_fname')
			{
				$array1[$i] = 'Họ';
				$array2[$i] = 'student_fullname';
			} else if ($array_localti[$i] == 'student_lname')
			{
				$array1[$i] = 'Tên';
				$array2[$i] = 'student_fullname';
			} else {

				$array2[$i] = $array_localti[$i];
				if($array_localti[$i] == 'STT')
					$array1[$i] = 'STT';
				else if($array_localti[$i] == 'student_code')
					$array1[$i] = 'MSSV';
				else if($array_localti[$i] == 'student_birth')
					$array1[$i] = 'Ngày sinh';
				else if($array_localti[$i] == 'student_level_edu')
					$array1[$i] = 'Bậc đào tạo';
				else if($array_localti[$i] == 'student_type_edu')
					$array1[$i] = 'Loại hình đào tạo';
				else if($array_localti[$i] == 'class_code')
					$array1[$i] = 'Mã lớp SV';
				else if($array_localti[$i] == 'major_name')
					$array1[$i] = 'Ngành học';
				else if($array_localti[$i] == 'di_TBC')
					$array1[$i] = 'Điểm TBC';
				else if($array_localti[$i] == 'di_TCTL')
					$array1[$i] = 'Số TCTL';
				else if($array_localti[$i] == 'di_TC_debt')
					$array1[$i] = 'Số TC còn nợ';
				else if($array_localti[$i] == 'di_TBCTL')
					$array1[$i] = 'Điểm TBCTL';
				else if($array_localti[$i] == 'di_DTB10')
					$array1[$i] = 'ĐTB10';
				else if($array_localti[$i] == 'di_student_year')
					$array1[$i] = 'SV năm thứ';
				else if($array_localti[$i] == 'di_falcuty_confirm')
					$array1[$i] = 'Phản hồi Khoa';
				else if($array_localti[$i] == 'discipline_name')
					$array1[$i] = 'Tình trạng';
				else if($array_localti[$i] == 'di_note')
					$array1[$i] = 'Ghi chú';
				else if($array_localti[$i] == 'di_last_result')
					$array1[$i] = 'Kết quả trước';
				else
				{
					$array2[$i] = 'di_last_result';
					$array1[$i] = 'Kết quả trước';
				}
			}
		}
		if($number == 1)
			return $array1;
		return $array2;
	}

	public function findValueExport($hocky, $nam)
	{
		$kq = disciplinary_information::join('student', 'di_student_id', '=', 'student_id')
			->join('class', 'student_class_id', '=', 'class_id')
			->join('course', 'class_course_id', '=', 'course_id')
			->join('major', 'class_major_id', 'major_id')
			->join('discipline', 'di_discipline_id', 'discipline_id')
			->where('di_semester', $hocky)
			->where('di_delete', 1)
			->where('di_year', $nam)->get();
		return $kq;
	}


	//=========================Function User ============================\\

	public function getUserList($id_teacher, $id_class = null)
	{
		//Tìm tất cả các lớp
		if($id_class == null)
		{
			$kq = $this->join('student', 'di_student_id', '=', 'student_id')
			->join('class', 'student_class_id', '=', 'class_id')
			->join('major', 'class_major_id', '=', 'major_id')
			->join('discipline', 'di_discipline_id', '=', 'discipline_id')
			->where('class_teacher_id', $id_teacher)
			->paginate(10);

		} else //Tìm lớp chỉ định
		{
			$kq = $this->join('student', 'di_student_id', '=', 'student_id')
			->join('class', 'student_class_id', '=', 'class_id')
			->join('major', 'class_major_id', '=', 'major_id')
			->join('discipline', 'di_discipline_id', '=', 'discipline_id')
			->where('class_teacher_id', $id_teacher)
			->where('class_id', $id_class)
			->paginate(10);
		}
		return $kq;	
	}

	public function updatePhanHoi($id_teacher, $req)
	{
		$di = $this->find($req->di_id);
		$student = student::find($di->di_student_id);
		$class = classModel::find($student->student_class_id);
		if($id_teacher != $class->class_teacher_id)
		{
			return false;
		}
		$di->di_teacher_confirm = $req->di_teacher_confirm;
		$di->save();
		return true;
	}

	public function getSearch($req)
	{
		$obj_teacher = new teacher();
		$teacher = $obj_teacher->getTeacherId(Auth::user()->user_teacher_code);
		$key = $req->key;
		$type = $req->types;
		$hocky = $req->hocky;
		$nam = $req->nam;
		if($type == "md")
		{
			//Tìm kiếm mặc định
			$kq = disciplinary_information::join('student', 'di_student_id', '=', 'student_id')
			->join('class', 'student_class_id', '=', 'class_id')
			->join('discipline', 'di_discipline_id', 'discipline_id')
			->join('major', 'class_major_id', 'major_id')
			->where('class_teacher_id', $teacher->teacher_id)
			->where(function($query) use ($key) {
				$query->where('class_code', 'like', '%'.$key.'%')
				->orWhere('student_fullname', 'like', '%'.$key.'%')
				->orWhere('student_code', 'like', '%'.$key.'%');
			})
			->where('di_semester', $hocky)
			->where('di_year', $nam)
			->paginate(10);
		}
		else if($type == "cph")
		{
			$kq = disciplinary_information::join('student', 'di_student_id', '=', 'student_id')
			->join('class', 'student_class_id', '=', 'class_id')
			->join('discipline', 'di_discipline_id', 'discipline_id')
			->join('major', 'class_major_id', 'major_id')
			->where('class_teacher_id', $teacher->teacher_id)
			->where('di_semester', $hocky)
			->where('di_year', $nam)
			->where(function($query) {
				$query->where('di_teacher_confirm', '')
				->orWhere('di_teacher_confirm', null);
			})
			->paginate(10);
		}
		else
		{
			$kq = disciplinary_information::join('student', 'di_student_id', '=', 'student_id')
			->join('class', 'student_class_id', '=', 'class_id')
			->join('discipline', 'di_discipline_id', 'discipline_id')
			->join('major', 'class_major_id', 'major_id')
			->where('class_teacher_id', $teacher->teacher_id)
			->where($type, 'like', '%'.$key.'%')
			->where('di_semester', $hocky)
			->where('di_year', $nam)
			->paginate(10);
		}

		return $kq;
	}

	public function getConfirmed($id_teacher)
	{
		$kq = disciplinary_information::join('student', 'di_student_id', '=', 'student_id')
			->join('class', 'student_class_id', '=', 'class_id')
			->where('class_teacher_id', $id_teacher)
			->where('di_teacher_confirm', '<>', null)

			->paginate(10);
		return $kq;
	}

	public function countSoSinhVienBiKyLuat($teacher_id)
	{
		$kq = $this->join('student', 'di_student_id', '=', 'student_id')
			->join('class', 'student_class_id', '=', 'class_id')
			->where('class_teacher_id', $teacher_id)
			->where('di_semester', $this->returnSemesterMax())
			->where('di_year', $this->returnYearMax())
			->get();
		return count($kq);
	}

	public function countSoSinhVienBiKyLuatAll()
	{
		$kq = $this->join('student', 'di_student_id', '=', 'student_id')
			->join('class', 'student_class_id', '=', 'class_id')
			->where('di_semester', $this->returnSemesterMax())
			->where('di_year', $this->returnYearMax())
			->get();
		return count($kq);
	}

	public function countSoSinhVienBiKyLuatChuaComfirm($teacher_id)
	{
		$kq = $this->join('student', 'di_student_id', '=', 'student_id')
			->join('class', 'student_class_id', '=', 'class_id')
			->where('class_teacher_id', $teacher_id)
			->where('di_semester', $this->returnSemesterMax())
			->where('di_year', $this->returnYearMax())
			->where(function($query) {
				$query->where('di_teacher_confirm', '')
				->orWhere('di_teacher_confirm', null);
			})
			->get();
		return count($kq);
	}

	public function countSoSinhVienBiKyLuatChuaComfirmAll()
	{
		$kq = $this->join('student', 'di_student_id', '=', 'student_id')
			->join('class', 'student_class_id', '=', 'class_id')
			->where('di_semester', $this->returnSemesterMax())
			->where('di_year', $this->returnYearMax())
			->where(function($query) {
				$query->where('di_teacher_confirm', '')
				->orWhere('di_teacher_confirm', null);
			})
			->get();
		return count($kq);
	}

	public function countSoSinhVienBiKyLuatDaComfirm($teacher_id)
	{
		$kq = $this->join('student', 'di_student_id', '=', 'student_id')
			->join('class', 'student_class_id', '=', 'class_id')
			->where('class_teacher_id', $teacher_id)
			->where('di_semester', $this->returnSemesterMax())
			->where('di_year', $this->returnYearMax())
			->where('di_teacher_confirm', '<>','')
			->where('di_teacher_confirm', '<>', null)
			->get();
		return count($kq);
	}

	public function countSoSinhVienBiKyLuatDaComfirmAll()
	{
		$kq = $this->join('student', 'di_student_id', '=', 'student_id')
			->join('class', 'student_class_id', '=', 'class_id')
			->where('di_semester', $this->returnSemesterMax())
			->where('di_year', $this->returnYearMax())
			->where('di_teacher_confirm', '<>','')
			->where('di_teacher_confirm', '<>', null)
			->get();
		return count($kq);
	}

	public function updateSDQ($req)
	{
		$all = $this->where('di_semester', $req->di_semester)
		->where('di_year', $req->di_year)->get();
		for($i = 0; $i < count($all); $i++)
		{
			$change = $all[$i];
			$change->di_dicision = $req->di_dicision;
			$change->save();
		}
	}


}
