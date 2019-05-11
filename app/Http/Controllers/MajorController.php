<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\major;
use App\Http\Models\role;
use App\Http\Models\classModel;
use App\Http\Models\disciplinary_information;
use App\Http\Models\MyExcel;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\ExcelServiceProvider;
use PHPExcel;
use PHPExcel_IOFactory;
use PHPExcel_Worksheet_Drawing;
class MajorController extends Controller
{
    public function index()
	{
		$obj = new major();
		$major = $obj->getList();
		return view('admin.major.tables', ['major' => $major]);
	}

	public function getAddMajor()
	{
		return view('admin.major.add');
	}

	public function getAddFromFileMajor()
	{
		return view('admin.major.add-file');
	}

	public function postAddMajor(Request $req)
	{
		$this->validateHere($req);
		$obj = new major();
		$obj->createMajor($req);
		return redirect()->back()->with('success', 'Thêm thành công');
	}

	public function getEditMajor($id)
	{
		$obj = new major();
		$major = $obj->getMajor($id);
		return view('admin.major.edit', ['major' => $major]);
	}

	public function validateHere($req)
	{
		$this->validate($req, [
			'major_name' => 'required',
			'major_code' => 'required',
			'major_symbol' => 'required'
		], [
			'major_name.required' => 'Tên ngành học là bắt buộc',
			'major_code.required' => 'Mã ngành là bắt buộc',
			'major_symbol.required' => 'Ký hiệu ngành là bắt buộc để đọc file excel từ Class sẽ lấy được dữ liệu bên bảng ngành.Ví dụ: CD17TT4, Ký hiệu là TT; CD18ĐH4, Kí hiệu là ĐH.',
		]);
	}

	public function postEditMajor(Request $req)
	{
		$this->validateHere($req);
		$obj = new major();
		$obj->updateMajor($req);
		return redirect()->back()->with('success', 'Thay đổi thành công');
	}

	public function postDeleteMajor(Request $req)
	{
		$obj = new major();
		if($obj->deleteMajor($req->major_id) == false)
			return redirect()->back()->with('message', 'Không xóa được, ngành này hiện tại đã có lớp!');
		return redirect()->back()->with('success', 'Xóa ngành thành công!');
	}

	public function getSearch(Request $req)
	{
		$obj = new major();
		$major = $obj->search($req);
		$count = $major->total();
		return view('admin.major.tables', ['major' => $major, 'count_major' => $count]);
	}

	//=====================================================================================\\

}
