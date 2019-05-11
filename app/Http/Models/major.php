<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use App\Http\Models\MyExcel;
use App\Http\Models\classModel;
class major extends Model
{
    protected $table = 'major';
	public $primaryKey = 'major_id';
	public $timestamps = false;
	public $fillable = [ 'major_name', 'major_code'];

	/**
	*	@return major_id
	*/
	public function getMajorId($str)
	{
		$obj = new MyExcel();
		$substr = $obj->cutFisrtAndLastLetter($str);
		$kq = $this->where('major_name', 'like', '%'.$substr.'%')->first();
		return (count($kq) <= 0) ? 0 : $kq['major_id'];
	}

	public function getMajorNameById($id)
	{
		$kq = $this->where('major_id', $id)->first();
		return (count($kq) <= 0) ? '' : $kq['major_name'];
	}

	public function getClassName($major_symbol, $class_name_number)
	{
		$kq = $this->where('major_symbol', $major_symbol)->first();
		return (count($kq) <= 0) ? $class_name_number : $kq['major_name'].' '.$class_name_number;
	}

	public function findMajorIdBySymbol($symbol)
	{
		$kq =  $this->where('major_symbol', $symbol)->first();
		return (count($kq) <= 0) ? 0 : $kq['major_id'];
	}

	public function getValueClassInExcelFile($import_all_class)
	{
		$all = $this->all();
		$str = '';

		foreach ($all as $key => $value) {
			if($str == '') { $str = $value['major_symbol']; }
			else { $str = $str.'-'.$value['major_symbol']; }
		}
		
		$arrayClass = [];
		$j = 0;
		for($i = 0; $i < count($import_all_class); $i++)
		{
			$check = preg_match('/^[C][D][1-9]{2}['.$str.']{2,4}[1-9]{1,2}$/',$import_all_class[$i][1]);
			if($check)
			{
				$arrayClass[$j] = $import_all_class[$i];
				$j++;
			}
		}
		return $arrayClass;
	}

	/**
	*	@return major_name
	*/
	public function getMajorName($str)
	{
		$id = $this->getMajorId($str);
		$kq = $this->find($id);
		return (count($kq) <= 0) ? 'Không tìm thấy dữ ngành tương ứng trên CSDL' : $kq['major_name'];
	}



	public function getList()
	{
		return $this->paginate(15);
	}

	public function createMajor($req)
	{
		$major = new major();
		$major->major_name = $req->major_name;
		$major->major_code = $req->major_code;
		$major->major_symbol = $req->major_symbol;
		$major->save();
	}

	public function getMajor($id)
	{
		return $this->find($id);
	}

	public function updateMajor(Request $req)
	{
		$major = $this->find($req->major_id);
		$major->major_name = $req->major_name;
		$major->major_code = $req->major_code;
		$major->major_symbol = $req->major_symbol;
		$major->save();
	}

	public function deleteMajor($id)
	{
		$obb_class = new classModel();
		if($obb_class->findClassByMajorId($id) == true)
			return false;
		$this->find($id)->delete();
		return true;
	}

	public function search(Request $req)
	{
		if($req->types == "md")
		{
			$major = $this->where('major_name', 'like', '%'.$req->key.'%')->orWhere('major_code', 'like', '%'.$req->key.'%')->paginate(15);
		}
		else
		{
			$major = $this->where($req->types, 'like', '%'.$req->key.'%')->paginate(15);
		}
		return $major;
	}




}
