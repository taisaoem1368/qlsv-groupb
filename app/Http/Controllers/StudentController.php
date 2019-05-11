<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\student;

class StudentController extends Controller {

    public function index() {
        $obj_student = new student();
        $student = $obj_student->getList();
        return view('admin.student.tables', ['student' => $student]);
    }

    public function getClassValue($id) {
        $obj_student = new student();
        $result = $obj_student->getComboboxAddScreen($id);
        return $result;
    }

    public function getAddStudent() {
        $id = 1;
        $obj_student = new student();
        $result = $obj_student->getComboboxAddScreen($id);
        $major = $result['major'];
        if (@$result['class']) {
            $class = $result['class'];
            return view('admin.student.add', ['major' => $major, 'class' => $class]);
        } else {
            return view('admin.student.add', ['major' => $major]);
        }
    }

    public function getAddFromFileStudent() {
        return view('admin.student.add-file');
    }

    public function validateStudent($req)
    {
        $this->validate($req, [
            'student_fullname' => 'required',
            'student_code' => 'required',
            'student_class_id' => 'required|numeric',
        ], [
            'student_fullname.required' => 'Họ và Tên sinh viên là bắt buộc',
            'student_code.required' => 'Mã sinh viên là bắt buộc',
            'student_class_id.required' => 'Mã lớp là bắt buộc',
            'student_class_id.numeric' => 'Mã lớp phải là số',
        ]);
    }

    public function postAddStudent(Request $req) {

        $this->validateStudent($req);
        $obj_student = new student();
        if (!@$obj_student->createStudent($req)) {
            return redirect()->back()->with('fail', 'Thêm mới thất bại! Mời thử lại!');
        } else {
            return redirect()->back()->with('success', 'Thêm mới thành công');
        }
    }

    public function getEditStudent($id) {
        $obj_student = new student();
        $student = $obj_student->getStudent($id);
        $id = 1;
        $obj_student = new student();
        $result = $obj_student->getComboboxAddScreen($id);
        $major = $result['major'];
        if (@$result['class']) {
            $class = $result['class'];
            return view('admin.student.edit', ['major' => $major, 'class' => $class, 'student' => $student]);
        } else {
            return view('admin.student.edit', ['major' => $major, 'student' => $student]);
        }
    }

    public function postEditStudent(Request $req) {
        $this->validateStudent($req);
        $obj_student = new student();
        if (@$obj_student->updateStudent($req)) {
            return redirect()->back()->with('success', 'Thay đổi thành công');
        } else {
            return redirect()->back()->with('fail', 'Thay đổi thất bại! Mời thử lại!');
        }
    }

    public function postDeleteStudent(Request $req) {
        $obj_student = new student();
        if ($obj_student->deleteStudent($req->student_id)) {
            return ['delete-success' => 'Xóa thành công!'];
        } else {
            return ['delete-fail' => 'Xóa thất bại! SV này đang bị kỷ luật không thể xóa!'];
        }
    }

    public function getSearch(Request $req) {
        $obj_student = new student();
        $student = $obj_student->search($req);
        $count = $student->total();
        return view('admin.student.tables', ['student' => $student, 'count_student' => $count]);
    }

}
