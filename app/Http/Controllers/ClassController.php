<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\classModel;
use App\Http\Models\teacher;
use App\Http\Models\course;
use App\Http\Models\disciplinary_information;
use App\Http\Models\student;
use App\Http\Models\major;
use App\Http\Models\MyExcel;

class ClassController extends Controller
{
	private $file_name = 'class';

	public function downLoadClassTemp()
	{
		return response()->download(public_path('excel/excel-temp/class-temp.xlsx'));
	}

	public function index()
	{
		$obj = new classModel();
		$class = $obj->getList();
		return view('admin.class.tables', ['class' => $class]);
	}

	public function getAddClass()
	{
		return view('admin.class.add');
	}

	public function postAddClass(Request $req)
	{
		$this->validate($req, [
			'class_code' => 'required',
			'class_teacher_id' => 'required|numeric',
			'class_course_id' => 'required|numeric',
			'class_major_id' => 'required|numeric',
		],[
			'class_code.required' => 'Mã lớp là bắt buộc',
			'class_teacher_id.required' => 'Giáo viên quản lí lớp là bắt buộc',
			'class_course_id.required' => 'Mã khóa học trong lớp là bắt buộc',
			'class_major_id.required' => 'Mã ngành học trong lớp là bắt buộc',
		]);
		$obj = new classModel();
		$class = $obj->createClass($req);
		return redirect()->back()->with('success', 'Thêm thành công');
	}


	public function getEditClass($id)
	{
		$obj = new classModel();
		$item = $obj->findId($id);
		return view('admin.class.edit', ['item' => $item]);
	}

	public function postEditClass(Request $req)
	{
		$this->validate($req, [
			'class_code' => 'required',
			'class_teacher_id' => 'required|numeric',
			'class_course_id' => 'required|numeric',
			'class_major_id' => 'required|numeric',
		],[
			'class_code.required' => 'Mã lớp là bắt buộc',
			'class_teacher_id.required' => 'Giáo viên quản lí lớp là bắt buộc',
			'class_course_id.required' => 'Mã khóa học trong lớp là bắt buộc',
			'class_major_id.required' => 'Mã ngành học trong lớp là bắt buộc',
		]);
		$obj = new classModel();
		$class = $obj->updateClass($req);
		return redirect()->back()->with('success', 'Thay đổi thành công');
	}

	public function getSearch(Request $req)
	{
		$obj = new classModel();
		$class = $obj->searchClass($req);
		$class_count = $class->total();
		return view('admin.class.tables', ['class' => $class, 'class_count' => $class_count]);
	}

	public function postDeleteClass(Request $req)
	{
		$obj = new classModel();
		if($obj->deleteClass($req) == false)
			return redirect()->back()->with('message', 'Không xóa được, lớp này hiện tại đã tồn tại sinh viên!');
		return redirect()->back()->with('success', 'Xóa lớp thành công!');
	}

	//================================EXCEL==================================\\
	public function getAddFromFileClass()
	{
		$obj_MyExcel = new MyExcel();
		$data = $obj_MyExcel->readToFile($this->file_name);
		return view('admin.class.add-file', ['data' => $data]);
	}

	public function postClassImportExcel(Request $req)
	{
		$obj_MyExcel = new MyExcel();
		$obj_class = new classModel();
		$obj_di = new disciplinary_information();
		$obj_major = new major();
		$index = $req->select_index;
		$row = $req->read_row;
		if($row < 0){ $row = 0; }
		$file  = $req->file('file_excel')->getPathname();
		//Đọc file excel
		$import_all_class = $obj_MyExcel->loadConvertArray($file, ($row - 1), ($index - 1));
		if(count($import_all_class) <= 0)
			return redirect()->back()->with('with', 'Không tìm thấy dữ liệu');
		//Lọc Excel chỉ lấy các dòng có Class
		$arrayClass = $obj_major->getValueClassInExcelFile($import_all_class);
		if(count($arrayClass) <= 0)
			return redirect()->back()->with('with', 'Không tìm thấy dữ liệu class. Xem lại mẫu upload và sử dụng đúng mẫu');
		//Chuyển giá trị object $arrayClass sang mảng
		$array_class_fill = $obj_class->conVertToArrayTableClass($arrayClass, $req);
		//Viết xuống file Json
		$obj_MyExcel->wirteToFile($this->file_name, $array_class_fill);
		$data = $obj_MyExcel->readToFile($this->file_name);
		return redirect()->back()->with('success', 'Upload Thành công');
	}

	public function deleteClassJson()
	{
		$obj_MyExcel = new MyExcel();
		$obj_MyExcel->deleteFile($this->file_name);
		return redirect()->back()->with('success', 'Xóa thành công');
	}

	public function postAddJsonToDataBase(Request $req)
	{
		$obj_MyExcel = new MyExcel();
		$obj_Class = new classModel();
		$obj_major = new major();
		$obj_course = new course();
		$data = $obj_MyExcel->readToFile($this->file_name);
		if(count($data) <= 0)
			return redirect()->back()->with('message', 'Không tìm thấy dữ liệu tạm thời');
		for($i = 0; $i < count($data); $i++)
		{
			$req->query->add($data[$i]);
			$this->validateValueJsonUpdateToDatabase($req);
		}

		$obj_Class->addArrayJsonToDatabase($data, $req);
		return redirect()->back()->with('success', 'Update dữ liệu thành công! Chú ý: Chỉ update dữ liệu mới nếu dữ liệu bị trùng sẽ được bỏ qua.');
	}

	public function validateValueJsonUpdateToDatabase($req)
	{
		$this->validate($req, [
			'class_code' => 'required',
			'teacher_code' => 'required',
			'teacher_fullname' => 'required',
		], [
			'class_code.required' => 'Mã lớp là bắt buộc.',
			'teacher_code.required' => 'Mã giáo viên là bắt buộc',
			'teacher_fullname.required' => 'Tên giáo viên không được để trống',
		]);

	}
}

