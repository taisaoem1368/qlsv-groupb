<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\course;

class CourseController extends Controller
{
    public function index()
	{
		$obj = new course();
		$course = $obj->getList();
		return view('admin.course.tables', ['course' => $course]);
	}

	public function getAddCourse()
	{
		return view('admin.course.add');
	}

	public function validateCourse($req)
	{
		$this->validate($req, [
			'course_name' => 'required',
			'course_code' => 'required',
		], [
			'course_code.required' => 'Mã khóa là bắt buộc',
			'course_name.required' => 'Tên khóa là bắt buộc',
		]);
	}

	public function postAddCourse(Request $req)
	{
		$this->validateCourse($req);
		$obj_course = new course();
		if (@$obj_course->createCourse($req)) {
            return redirect()->back()->with('success', 'Thêm mới thành công');
        } else {
            return redirect()->back()->with('message', 'Thêm mới thất bại');
        }
	}

	public function getEditCourse($id)
	{
		$obj_course = new course();
        $course = $obj_course->getCourse($id);
        return view('admin.course.edit', ['course' => $course]);
	}

	public function postEditCourse(Request $req)
	{
		$this->validateCourse($req);
		$obj_course = new course();
        if (@$obj_course->updateCourse($req)) {
            return redirect()->back()->with('success', 'Thay đổi thành công');
        } else {
            return redirect()->back()->with('message', 'Thay đổi thất bại');
        }
	}

	public function postDeleteCourse(Request $req)
	{
		$obj_course = new course();
        if($obj_course->deleteCourse($req->course_id))
        	return redirect()->back()->with('success', 'Xóa thành công');
        return redirect()->back()->with('message', 'Xóa thất bại, ngành này đang tồn tại trong lớp không thể xóa');
	}

	public function getSearch(Request $req)
	{
		$obj_course = new course();
        $course = $obj_course->search($req);
        $count = $course->total();
        return view('admin.course.tables', ['course' => $course, 'count_course' => $count]);
	}
}
