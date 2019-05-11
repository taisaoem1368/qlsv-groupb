<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Models\classModel;

class course extends Model
{
    protected $table = 'course';
	public $primaryKey = 'course_id';
	public $timestamps = false;

	public function getList() {
        return $this->paginate(10);
    }
    
    public function getCourseIdByCourseCode($course_code)
    {
        $kq = $this->where('course_code', $course_code)->first();
        return (count($kq) <= 0) ? 0 : $kq['course_id'];
    }
    
    public function search(Request $req) {
        $type = $req->types;
//        dd($type);
        if ($type == 'md') {
            $course = $this->where('course_name', 'like', '%' . $req->key . '%')
                    ->orWhere('course_code', 'like', '%' . $req->key . '%')
                    ->paginate(10);
        } else {
            $course = $this->where($type, 'like', '%' . $req->key . '%')
                    ->paginate(10);
        }
        return $course;
    }

    public function getCourse($id)
    {
        return $this->find($id);
    }

    public function checkCourseExitCreateNew($course_code, Request $req)
    {
        $check = $this->where('course_code', $course_code)->first();
        if(count($check) > 0)
            return $check['course_id'];
        $req->query->add(['course_code' => $course_code, 'course_name' => $course_code]);
        $course_id = $this->createCourseQ($req);
        return $course_id;
    }

    public function createCourseQ($req) {
            $course_obj = new course();
            $course_obj->course_name = $req->course_name;
            $course_obj->course_code = $req->course_code;
            $course_obj->save();
            return $course_obj->course_id;
    }
    // code chán quá @-@
    public function createCourse(Request $req) {
        $course_obj = new course();
        if (!@$req->course_code)
            return false;
        $course_obj->course_name = $req->course_name;
        $course_obj->course_code = $req->course_code;
        $course_obj->save();
        return true;
    }

    public function updateCourse(Request $req) {
        $course = $this->find($req->course_id);
        if (!@$req->course_code)
            return false;
        $course->course_name = $req->course_name;
        $course->course_code = $req->course_code;
        $course->save();
        return true;
    }

    public function deleteCourse($id) {

        $obj_class = new classModel();
        if($obj_class->CourseInClass($id))
            return false;
        $this->find($id)->delete();
        return true;
    }
}
