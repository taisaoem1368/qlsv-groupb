<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\absent;
use App\Http\Models\MyExcel;
use App\Http\Models\classModel;
use Illuminate\Support\Facades\Auth;

class absentController extends Controller
{
    //
    private $file_name = 'absent';

    public function downloadAnsentTemp()
    {
        return response()->download(public_path('excel/excel-temp/dssv-vang.xlsx'));
    }

    public function index()
    {
    	$obj_absent = new absent();
    	$data = $obj_absent->getAllData();

    	return view('admin.absent.tables', ['data' => $data]);
    }

    public function validateAbsent($req)
    {
    	$this->validate($req, [
    		'ai_student_id' => 'required|numeric',
    		'ai_absences' => 'required|numeric',
    		'ai_discipline_id' => 'required|numeric',
    		'ai_semester' => 'required|numeric',
    		'ai_year' => 'required|numeric',

    	], [
    		'ai_student_id.required' => 'Chọn sinh viên là bắt buộc',
    		'ai_student_id.numeric' => 'Id sinh viên phải là số',
    		'ai_absences.required' => 'Số tiếc vắng là bắt buộc',
    		'ai_absences.numeric' => 'Số tiếc vắng phải là số',
    		'ai_discipline_id.required' => 'Tình trạng là bắt buộc',
    		'ai_discipline_id.numeric' => 'Tình trạng phải là số',
    		'ai_semester.required' => 'Học kỳ là bắt buộc',
    		'ai_semester.numeric' => 'Học kỳ phải là số',
    		'ai_year.required' => 'Năm học là bắt buộc',
    		'ai_year.numeric' => 'Năm học phải là số',
    	]);
    }

    public function getAddAbsent()
    {
    	return view('admin.absent.add');
    }

    public function postAddAbsent(Request $req)
    {
    	$this->validateAbsent($req);
    	$obj_absent = new absent();
    	$obj_absent->createAbsent($req);
    	return redirect()->back()->with('success', 'Thêm thành công');
    }

    public function getEditAbsent($id)
    {
    	$obj_absent = new absent();
    	if(!$obj_absent->checkIdExist($id))
    		return redirect()->back()->with('message', 'Không tìm thấy sinh viên vi phạm vắng để xóa.');
    	$absent_item = $obj_absent->findAbsent($id);
    	return view('admin.absent.edit', ['absent_item' => $absent_item]);
    }

    public function postEditAbsent(Request $req)
    {
    	$this->validateAbsent($req);
    	$this->validate($req, [
    		'ai_id' => 'required|numeric'
    	], [
    		'ai_id.required' => 'Id cần sửa là bắt buộc',
    		'ai_id.numeric' => 'Id cần sửa phải là số',
    	]);
    	$obj_absent = new absent();
    	if(!$obj_absent->checkIdExist($req->ai_id))
    		return redirect()->back()->with('message', 'Không tìm thấy sinh viên vi phạm vắng để xóa.');
    	$obj_absent->updateAbsent($req);
    	return redirect()->back()->with('success', 'Thay đổi thành công');
    }

    public function postDeleteAbsent(Request $req)
    {
    	$this->validate($req, [
    		'ai_id' => 'required|numeric'
    	], [
    		'ai_id.required' => 'Id cần sửa là bắt buộc',
    		'ai_id.numeric' => 'Id cần sửa phải là số',
    	]);
		$obj_absent = new absent();
    	if(!$obj_absent->checkIdExist($req->ai_id))
    		return redirect()->back()->with('message', 'Không tìm thấy sinh viên vi phạm vắng để xóa.');
    	$obj_absent->deleteAbsent($req);
    	return redirect()->back()->with('success', 'Xóa thành công');
    }

    public function getSearchAbsent(Request $req)
    {
    	$this->validate($req, [
			'nam' => 'required|numeric',
			'hocky' => 'required|numeric',
			'types' => 'required',
			],
			[
				'nam.required' => 'Chọn năm học để tìm kiếm',
				'hocky.required' => 'Chọn học kỳ để tìm kiếm. Gợi ý: Tìm kiếm theo tiêu chí "mặc định" sẽ tìm tất cả tiêu chí',
			]);
		$exists = array("class_code","md","student_code", "student_fullname");

		if(!in_array($req->types, $exists)){
			return redirect()->back()->with('message', 'Lỗi phá hoại.'); 
		}
		$obj_absent = new absent();
        $data = $obj_absent->getSearch($req);
        $types = $req->types;
        $hocky_s = $req->hocky;
        $nam_s = $req->nam;
        return view('admin.absent.tables', compact('hocky_s', 'nam_s', 'types', 'data'));

    }

    public function getAddFromFileAbsent()
    {
        $obj_excel = new MyExcel();
        $data = $obj_excel->readToFile($this->file_name);
        return view('admin.absent.add-file', ['data' => $data]);
    }

    public function importExcelAbsent(Request $req)
    {
        $this->validate($req, [
            'file_excel' => 'required|max:450000',
            'read_row' => 'required|numeric',
            'ai_year' => 'required|numeric',
            'ai_semester' => 'required|numeric',
            ],
            [
                'file_excel.required' => 'Chọn file dữ liệu để tải lên',
                'file_excel.max' => 'Chỉ đọc file có dung lượng nhỏ hơn 45Mb'
            ]);
        $extensions = array("xls","xlsx","csv");

        $result = array($req->file('file_excel')->getClientOriginalExtension());

        if(!in_array($result[0],$extensions)){
            return redirect()->back()->with('message', 'Chỉ đọc các file có đuôi xlsx, xls, csv'); 
        }

        $obj_excel = new MyExcel();
        $obj_class = new classModel();
        $obj_absent = new absent();

        $index = $req->select_index;
        $row = $req->read_row;
        if($row < 0){ $row = 0; }
        $di_dicision = $req->di_dicision;
        $di_semester = $req->di_semester;
        $di_year = $req->di_year;
        $file_upload  = $req->file('file_excel')->getPathname();

        $import_all = $obj_excel->loadConvertArray($file_upload, ($row - 1), ($index - 1));
        $data_class = $obj_class->getStudentsByClassCode($import_all, 4);
        if(count($data_class) <= 0)
            return redirect()->back()->with('message', 'Không tìm thấy dữ liệu trên file');
        
        $lastDataArray = $obj_absent->getArrayAbsentJson($data_class, $req);
        $arr_file = $obj_excel->readToFile($this->file_name);

        $arr = (count($arr_file) <= 0) ? $lastDataArray : array_merge($lastDataArray, $arr_file);
   
        $obj_excel->wirteToFile($this->file_name, $arr);
        return redirect()->back()->with('success', 'Upload dữ liệu vào bộ nhớ tạm thành công.');
    }

    public function getDeleteJsonAbsent()
    {
        $obj_excel = new MyExcel();
        $obj_excel->deleteFile($this->file_name);
        return redirect()->back()->with('success', 'Xóa dữ liệu tạm thời thành công');
    }

    public function UpdateDataJsonFileToDataBaseQuestion(Request $req)
    {
        $obj_excel = new MyExcel();
        $obj_class = new classModel();
        $obj_absent = new absent();

        $arr_file = $obj_excel->readToFile($this->file_name);

        if(count($arr_file) <= 0)
            return redirect()->back()->with('message', 'Không tìm thấy dữ liệu trên bảng tạm');
        for($i = 0; $i < count($arr_file); $i++)
        {
            $req->query->add($arr_file[$i]);
            $this->validate($req, [
                'student_code' => 'required',
                'student_name' => 'required',
                'class_id' => 'required|numeric',
                'ai_absences' => 'required|numeric',
                'discipline_name' => 'required',
            ], [
                'student_code.required' => 'Mã code sinh viên là bắt buộc, xem lại dữ liệu tạm thời',
                'student_name.required' => 'Tên sinh viên là bắt buộc, xem lại dữ liệu tạm thời',
                'class_id.required' => 'Lớp là bắt buộc, upload lại dữ liệu',
                'class_id.numeric' => 'Lớp là bắt buộc, upload lại dữ liệu',
                'ai_absences.required' => 'Số tiết vắng của sinh viên là bắt buộc, xem lại dữ liệu tạm thời',
                'ai_absences.numeric' => 'Số tiết vắng phải là số, xem lại dữ liệu tạm thời',
                'discipline_name.required' => 'hình thức kỷ luật sinh viên là bắt buộc, xem lại dữ liệu tạm thời',
            ]);
        }


        if($obj_absent->checkIssetData($arr_file))
            return redirect()->back()->with(['message' => 'Tìm thấy dữ liệu đã tồn tại trên cơ sở dữ liệu. Bạn có muốn ghi đè? Ấn nút "Ghi đè dữ liệu"', 'identicalArray' => 'biến kiểm tra ghi đè']);
        $obj_absent->addJsonDataToDatabase($arr_file, $req);
        return redirect()->back()->with('success', 'Nhập dữ liệu tạm thời lên cơ sở dữ liệu thành công');
    }

    public function UpdateDataJsonFileToDataBase(Request $req)
    {
        $obj_excel = new MyExcel();
        $obj_class = new classModel();
        $obj_absent = new absent();

        $arr_file = $obj_excel->readToFile($this->file_name);
        if(count($arr_file) <= 0)
            return redirect()->back()->with('message', 'Không tìm thấy dữ liệu trên bảng tạm');

        for($i = 0; $i < count($arr_file); $i++)
        {
            $req->query->add($arr_file[$i]);
            $this->validate($req, [
                'student_code' => 'required',
                'student_name' => 'required',
                'class_id' => 'required|numeric',
                'ai_absences' => 'required|numeric',
                'discipline_name' => 'required',
            ], [
                'student_code.required' => 'Mã code sinh viên là bắt buộc, xem lại dữ liệu tạm thời',
                'student_name.required' => 'Tên sinh viên là bắt buộc, xem lại dữ liệu tạm thời',
                'class_id.required' => 'Lớp là bắt buộc, upload lại dữ liệu',
                'class_id.numeric' => 'Lớp là bắt buộc, upload lại dữ liệu',
                'ai_absences.required' => 'Số tiết vắng của sinh viên là bắt buộc, xem lại dữ liệu tạm thời',
                'ai_absences.numeric' => 'Số tiết vắng phải là số, xem lại dữ liệu tạm thời',
                'discipline_name.required' => 'hình thức kỷ luật sinh viên là bắt buộc, xem lại dữ liệu tạm thời',
            ]);
        }

        $obj_absent->addJsonDataToDatabase($arr_file, $req);
        return redirect()->back()->with('success', 'Ghi đè dữ liệu thành công');
    }

    //================== CỐ VẤN HỌC TẬP =======================\\

    public function getUserListAbsent()
    {
        $obj_absent = new absent();
        $data = $obj_absent->getStudentByCVHT(Auth::user()->user_teacher_code);

        return view('user.absent.tables', ['data' => $data]);
    }

    public function getSearchUserAbsent(Request $req)
    {
        $this->validate($req, [
            'nam' => 'required|numeric',
            'hocky' => 'required|numeric',
            'types' => 'required',
            ],
            [
                'nam.required' => 'Chọn năm học để tìm kiếm',
                'hocky.required' => 'Chọn học kỳ để tìm kiếm. Gợi ý: Tìm kiếm theo tiêu chí "mặc định" sẽ tìm tất cả tiêu chí',
            ]);
        $obj_absent = new absent();
        $data = $obj_absent->getStudentSearchByCVHT($req, Auth::user()->user_teacher_code);
        $types = $req->types;
        $hocky_s = $req->hocky;
        $nam_s = $req->nam;
        return view('user.absent.tables', compact('hocky_s', 'nam_s', 'types', 'data'));
    }

    //================ END CỐ VẤN HỌC TẬP ===================\\

}
