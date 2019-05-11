<?php
namespace App\Http\Models;

date_default_timezone_set('Asia/Ho_Chi_Minh');
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Models\major;
use App\Http\Models\classModel;
use App\Http\Models\absent;
use App\Exceptions\CustomExceptions;

class student extends Model
{
    protected $table = 'student';
	public $primaryKey = 'student_id';
	public $timestamps = true;


    //Quyen function
    public function getStudentId($code)
    {
        $kq = $this->where('student_code', $code)->first();
        return (count($kq) <= 0) ? 0 : $kq['student_id'];
    }

    public function getStudentValue($array, $i)
    {
        $req = array(
        'student_class_id' => $array[$i]['class_id'],
        'student_fullname' => $array[$i]['student_name'],
        'student_code' => $array[$i]['student_code'],
        'student_birth' => $array[$i]['student_birth'],
        'student_level_edu' => $array[$i]['student_level_edu'],
        'student_type_edu' => $array[$i]['student_type_edu'],
        );
        return $req;
    }

    public function getStudentByClassId($id)
    {
        $kq = $this->where('student_class_id', $id)->first();
        if(count($kq) <= 0)
            return false;
        return true;
    }

    public function postContactCVHT($student_id, $contact)
    {
        $student = $this->find($student_id);
        $student->student_contact = $contact;
        $student->save();
    }

    //Quyen function

     public function getComboboxAddScreen($id) {
        $obj_major = new major();
        $major = $obj_major
                ->get();
        if (@$id) {
            $obj_class = new classModel();
            $class = $obj_class
                    ->where('class_major_id', '=', $id)
                    ->orderby('class_name', 'asc')
                    ->get();

            return ['class' => $class, 'major' => $major];
        }

        return ['major' => $major];
    }

    public function getList() {
        return $this
                        ->leftjoin('class', 'student.student_class_id', '=', 'class.class_id')
                        ->leftjoin('major', 'class.class_major_id', '=', 'major.major_id')
                        ->paginate(10);
    }

    public function getStudent($id) {
        return $this
                        ->leftjoin('class', 'student.student_class_id', '=', 'class.class_id')
                        ->leftjoin('major', 'class.class_major_id', '=', 'major.major_id')
                        ->find($id);
    }

    public function search(Request $req) {
        $type = $req->types;

        if ($type == 'md') {
            $student = $this
                    ->leftjoin('class', 'student.student_class_id', '=', 'class.class_id')
                    ->join('major', 'class_major_id', 'major_id')
                    ->where('student_fullname', 'like', '%' . $req->key . '%')
                    ->orWhere('student_code', 'like', '%' . $req->key . '%')
                    ->orWhere('class_code', 'like', '%' . $req->key . '%')
                    ->paginate(10);
        } else {
            $student = $this
                    ->leftjoin('class', 'student.student_class_id', '=', 'class.class_id')
                    ->join('major', 'class_major_id', 'major_id')
                    ->where($type, 'like', '%' . $req->key . '%')
                    ->paginate(10);
        }
        return $student;
    }

    public function createStudent($req) {
        if (!@$req->student_fullname or !@$req->student_code)
            return false;
        $date = strtotime(str_replace('/', '-', $req->student_birth));
        $student_obj = new student();
        $student_obj->student_class_id = $req->student_class_id;
        $student_obj->student_fullname = $req->student_fullname;
        $student_obj->student_code = $req->student_code;
        $student_obj->student_birth = $date;
        $student_obj->student_level_edu = $req->student_level_edu;
        $student_obj->student_type_edu = $req->student_type_edu;
        if($req->student_contact != '')
        {
           $student_obj->student_contact = $req->student_contact; 
        }
        $student_obj->save();
        return $student_obj->student_id;
    }

    public function updateStudent($req) {
        $student = $this->find($req->student_id);
        if (!@$req->student_fullname or !@$req->student_code)
            return false;
        $date = strtotime(str_replace('/', '-', $req->student_birth));

        $student->student_fullname = $req->student_fullname;
        $student->student_code = $req->student_code;
        $student->student_birth = $date;
        $student->student_class_id = $req->student_class_id;
        $student->student_level_edu = $req->student_level_edu;
        $student->student_type_edu = $req->student_type_edu;
        if($req->student_contact != '')
        {
           $student_obj->student_contact = $req->student_contact; 
        }
        $student->save();
        return true;
    }

    // public function updateStudentQ($req) {

    //     $student = $this->find($req->student_id);
    //     $student->student_fullname = $req->student_fullname;
    //     $student->student_code = $req->student_code;
    //     $student->student_birth = strtotime($req->student_birth);
    //     $student->student_class_id = $req->student_class_id;
    //     $student->student_level_edu = $req->student_level_edu;
    //     $student->student_type_edu = $req->student_type_edu;
    //     $student->student_contact = $req->student_contact;
    //     $student->save();
    // }

    public function deleteStudent($id) {
        $obj_di = new disciplinary_information();
        $obj_ai = new absent();
        if(!$obj_di->findDiByStudentId($id) == true && !$obj_ai->checkIssetStudent($id) == true)
        {
            $this->find($id)->delete();
            return true; 
        }
        return false;
    }
}
