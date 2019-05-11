<?php

namespace App\Http\Models;

use Illuminate\Database\Eloquent\Model;
use App\Http\Models\MyExcel;
use Illuminate\Http\Request;
use App\Http\Models\disciplinary_information;
class discipline extends Model
{
    protected $table = 'discipline';
	public $primaryKey = 'discipline_id';
	public $timestamps = false;

	/**
	*	@return discipline_id
	*/
	public function getDisciplineId($str)
	{
		$obj = new MyExcel();
		$substr = $obj->cutFisrtAndLastLetter($str);
		$kq = $this->where('discipline_name', 'like', '%'.$substr.'%')->first();
		return (count($kq) <= 0) ? 0 : $kq['discipline_id'];
	}

	public function getDisciplineName($str)
	{
		$id = $this->getDisciplineId($str);
		$kq = $this->find($id);
		return (count($kq) <= 0) ? "Không tìm thấy" : $kq['discipline_name'];
	}

	public function getDisciplineIdNameById($id)
	{
		$kq = $this->find($id);
		return $kq['discipline_name'];
	}

	//======================================

	public function getList() {
        return $this->paginate(10);
    }

    public function getDiscipline($id) {
        return $this->find($id);
    }

    public function search(Request $req) {
            $discipline = $this->where('discipline_name', 'like', '%' . $req->key . '%')
                    ->paginate(10);
        return $discipline;
    }

    public function createDiscipline($req) {
        $discipline_obj = new discipline();
        if (!@$req->discipline_name)
            return false;
        $discipline_obj->discipline_name = $req->discipline_name;
        $discipline_obj->save();
        return $discipline_obj->discipline_id;
    }

    public function updateDiscipline($req) {
        $discipline = $this->find($req->discipline_id);
        if (!@$req->discipline_name)
            return false;
        $discipline->discipline_name = $req->discipline_name;
        $discipline->save();
        return true;
    }

    public function deleteDiscipline($id) {
        $obj_di = new disciplinary_information();
        if($obj_di->checkDI($id))
            return false;
        $this->find($id)->delete();
        return true;
    }
}
