<?php 
namespace App\Http\Controllers;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Auth;
//Model table
use App\Http\Models\disciplinary_information;
use App\Http\Models\teacher;
use App\Http\Models\student;
use App\Http\Models\classModel;
use App\Http\Models\course;
use App\Http\Models\major;
use App\Http\Models\MyExcel;


class TTKLController extends Controller {

	//------------ Excel -------------------\\
	private $nameFile = 'ttkl';

	public function downLoadTTKLTemp()
	{
		return response()->download(public_path('excel/excel-temp/thong-tin-ky-luat-temp.xlsx'));
	}

	public function getAddFromFile()
	{
		$obj_MyExcel = new MyExcel();
		$data = $obj_MyExcel->readToFile($this->nameFile);

		return view('admin.ttkyluat.add-file', ['data' => $data]);
	}

	public function deleteAllFromFile()
	{
		$obj_MyExcel = new MyExcel();
		$obj_MyExcel->deleteFile($this->nameFile);
		return redirect()->back()->with('success', 'Xóa Thành công!');
	}

	public function deleteStudentEx($id)
	{
		$obj_MyExcel = new MyExcel();
		$obj_MyExcel->deleteItemOnFile($this->nameFile, $id);
		return redirect()->back()->with('success', 'Xóa Thành công');
	}

	public function importExcelTTKL(Request $req)
	{
		$this->validate($req, [
			'file_excel' => 'required|max:450000',
			'read_row' => 'required|numeric',
			'di_dicision' => 'required',
			'di_year' => 'required|numeric',
			'di_semester' => 'required|numeric',],
			[
				'file_excel.required' => 'Chọn file dữ liệu để tải lên',
				'file_excel.max' => 'Chỉ đọc file có dung lượng nhỏ hơn 45Mb'
			]);
		$extensions = array("xls","xlsx","csv");

		$result = array($req->file('file_excel')->getClientOriginalExtension());

		if(!in_array($result[0],$extensions)){
			return redirect()->back()->with('message', 'Chỉ đọc các file có đuôi xlsx, xls, csv'); 
		}
		$obj_MyExcel = new MyExcel();
		$obj_class = new classModel();
		$obj_di = new disciplinary_information();

		$index = $req->select_index;
		$row = $req->read_row;
		if($row < 0){ $row = 0; }
		$di_dicision = $req->di_dicision;
		$di_semester = $req->di_semester;
		$di_year = $req->di_year;
		$file  = $req->file('file_excel')->getPathname();

		$import_discipline_all = $obj_MyExcel->loadConvertArray($file, ($row - 1), ($index - 1));
		
		if(count($import_discipline_all) <= 0)
			return redirect()->back()->with('message', 'Không tìm thấy dữ liệu trên file excel');

		//Kiểm tra dữ liệu đầu vào có đúng 20 cột không?
		if($obj_MyExcel->checkExcelInput($import_discipline_all) == false)
			return redirect()->back()->with('message', 'Kiểm tra lại dữ liệu đầu vào không hợp lệ. Vui lòng xem lại mẫu và làm đúng chuẩn các cột của file Excel mẫu. Dữ liệu đọc vào gồm 20 cột, từ cột A đến cột T trên file Excel.');

		$import_discipline_cntt = $obj_class->getStudentsByClassCode($import_discipline_all, 6);
		if(count($import_discipline_cntt) <= 0)
			return redirect()->back()->with('message', 'Không tìm thấy mã lớp trên file excel trùng với cơ sở dữ liệu. Nếu lớp mới hãy thêm lớp mới trước khi nhập file excel');

		$arr_file = $obj_MyExcel->readToFile($this->nameFile);
		$arr = (count($arr_file) <= 0) ? $obj_di->convertToDisciplinary($import_discipline_cntt, $di_dicision, $di_semester, $di_year, $req) : array_merge($obj_di->convertToDisciplinary($import_discipline_cntt, $di_dicision, $di_semester, $di_year, $req), $arr_file);
		$obj_MyExcel->wirteToFile($this->nameFile, $arr);
		// $arr_file_all = $obj_MyExcel->readToFile($this->nameFile);
		return redirect()->back()->with('success', 'Upload Thành công');
	}

	public function editStudentInJson($id = -1)
	{
		$obj_MyExcel = new MyExcel();
		$arr_file_all = $obj_MyExcel->readToFile($this->nameFile);
		if(isset($arr_file_all[$id]))
		{
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				exit(json_encode(array_merge($arr_file_all[$id], ['edit_id' => $id])));
			}
		}
	}

	public function posteditStudentInJson(Request $req)
	{

		$id = $req->edit_id;
		$obj_MyExcel = new MyExcel();
		$obj_di = new disciplinary_information();
		$arr_file_all = $obj_MyExcel->readToFile($this->nameFile);
		if(isset($arr_file_all[$id]))
		{
			$afterChanges = $obj_di->changeInformationInJson($arr_file_all, $req, $this->nameFile);
			if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
				exit(json_encode($afterChanges));
			}
		}
	}

	public function updateDataToDataBaseQuestion(Request $req)
	{


		$obj_MyExcel = new MyExcel();
		$obj_di = new disciplinary_information();
		
		$arr_file_all = $obj_MyExcel->readToFile($this->nameFile);
		if(count($arr_file_all) <= 0)
			return redirect()->back()->with('message', 'Không có dữ liệu tạm thời'); 
		for($i = 0; $i < count($arr_file_all); $i++)
		{
			$req->query->add($arr_file_all[$i]);
			$this->validateValueJsonUpdateToDatabase($req);
		}

		$identicalCheck = $obj_di->identicalCheckTTKL($arr_file_all);
		if(count($identicalCheck) > 0)
		{
			return redirect()->back()->with('message', 'Dữ liệu trùng lặp: [Mã sinh viên] có cùng [Học Kì] và [Năm học] trên Cơ sở dữ liệu !!!! Nhấp nút "Ghi đè dữ liệu" để tiếp tục ghi dữ liệu lên Cơ sở dữ liệu."')->with('identicalArray', $identicalCheck);
		}

		$obj_di->addArrayToDatabaseTTKLQuestion($arr_file_all, $req);
		
		return redirect()->back()->with('success', 'Nhập dữ liệu vào cơ sở dữ liệu thành công.');
	}

	public function updateDataToDataBase(Request $req)
	{
		$obj_MyExcel = new MyExcel();
		$obj_di = new disciplinary_information();
		
		$arr_file_all = $obj_MyExcel->readToFile($this->nameFile);
		if(count($arr_file_all) <= 0)
			return redirect()->back()->with('message', 'Không có dữ liệu tạm thời'); 

		for($i = 0; $i < count($arr_file_all); $i++)
		{
			$req->query->add($arr_file_all[$i]);
			$this->validateValueJsonUpdateToDatabase($req);
		}
		
		
		$obj_di->addArrayToDatabaseTTKLOverride($arr_file_all, $req);
		return redirect('/admin/disciplinary-information/add-from-file')->with('success', 'Ghi đè lên dữ liệu cũ thành công!');
	}

	public function getExportTTKL()
	{
		return view('admin.ttkyluat.export');
	}

	public function postExportTTKL(Request $req)
	{
		$this->validate($req,[
			'hocky' => 'required|numeric',
			'nam' => 'required|numeric',
			'file_extension' => 'required',
		],[
			'hocky.required' => 'Không được phá, học kì là bắt buộc',
			'hocky.numeric' => 'Học kì phải số',
			'nam.required' => 'Không được phá, học kì là bắt buộc',
			'nam.numeric' => 'Học kì phải số',
			'file_extension.required' => 'Không được phá',
		]);
		switch ($req->file_extension) {
			case 'csv':
			break;
			case 'xlsx':
			break;
			case 'xls':
			break;
			default:
			return redirect()->back()->with('message', 'Chỉ xuất ra file có đuôi .csv, .xlsx, .xls');
		}
		$hocky = $req->hocky; $nam = $req->nam;
		$duoifile = $req->file_extension;
		$export_type = $req->export_type;
		$myExcel = new MyExcel();
		$obj_di = new disciplinary_information();
		

		$information_di = $obj_di->findValueExport($hocky, $nam);
		
		if(count($information_di) <= 0)
		{
			return redirect()->back()->with('message', 'Không tồn tại dữ liệu sinh viên có học kỳ '.$hocky.' năm học '.$nam.'-'.($nam+1));
		}

		$excel_name = 'Danh sách sinh viên buộc thôi học hk'.$hocky.'-'.$nam.'-'.($nam+1).'-'.date('d-m-Y');
		$sheet_name = "Khoa CNTT";
		if($export_type == 'md')
		{
			$result = $myExcel->CustomTableThongTinKyLuatgetDataTableToLaravelExcel($information_di, 
					['STT', 'MSSV', 'Họ', 'Tên', 'Ngày sinh', 'Bậc đào tạo', 'Loại hình đào tạo', 'Mã lớp SV', 'Ngành học', 'Điểm TBC', 'Số TCTL', 'Số TC còn nợ', 'Điểm TBCTL', 'ĐTB10', 'SV năm thứ', 'Phản hồi Khoa', 'Tình trạng', 'Ghi chú', 'Kết quả trước'], 
					['', 'student_code', 'student_fullname', 'student_fullname', 'student_birth', 'student_level_edu', 'student_type_edu', 'class_code', 'major_name', 'di_TBC', 'di_TCTL', 'di_TC_debt', 'di_TBCTL', 'di_DTB10', 'di_student_year', 'di_falcuty_confirm', 'discipline_name', 'di_note', 'di_last_result']);
			return $myExcel->ExportTTKLMacDinh($excel_name, $sheet_name, $nam, $hocky, $result, $duoifile);
		}


		$this->validateFormExportTTKL($req);
		$array_localti = $req->localti;
		$array_1 = $obj_di->convertArrayInputToArrayValue($array_localti, 1);
		$array_2 = $obj_di->convertArrayInputToArrayValue($array_localti, 2);
		$table_data = $myExcel->CustomTableThongTinKyLuatgetDataTableToLaravelExcel($information_di, $array_1, $array_2);
		$merge = $req->merge;
		$table_style = array(
			'tb_wirte' => $req->tb_wirte, 
			'tb_font' => $req->tb_font, 
			'tb_background' => $req->tb_background,
			'tb_color' => $req->tb_color,
			'tb_text_align' => $req->tb_text_align,
			'tb_text_align_2' => $req->tb_text_align_2,
			'tb_font_size' => $req->tb_font_size,
		);

		$table_style = isset($req->tb_bold)?array_merge($table_style, ['tb_bold' => 'true']):array_merge($table_style, []);
		$table_style = isset($req->tb_italic)?array_merge($table_style, ['tb_italic' => 'true']):array_merge($table_style, []);
		$table_style = isset($req->tb_underline)?array_merge($table_style, ['tb_underline' => 'true']):array_merge($table_style, []);
		$table_style = isset($req->tb_even_odd)?array_merge($table_style, ['tb_even_odd' => 'true']):array_merge($table_style, []);
		return $myExcel->ExportCustumAllTable($excel_name, $sheet_name, $table_data, $duoifile, $merge, $table_style);

	}

	//--------------- end Excel -------------------\\

	public function index()
	{

		$obj = new disciplinary_information();
		$data = $obj->getAllDataNew();
		return view('admin.ttkyluat.tables', ['data' => $data]);
	}

	public function dashboard($id)
	{
		return view('admin.index');
	}

	public function getAddDiscipline()
	{
		return view('admin.ttkyluat.add');
	}

	public function validateAddNewSV($req)
	{
		$this->validate($req, [
			'di_TBC' => 'numeric|between:0,10',
			'di_TCTL' => 'numeric',
			'di_TBCTL' => 'numeric|between:0,10',
			'di_DTB10' => 'numeric|between:0,10',
			'di_TC_debt' => 'numeric',
			'di_semester' => 'numeric',
			'di_year' => 'numeric',
			'di_student_id' => 'required|numeric',
			'di_discipline_id' => 'required|numeric',
			'di_semester' => 'required|numeric',
			'di_year' => 'required|numeric',

		],[
			'di_discipline_id.required' => 'Chưa chọn tình trạng kỷ luật',
			'di_semester.required' => 'Chưa chọn học kỳ',
			'di_year.required' => 'Chưa chọn năm học',
			'di_discipline_id.numeric' => 'Tình trạng sai định dạng',
			'di_semester.numeric' => 'Học kỳ sai định dạng',
			'di_year.numeric' => 'Năm học sai định dạng',
			'di_TBC.between' => 'Điểm TBC chỉ trong phạm vi từ 0 đến 10',
			'di_TBCTL.between' => 'Điểm TBCTL chỉ trong phạm vi từ 0 đến 10',
			'di_DTB10.between' => 'Điểm trung bình 10 chỉ trong phạm vi từ 0 đến 10',
			'di_TBC.numeric' => 'Trung bình cộng phải là số!',
			'di_TCTL.numeric' => 'TCTL phải là số!',
			'di_TBCTL.numeric' => 'TBCTL phải là số!',
			'di_DTB10.numeric' => 'DTB10 phải là số!',
			'di_TC_debt.numeric' => 'Số TC Nợ phải là số!',
			'di_semester.numeric' => 'học kỳ phải là số!',
			'di_year.numeric' => 'năm học phải là số!',
			'di_student_id.numeric' => 'student_code phải là số!',
			'di_student_id.required' => 'chưa chọn sinh viên',
		]);
	}

	public function postAddDiscipline(Request $req)
	{
		$this->validateAddNewSV($req);
		$obj = new disciplinary_information();
		$obj->createDI($req);
		return redirect()->back()->with('success', 'Thêm thành công');
	}

	public function getChangeClass($id)
	{
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$obj_class = new classModel();
			$student = $obj_class->getStudentInClassId($id);
			return view('admin.ttkyluat.change-class', ['student' => $student]);
		}
		return view('admin.index');
	}

	public function getChangeCourse($id)
	{
		if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
			$obj_class = new classModel();
			$class = $obj_class->getClassFromCourseId($id);
			return view('admin.ttkyluat.change-course', ['class' => $class]);
		}
		return view('admin.index');

	}

	public function postDeleteTTKL(Request $req)
	{
		$this->validate($req, [
			'di_id' => 'numeric',
		], [
			'di_id.numeric' => 'Id phải là số',
		]);
		$obj_di = new disciplinary_information();
		$obj_di->deleteDI($req);
		return redirect()->back()->with('success', 'Xóa thành công');
	}

	public function findDiStudent($id)
	{
		$obj = new disciplinary_information();
		$item = $obj->findId($id);
		echo json_encode($item);
	}

	public function getEditDiscipline($id)
	{
		$obj = new disciplinary_information();
		$item = $obj->findId($id);
		return view('admin.ttkyluat.edit', ['item' => $item]);
	}

	public function postEditDiscipline(Request $req)
	{
		$this->validateAddNewSV($req);
		$obj = new disciplinary_information();
		$obj->updateDI($req);
		return redirect()->back()->with('success', 'Thay đổi thành công');
	}



//==========================================================================================================================\\
	//Chức năng USER 

	public function indexUser($id = 'index')
	{
		return view('user.index');
	}

	public function getUserList()
	{
		$obj_t = new teacher();
		$teacher = $obj_t->getTeacherId(Auth::user()->user_teacher_code);
		$obj = new disciplinary_information();
		$data = $obj->getUserList($teacher->teacher_id, null);
		return view('user.ttkyluat.tables', ['data' => $data]);
	}

	public function getUserList_Class($idclass)
	{
		$obj_t = new teacher();
		$teacher = $obj_t->getTeacherId(Auth::user()->user_teacher_code);
		$obj = new disciplinary_information();
		$data = $obj->getUserList($teacher->teacher_id, $idclass);
		return view('admin.ttkyluat.tables', ['data' => $data]);
	}

	public function getUserUpdate($id)
	{

		$obj = new disciplinary_information();
		$item = $obj->findId($id);
		if(count($item) < 1)
		{
			return view('user.error.404');
		}
		return view('user.ttkyluat.edit', ['item' => $item]);
	}

	public function postUserUpdate(Request $req)
	{
		$this->validate($req, [
			'di_id' => 'required|numeric',
			'student_id' => 'required|numeric',
		]);
		$obj_t = new teacher();
		$obj_student = new student();
		$teacher = $obj_t->getTeacherId(Auth::user()->user_teacher_code);
		$obj = new disciplinary_information();
		if($obj->updatePhanHoi($teacher->teacher_id, $req) == false)
		{
			return view('user.error.404');
		}
		$obj_student->postContactCVHT($req->student_id, $req->student_contact);
		return redirect()->back()->with('success', 'Thay đổi thành công');
	}

	public function getSearchUser(Request $req)
	{
		$obj_t = new teacher();
		$teacher = $obj_t->getTeacherId(Auth::user()->user_teacher_code);
		$obj = new disciplinary_information();
		$data = $obj->getSearch($req);
		$types = $req->types;
		$hocky_s = $req->hocky;
		$nam_s = $req->nam;
		return view('user.ttkyluat.tables', compact('data', 'types', 'hocky_s', 'nam_s'));
	}


	public function getSearchTTKL(Request $req)
	{
		$this->validate($req, [
			'nam' => 'required|numeric',
			'hocky' => 'required|numeric',
			'types' => 'required',],
			[
				'nam.required' => 'Chọn năm học để tìm kiếm',
				'hocky.required' => 'Chọn học kỳ để tìm kiếm. Gợi ý: Tìm kiếm theo tiêu chí "mặc định" sẽ tìm tất cả tiêu chí',
			]);
		$exists = array("class_code","md","student_code", "student_fullname", "cph");

		if(!in_array($req->types, $exists)){
			return redirect()->back()->with('message', 'Lỗi phá hoại.'); 
		}

		$obj_di = new disciplinary_information();
		$data = $obj_di->getAdminSearch($req);
		$types = $req->types;
		$hocky_s = $req->hocky;
		$nam_s = $req->nam;
		return view('admin.ttkyluat.tables', compact('hocky_s', 'nam_s', 'types', 'data'));

	}

		public function validateValueJsonUpdateToDatabase($req)
	{
		$this->validate($req, [
			'student_code' => 'required',
			'student_name' => 'required',
			'student_birth' => 'required',
			'student_birth' => 'date_multi_format: "d-m-Y", "d/m/Y"',
			'student_level_edu' => 'required',
			'student_type_edu' => 'required',
			'class_id' => 'required|numeric',
			'di_TBC' => 'numeric',
			'di_TCTL' => 'numeric',
			'di_TC_debt' => 'numeric',
			'di_TBCTL' => 'numeric',
			'di_DTB10' => 'numeric',
			'di_student_year' => 'required',
			'discipline_id' => 'required|numeric',
			'di_dicision' => 'required',
			'di_semester' => 'numeric',
			'di_year' => 'numeric'],
			[
				'student_code.required' => 'Mã sinh viên là bắt buộc hãy kiểm tra lại dữ liệu.',
				'student_name.required' => 'Tên sinh viên là bắt buộc hãy kiểm tra lại dữ liệu.',
				'student_birth.required' => 'Ngày sinh sinh viên là bắt buộc',
				'student_birth.date_multi_format' => 'Ngày sinh sinh viên sai định dạng (dd-mm-yyyy) hoặc (dd/mm/yyyy)',
				'student_level_edu.required' => 'Bậc đào tạo là bắt buộc',
				'student_type_edu.required' => 'Loại hình đào tạo là bắt buộc',
				'class_id.required' => 'Dữ liệu bị lỗi không tìm thấy id_class xóa và thêm mới lại',
				'class_id.numeric' => 'Dữ liệu bị lỗi không tìm thấy id_class xóa và thêm mới lại',
				'di_TBC.numeric' => 'TBC phải là số',
				'di_TCTL.numeric' => 'Tín chỉ tích lũy phải là số',
				'di_TC_debt.numeric' => 'Số tín chỉ nợ phải là số',
				'di_TBCTL.numeric' => 'Trung bình chung tích lũy phải là số',
				'di_DTB10.numeric' => 'DTB10 phải là số',
				'di_student_year.required' => 'Sinh viên năm là bắt buộc',
				'discipline_id.numeric' => 'Hệ thống kỷ luật không tồn lại',
				'discipline_id.required' => 'Hệ thống kỷ luật không tồn lại',
				'di_dicision.required' => 'Số quyết định phải là số',
				'di_semester.numeric' => 'Học kỳ phải là số!',
				'di_year.numeric' => 'Năm học phải là số!',

			]);
	}

	public function validateFormExportTTKL($req)
	{
		$this->validate($req, [
			'merge.*.from' => 'required|regex:/^[A-Z]{1,2}[1-9]{1,2}$/',
			'merge.*.to' => 'required|regex:/^[A-Z]{1,2}[1-9]{1,2}$/',
			'merge.*.background' => 'required',
			'merge.*.color' => 'required',
			'merge.*.font' => 'required',
			'merge.*.size' => 'required|numeric',
			'merge.*.text_align' => 'required',
			'merge.*.text_align_2' => 'required',
			'tb_wirte' => 'required|regex:/^[A-Z]{1,2}[1-9]{1,2}$/',
			'tb_font' => 'required',
			'tb_background' => 'required',
			'tb_color' => 'required',
			'tb_text_align' => 'required',
			'tb_text_align_2' => 'required',
			'tb_font_size' => 'required|numeric',
			],
			[
			'merge.*.from.required' => 'Meger Form là bắt buộc',
			'merge.*.to.required' => 'Meger To là bắt buộc',
			'merge.*.background.required' => 'Meger Backgound là bắt buộc',
			'merge.*.color.required' => 'Meger Color là bắt buộc',
			'merge.*.font.required' => 'Meger Font là bắt buộc',
			'merge.*.size.required' => 'Meger Size là bắt buộc',
			'merge.*.text_align.required' => 'Meger Text align là bắt buộc',
			'merge.*.text_align_2.required' => 'Meger Text align là bắt buộc',
			'merge.*.from.regex' => 'Meger Form sai định dạng ít nhất một chữ hoa và 1 số, dài nhất là 2 chữ hoa và 2 số',
			'merge.*.to.regex' => 'Meger To sai định dạng ít nhất một chữ hoa và 1 số, dài nhất là 2 chữ hoa và 2 số',
			'merge.*.size.numeric' => 'Meger Size phải là số',
			'tb_wirte.required' => 'Viết bảng dữ liệu từ dòng là bắt buộc',
			'tb_wirte.regex' => 'Viết bảng dữ liệu từ dòng sai định dạng ít nhất bắt đầu một chữ hoa và 1 số, dài nhất bắt đầu là 2 chữ hoa và 2 số',
			'tb_font' => 'Font chữ cho table là bắt buộc',
			'tb_background' => 'Màu nền cho table là bắt buộc',
			'tb_color' => 'Màu chữ cho table là bắt buộc',
			'tb_text_align' => 'text_align là bắt buộc',
			'tb_text_align_2' => 'text_align là bắt buộc',
			'tb_font_size.required' => 'font size của table là bắt buộc',
			'tb_font_size.numeric' => 'font size của table phải là số',


		]);

		$exists = ['STT', 'student_code', 'student_fname', 'student_lname', 'student_birth', 'student_level_edu', 'student_type_edu', 'class_code', 'major_name', 'di_TBC', 'di_TCTL', 'di_TC_debt', 'di_TBCTL', 'di_DTB10', 'di_student_year', 'di_falcuty_confirm', 'discipline_name', 'di_note', 'di_last_result'];

		$array_localti = $req->localti;
		for($i = 0; $i < count($array_localti); $i++)
		{
			if(!in_array($array_localti[$i], $exists)){
				return redirect()->back()->with('message', 'Lỗi phá hoại.'); 
			}
		}
	}

	public function UpdateSQD()
	{
		return view('admin.ttkyluat.update-dicision');
	}

	public function postUpdateSQD(Request $req)
	{
		$this->validate($req, [
			'di_dicision' => 'required',
			'di_semester' => 'required|numeric',
			'di_year' => 'required|numeric',
		], [
			'di_dicision.required' => 'Nhập số quyết định',
			'di_semester.required' => 'học kỳ là bắt buộc',
			'di_year.required' => 'Năm học là bắt buộc',
			'di_semester.numeric' => 'học kỳ phải là số',
			'di_year.numeric' => 'năm học phải là số',
		]);

		$obj_di = new disciplinary_information();
		$obj_di->updateSDQ($req);
		return redirect()->back()->with('success', 'cập nhật thành công');
	}
}
