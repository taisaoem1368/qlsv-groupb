<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Models\discipline;

class DisciplineController extends Controller {

    public function index() {
        $obj_discipline= new discipline();
        $discipline = $obj_discipline->getList();
        return view('admin.discipline.tables', ['discipline' => $discipline]);
    }

    public function getAddDiscipline() {
        return view('admin.discipline.add');
    }

    public function getAddFromFileDiscipline() {
        return view('admin.discipline.add-file');
    }

    public function validateDiscipline($req)
    {
        $this->validate($req, [
            'discipline_name' => 'required',
        ], [
            'discipline_name.required' => 'Tên hình thức kỷ luật là bắt buộc'
        ]);
    }

    public function postAddDiscipline(Request $req) {
        $this->validateDiscipline($req);
        $obj_discipline = new discipline();
        if ($obj_discipline->createDiscipline($req) == false)
            return redirect()->back()->with('fail', 'Thêm mới thất bại! Mời thử lại');
        return redirect()->back()->with('success', 'Thêm mới thành công');
    }

    public function getEditDiscipline($id) {
        $obj_discipline = new discipline();
        $discipline = $obj_discipline->getDiscipline($id);
        return view('admin.discipline.edit', ['discipline' => $discipline]);
    }

    public function postEditDiscipline(Request $req) {
         $this->validateDiscipline($req);
        $obj_discipline = new discipline();
        if (@$obj_discipline->updateDiscipline($req)) {
            return redirect()->back()->with('success', 'Thay đổi thành công');
        } else {
            return redirect()->back()->with('fail', 'Thay đổi thất bại! Mời thử lại');
        }
    }

    public function postDeleteDiscipline(Request $req) {

        $obj_discipline = new discipline();
        if($obj_discipline->deleteDiscipline($req->discipline_id))
            return redirect()->back()->with('success', 'Xóa thành công');

        return redirect()->back()->with('message', 'Xóa không thành công, hiện tại đang có sinh viên vi phạm tình trạng kỉ luật này!');
    }

    public function getSearch(Request $req) {
        $obj_discipline = new discipline();
        $discipline = $obj_discipline->search($req);
        $count = $discipline->total();
        return view('admin.discipline.tables', ['discipline' => $discipline, 'count_discipline' => $count]);
    }

}
