@extends('admin.layout.master')
@section('title')
Xuất file - Thông tin kỷ luật
@stop
@section('css-header')
<style>
.col-form-label {
  text-align: right;
}
form {
  font-size: 15px;
}
.form-add {
  margin-top: 20px;
}
.btn-upfile {
  padding-right: 50px;

}
.btn-handling {
  text-align: center;
}
.btn-handling a {

  margin-right: 5px;
}
.space {
  margin-left: 10px;
}
#label-space {
  margin-left: 10px;
}
.btn-edit {
  margin-bottom: 10px;
  font-size: 15px;
}
.btn-delete {
  font-size: 15px;
}

.table {
  font-size: 10px;
}
#select-search {
  width: 200px;
}
table {
  width: 100%;
  border-spacing: 0;
  border-collapse: collapse;
}
table thead tr {
  background: #58ade5;
}
.add-table {
  margin-right: 40px;
  position: relative;
}
.add-table::before
{
  content: '';
  position: absolute;
  border-right: 2px solid #e9ecef;
  top: -14px;
  bottom: -14px;
  right: -20px;
}
.custom-export-merge::before {
  content: '';
  position: absolute;
  border-top: 1px solid #e9ecef;
  top: -30px;
  left: 0;
  right: 0;
}
.custom-export-merge {
  position: relative;
  margin-top: 50px;
}
.custom-export-table::before {
  content: '';
  position: absolute;
  border-top: 1px solid #e9ecef;
  top: -10px;
  left: 0;
  right: 0;
}
.custom-export-table {
  position: relative;
  margin-top: 50px;
}
.form-check {
  display: inline;
}
.form-c {
  margin-left: 10px;
}
.table-data {
  width: 100%;
  text-align: center;
  background: #629bf9;
  font-weight: bold;
  margin-bottom: 10px;
}
.select-data {
  margin-top: 20px;
}
.add-merge {
  padding: 10px 0;
}
.add-merge input {
  width: 100%;
  border-radius: 5px;
  border: 1px solid #ced4da;
}
.add-merge input[type=text] {
  width: 100%;
  padding: 2px 5px;

  box-sizing: border-box;
}

.item-merge {
  margin-top: 15px;
  margin-left: 48px;
  margin-right: 40px;
  margin-bottom: 20px;
  border: 1px solid #629bf9;
  padding: 10px;
  border-radius: 5px;
}
.item-merge label {
  margin-left: 8px;
}
.radio-table input{
  margin-left: 2px;
}
.radio-table label{
  margin-left: 20px;
}
.a {
  display: block;
}

.a label {
  text-align: right;
}
.container-fluid {
  height: 73%;
}
</style>
@endsection
@section('content')

<div id="content-wrapper">

  <div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="#">Dashboard</a>
      </li>
      <li class="breadcrumb-item">Thông Tin Kỷ Luật</li>
      <li class="breadcrumb-item active">Thêm từ file</li>
    </ol>
    <div class="card mb-3">
      <!-- DataTables Example -->
      <div class="card-header">
        <i class="fa fa-plus" aria-hidden="true"></i>
      Xuất thông tin kỷ luật</div>
      <div class="form-add">
        <div class="container">
          <form id="form-ex" action="{{Route('postExportTTKL')}}" method="post">
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            @if(Session::has('message'))
            <strong>Thông báo:</strong><br>

            <div class="alert alert-danger">{{Session::get('message')}}
            </div>
            @endif
            @if (count($errors) > 0)
            <div class="alert alert-danger">
              <strong>Thông báo:</strong><br>
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
            <div class="form-row">
              <div class="form-group col-md-2 offset-md-2">
                <label>Học kì</label>
                <select class="form-control" name="hocky">
                  <option value="1">I</option>
                  <option value="2">II</option>
                </select>
              </div>
              <div class="form-group col-md-2">
                <label>Năm Học</label>
                <select class="form-control" name="nam">
                  <?php 
                  $year = date('Y');
                  for($k = $year; $k > $year-6; $k--)
                  {
                   ?>
                   <option value="{{$k}}">{{$k." - ".($k+1)}}</option>
                 <?php } ?>
               </select>
             </div>
             <div class="form-group col-md-2">
              <label>Đuôi File</label>
              <select class="form-control" name="file_extension">
                <option value="xlsx">*.xlsx</option>
                <option value="xls">*.xls</option>
                <option value="csv">*.csv</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <label>Kiểu xuất</label>
              <select class="form-control" name="export_type" id="type-export">
                <option value="md" selected>Mặc định</option>
                <option value="tc">Tùy chỉnh</option>
              </select>
            </div>
          </div>
          <div class="offset-md-5">
            <button type="submit" class="btn btn-primary mb-2">Xuất ra file</button>
          </div>



      </form>
    </div>
  </div>
  <!-- /.container-fluid -->
</div>
</div>
@section('js-footer')
<script type="text/javascript">
  $(document).ready(function(){
    $('#type-export').change(function(){

      if($('#type-export').val() != 'md')
      {
        $('footer').css('margin-top', '240px');
      
        $('#form-ex').append(exportmergeInput());
        $('#form-ex').append(exportTalbe());
      }
      else
      {
        $('.custom-export-merge').remove();
        $('.custom-export-table').remove();
        $('.export-cloumn-table').remove();
        $('footer').css('margin-top', '80px');
      }
      mergerChangeInput();
    });
   
  });

  function mergerChangeInput()
  {
      $('#merge-input-number').on("change paste keyup", function(){
      var merge_number = $('#merge-input-number').val();
      if(merge_number > 100)
        merge_number = 99;
      if(Number.isInteger(parseInt(merge_number)) && parseInt(merge_number) >= 0)
      {
        $('.custom-export-merge .add-merge').remove();
        $('.custom-export-merge').append(exportmergeItem(merge_number));
      }
      else
      {
        $('.custom-export-merge .add-merge').remove();
      }

    });
  }

  function exportmergeInput()
  {
    var a = `          <div class="custom-export-merge">
           <div class="form-row">
            <div class="form-group col-md-3 offset-md-4">
              <label>Thêm Merge-Center</label>
              <input type="text" class="form-control" name="merge_number" maxlength="3" id="merge-input-number" placeholder="(Nhập số nguyên > 0 và < 100)">
            </div>
          </div>




          </div>`;
    return a;
  }

  function exportmergeItem(number)
  {
    if(number == 0)
      return '';
      var a = '';

      var i = 0;
      while(i < number)
      {
        a += `<div class="col-md-3 item-merge">
                <b>From:</b><input type="text" name="merge[`+i+`][from]" placeholder="vd: A2 (Nhập chữ Hoa)">
                <b>To:</b><input type="text" name="merge[`+i+`][to]" placeholder="vd: C6 (Nhập chữ Hoa)">
                <b>Background:</b><input type="color" name="merge[`+i+`][background]" value="#ffffff">
                <b>Color:</b><input type="color" name="merge[`+i+`][color]" value="#000000">
                <b>Text:</b><input type="text" name="merge[`+i+`][text]">
                <b>Font-Family</b><input type="text" list="font-fml" name="merge[`+i+`][font]" value="Times New Roman"/>
                <b>Font-Size</b><input type="text" list="font-size" name="merge[`+i+`][size]" value="11"/>
                <b>Font Style:</b>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="merge[`+i+`][bold]">
                  <label class="form-check-label" >
                    <b>B</b>
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="merge[`+i+`][italic]">
                  <label class="form-check-label" >
                    <i>I</i>
                  </label>
                </div>
                <div class="form-check">
                  <input class="form-check-input" type="checkbox" name="merge[`+i+`][underline]">
                  <label class="form-check-label" >
                    <u>U</u>
                  </label>
                </div>
<br>
<b>Text-align:</b>
  <div class="form-check a">
    <input class="form-check-input" type="radio" name="merge[`+i+`][text_align]"  value="left">
    <label class="form-check-label" >
      Left
    </label>
  </div>
  <div class="form-check a">
    <input class="form-check-input" type="radio" name="merge[`+i+`][text_align]"  value="center" checked>
    <label class="form-check-label" >
      Center
    </label>
  </div>
  <div class="form-check a">
    <input class="form-check-input" type="radio" name="merge[`+i+`][text_align]"  value="right">
    <label class="form-check-label" >
      Right
    </label>
  </div>
<br><b>Text-align:</b>
    <div class="form-check a">
    <input class="form-check-input" type="radio" name="merge[`+i+`][text_align_2]"  value="top">
    <label class="form-check-label" >
      Top
    </label>
  </div>
  <div class="form-check a">
    <input class="form-check-input" type="radio" name="merge[`+i+`][text_align_2]"  value="middle" checked>
    <label class="form-check-label" >
      Middle
    </label>
  </div>
  <div class="form-check a">
    <input class="form-check-input" type="radio" name="merge[`+i+`][text_align_2]"  value="bottom">
    <label class="form-check-label" >
      Bottom
    </label>
  </div>



              </div>`;
        i++;
      }

      var b = ` <div class="add-merge">
            <div class="row">

            `+a+`

            </div>`;
      return b;
  }

  function exportTalbe(){
    var a = `<div class="custom-export-table">
          <div class="table-data">
            BẢNG DỮ LIỆU
          </div>
          <div class="form-row">
            <div class="form-group col-md-3">
              <label><b>Viết từ dòng:</b> </label>
              <input type="text" class="form-control" placeholder="vd: A5 (Nhập chữ Hoa)" name="tb_wirte">
            </div>
            <div class="form-group col-md-3">
              <label><b>Font:</b> </label>
              <input type="text" class="form-control" list="font-fml" name="tb_font" value="Times New Roman"/>
              <datalist id="font-fml">
                <option>Calibri</option>
                <option>Times New Roman</option>
                <option>Times</option>
                <option>Script</option>
                <option>Arial</option>
                <option>Garamond</option>
                <option>Georgia</option>
                <option>Helvetica</option>
                <option>Impact</option>
                <option>Minion</option>
                <option>Palatino</option>
                <option>Roman</option>
              </datalist>
            </div>
            <div class="form-group col-md-2">
              <label><b>Font-Size:</b> </label>
              <input type="text" class="form-control" name="tb_font_size" list="font-size" value="11">
              <datalist id="font-size">
                <option>8</option>
                <option>9</option>
                <option>10</option>
                <option>11</option>
                <option>12</option>
                <option>14</option>
                <option>16</option>
                <option>18</option>
                <option>20</option>
                <option>22</option>
                <option>24</option>
                <option>26</option>
                <option>28</option>
                <option>36</option>
                <option>48</option>
                <option>72</option>
              </datalist>
            </div>
            <div class="form-group col-md-2">
              <label><b>Background:</b> </label>
              <input type="color" class="form-control" name="tb_background" value="#ffffff">
            </div>
            <div class="form-group col-md-2">
              <label><b>Color:</b> </label>
              <input type="color" class="form-control" name="tb_color" value="#000000">
            </div>
            <div class="form-group offset-md-1">
              <label><b>Font Style:</b> </label>
                            <div class="form-check form-c">
                <input class="form-check-input" type="checkbox" name="tb_even_odd">
                <label class="form-check-label" >
                  <b>Màu chẵn lẽ</b>
                </label>
              </div>
              <div class="form-check form-c">
                <input class="form-check-input" type="checkbox" name="tb_bold">
                <label class="form-check-label" >
                  <b>Bold</b>
                </label>
              </div>
              <div class="form-check form-c">
                <input class="form-check-input" type="checkbox" name="tb_italic">
                <label class="form-check-label" >
                  <i>Italic</i>
                </label>
              </div>
              <div class="form-check form-c">
                <input class="form-check-input" type="checkbox" name="tb_underline">
                <label class="form-check-label" >
                  <u>Underline</u>
                </label>
              </div>
            </div>

              <div class="form-check radio-table">
    <input class="form-check-input" type="radio" name="tb_text_align"  value="left">
    <label class="form-check-label" >
      Left
    </label>
  </div>
  <div class="form-check radio-table">
    <input class="form-check-input" type="radio" name="tb_text_align"  value="center" checked>
    <label class="form-check-label" >
      Center
    </label>
  </div>
  <div class="form-check radio-table">
    <input class="form-check-input" type="radio" name="tb_text_align"  value="right">
    <label class="form-check-label" >
      Right
    </label>
  </div>

                <div class="form-check radio-table">
    <input class="form-check-input" type="radio" name="tb_text_align_2"  value="top">
    <label class="form-check-label" >
      Top
    </label>
  </div>
  <div class="form-check radio-table">
    <input class="form-check-input" type="radio" name="tb_text_align_2"  value="center" checked>
    <label class="form-check-label">
      Middle
    </label>
  </div>
  <div class="form-check radio-table">
    <input class="form-check-input" type="radio" name="tb_text_align_2"  value="bottom">
    <label class="form-check-label">
      Bottom
    </label>
  </div>

        </div>
        <div class="export-cloumn-table">
          <h6>Thứ tự dữ liệu</h6>

          <div class="form-row">

            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="STT" selected>Số thứ tự</option>
              </select>
            </div>

            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code" selected>MSSV</option>
                <option value="student_fname">Họ</option>
                <option value="student_lname">Tên</option>
                <option value="student_birth">Ngày sinh</option>
                <option value="student_level_edu">Bậc đào tạo</option>
                <option value="student_type_edu">Loại hình đào tạo</option>
                <option value="class_code">Mã lớp SV</option>
                <option value="major_name">Ngành học</option>
                <option value="di_TBC">Điểm TBC</option>
                <option value="di_TCTL">Số TCTL</option>
                <option value="di_TC_debt">Số TC còn nợ</option>
                <option value="di_TBCTL">Điểm TBCTL</option>
                <option value="di_DTB10">ĐTB10</option>
                <option value="di_student_year">SV năm thứ</option>
                <option value="di_falcuty_confirm">Phản hồi Khoa</option>
                <option value="discipline_name">Tình trạng</option>
                <option value="di_note">Ghi chú</option>
                <option value="di_last_result">Kết quả trước</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code">MSSV</option>
                <option value="student_fname" selected>Họ</option>
                <option value="student_lname">Tên</option>
                <option value="student_birth">Ngày sinh</option>
                <option value="student_level_edu">Bậc đào tạo</option>
                <option value="student_type_edu">Loại hình đào tạo</option>
                <option value="class_code">Mã lớp SV</option>
                <option value="major_name">Ngành học</option>
                <option value="di_TBC">Điểm TBC</option>
                <option value="di_TCTL">Số TCTL</option>
                <option value="di_TC_debt">Số TC còn nợ</option>
                <option value="di_TBCTL">Điểm TBCTL</option>
                <option value="di_DTB10">ĐTB10</option>
                <option value="di_student_year">SV năm thứ</option>
                <option value="di_falcuty_confirm">Phản hồi Khoa</option>
                <option value="discipline_name">Tình trạng</option>
                <option value="di_note">Ghi chú</option>
                <option value="di_last_result">Kết quả trước</option>
              </select>
            </div>
             <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code">MSSV</option>
                <option value="student_fname">Họ</option>
                <option value="student_lname" selected>Tên</option>
                <option value="student_birth">Ngày sinh</option>
                <option value="student_level_edu">Bậc đào tạo</option>
                <option value="student_type_edu">Loại hình đào tạo</option>
                <option value="class_code">Mã lớp SV</option>
                <option value="major_name">Ngành học</option>
                <option value="di_TBC">Điểm TBC</option>
                <option value="di_TCTL">Số TCTL</option>
                <option value="di_TC_debt">Số TC còn nợ</option>
                <option value="di_TBCTL">Điểm TBCTL</option>
                <option value="di_DTB10">ĐTB10</option>
                <option value="di_student_year">SV năm thứ</option>
                <option value="di_falcuty_confirm">Phản hồi Khoa</option>
                <option value="discipline_name">Tình trạng</option>
                <option value="di_note">Ghi chú</option>
                <option value="di_last_result">Kết quả trước</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code">MSSV</option>
                <option value="student_fname">Họ</option>
                <option value="student_lname">Tên</option>
                <option value="student_birth" selected>Ngày sinh</option>
                <option value="student_level_edu">Bậc đào tạo</option>
                <option value="student_type_edu">Loại hình đào tạo</option>
                <option value="class_code">Mã lớp SV</option>
                <option value="major_name">Ngành học</option>
                <option value="di_TBC">Điểm TBC</option>
                <option value="di_TCTL">Số TCTL</option>
                <option value="di_TC_debt">Số TC còn nợ</option>
                <option value="di_TBCTL">Điểm TBCTL</option>
                <option value="di_DTB10">ĐTB10</option>
                <option value="di_student_year">SV năm thứ</option>
                <option value="di_falcuty_confirm">Phản hồi Khoa</option>
                <option value="discipline_name">Tình trạng</option>
                <option value="di_note">Ghi chú</option>
                <option value="di_last_result">Kết quả trước</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code">MSSV</option>
                <option value="student_fname">Họ</option>
<option value="student_lname">Tên</option>
                <option value="student_birth">Ngày sinh</option>
                <option value="student_level_edu" selected>Bậc đào tạo</option>
                <option value="student_type_edu">Loại hình đào tạo</option>
                <option value="class_code">Mã lớp SV</option>
                <option value="major_name">Ngành học</option>
                <option value="di_TBC">Điểm TBC</option>
                <option value="di_TCTL">Số TCTL</option>
                <option value="di_TC_debt">Số TC còn nợ</option>
                <option value="di_TBCTL">Điểm TBCTL</option>
                <option value="di_DTB10">ĐTB10</option>
                <option value="di_student_year">SV năm thứ</option>
                <option value="di_falcuty_confirm">Phản hồi Khoa</option>
                <option value="discipline_name">Tình trạng</option>
                <option value="di_note">Ghi chú</option>
                <option value="di_last_result">Kết quả trước</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code">MSSV</option>
                <option value="student_fname">Họ</option>
<option value="student_lname">Tên</option>
                <option value="student_birth">Ngày sinh</option>
                <option value="student_level_edu">Bậc đào tạo</option>
                <option value="student_type_edu" selected>Loại hình đào tạo</option>
                <option value="class_code">Mã lớp SV</option>
                <option value="major_name">Ngành học</option>
                <option value="di_TBC">Điểm TBC</option>
                <option value="di_TCTL">Số TCTL</option>
                <option value="di_TC_debt">Số TC còn nợ</option>
                <option value="di_TBCTL">Điểm TBCTL</option>
                <option value="di_DTB10">ĐTB10</option>
                <option value="di_student_year">SV năm thứ</option>
                <option value="di_falcuty_confirm">Phản hồi Khoa</option>
                <option value="discipline_name">Tình trạng</option>
                <option value="di_note">Ghi chú</option>
                <option value="di_last_result">Kết quả trước</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code">MSSV</option>
                <option value="student_fname">Họ</option>
<option value="student_lname">Tên</option>
                <option value="student_birth">Ngày sinh</option>
                <option value="student_level_edu">Bậc đào tạo</option>
                <option value="student_type_edu">Loại hình đào tạo</option>
                <option value="class_code" selected>Mã lớp SV</option>
                <option value="major_name">Ngành học</option>
                <option value="di_TBC">Điểm TBC</option>
                <option value="di_TCTL">Số TCTL</option>
                <option value="di_TC_debt">Số TC còn nợ</option>
                <option value="di_TBCTL">Điểm TBCTL</option>
                <option value="di_DTB10">ĐTB10</option>
                <option value="di_student_year">SV năm thứ</option>
                <option value="di_falcuty_confirm">Phản hồi Khoa</option>
                <option value="discipline_name">Tình trạng</option>
                <option value="di_note">Ghi chú</option>
                <option value="di_last_result">Kết quả trước</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code">MSSV</option>
                <option value="student_fname">Họ</option>
<option value="student_lname">Tên</option>
                <option value="student_birth">Ngày sinh</option>
                <option value="student_level_edu">Bậc đào tạo</option>
                <option value="student_type_edu">Loại hình đào tạo</option>
                <option value="class_code">Mã lớp SV</option>
                <option value="major_name" selected>Ngành học</option>
                <option value="di_TBC">Điểm TBC</option>
                <option value="di_TCTL">Số TCTL</option>
                <option value="di_TC_debt">Số TC còn nợ</option>
                <option value="di_TBCTL">Điểm TBCTL</option>
                <option value="di_DTB10">ĐTB10</option>
                <option value="di_student_year">SV năm thứ</option>
                <option value="di_falcuty_confirm">Phản hồi Khoa</option>
                <option value="discipline_name">Tình trạng</option>
                <option value="di_note">Ghi chú</option>
                <option value="di_last_result">Kết quả trước</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code">MSSV</option>
                <option value="student_fname">Họ</option>
<option value="student_lname">Tên</option>
                <option value="student_birth">Ngày sinh</option>
                <option value="student_level_edu">Bậc đào tạo</option>
                <option value="student_type_edu">Loại hình đào tạo</option>
                <option value="class_code">Mã lớp SV</option>
                <option value="major_name">Ngành học</option>
                <option value="di_TBC" selected>Điểm TBC</option>
                <option value="di_TCTL">Số TCTL</option>
                <option value="di_TC_debt">Số TC còn nợ</option>
                <option value="di_TBCTL">Điểm TBCTL</option>
                <option value="di_DTB10">ĐTB10</option>
                <option value="di_student_year">SV năm thứ</option>
                <option value="di_falcuty_confirm">Phản hồi Khoa</option>
                <option value="discipline_name">Tình trạng</option>
                <option value="di_note">Ghi chú</option>
                <option value="di_last_result">Kết quả trước</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code">MSSV</option>
                <option value="student_fname">Họ</option>
<option value="student_lname">Tên</option>
                <option value="student_birth">Ngày sinh</option>
                <option value="student_level_edu">Bậc đào tạo</option>
                <option value="student_type_edu">Loại hình đào tạo</option>
                <option value="class_code">Mã lớp SV</option>
                <option value="major_name">Ngành học</option>
                <option value="di_TBC">Điểm TBC</option>
                <option value="di_TCTL" selected>Số TCTL</option>
                <option value="di_TC_debt">Số TC còn nợ</option>
                <option value="di_TBCTL">Điểm TBCTL</option>
                <option value="di_DTB10">ĐTB10</option>
                <option value="di_student_year">SV năm thứ</option>
                <option value="di_falcuty_confirm">Phản hồi Khoa</option>
                <option value="discipline_name">Tình trạng</option>
                <option value="di_note">Ghi chú</option>
                <option value="di_last_result">Kết quả trước</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code">MSSV</option>
                <option value="student_fname">Họ</option>
<option value="student_lname">Tên</option>
                <option value="student_birth">Ngày sinh</option>
                <option value="student_level_edu">Bậc đào tạo</option>
                <option value="student_type_edu">Loại hình đào tạo</option>
                <option value="class_code">Mã lớp SV</option>
                <option value="major_name">Ngành học</option>
                <option value="di_TBC">Điểm TBC</option>
                <option value="di_TCTL">Số TCTL</option>
                <option value="di_TC_debt" selected>Số TC còn nợ</option>
                <option value="di_TBCTL">Điểm TBCTL</option>
                <option value="di_DTB10">ĐTB10</option>
                <option value="di_student_year">SV năm thứ</option>
                <option value="di_falcuty_confirm">Phản hồi Khoa</option>
                <option value="discipline_name">Tình trạng</option>
                <option value="di_note">Ghi chú</option>
                <option value="di_last_result">Kết quả trước</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code">MSSV</option>
                <option value="student_fname">Họ</option>
<option value="student_lname">Tên</option>
                <option value="student_birth">Ngày sinh</option>
                <option value="student_level_edu">Bậc đào tạo</option>
                <option value="student_type_edu">Loại hình đào tạo</option>
                <option value="class_code">Mã lớp SV</option>
                <option value="major_name">Ngành học</option>
                <option value="di_TBC">Điểm TBC</option>
                <option value="di_TCTL">Số TCTL</option>
                <option value="di_TC_debt">Số TC còn nợ</option>
                <option value="di_TBCTL" selected>Điểm TBCTL</option>
                <option value="di_DTB10">ĐTB10</option>
                <option value="di_student_year">SV năm thứ</option>
                <option value="di_falcuty_confirm">Phản hồi Khoa</option>
                <option value="discipline_name">Tình trạng</option>
                <option value="di_note">Ghi chú</option>
                <option value="di_last_result">Kết quả trước</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code">MSSV</option>
                <option value="student_fname">Họ</option>
<option value="student_lname">Tên</option>
                <option value="student_birth">Ngày sinh</option>
                <option value="student_level_edu">Bậc đào tạo</option>
                <option value="student_type_edu">Loại hình đào tạo</option>
                <option value="class_code">Mã lớp SV</option>
                <option value="major_name">Ngành học</option>
                <option value="di_TBC">Điểm TBC</option>
                <option value="di_TCTL">Số TCTL</option>
                <option value="di_TC_debt">Số TC còn nợ</option>
                <option value="di_TBCTL">Điểm TBCTL</option>
                <option value="di_DTB10" selected>ĐTB10</option>
                <option value="di_student_year">SV năm thứ</option>
                <option value="di_falcuty_confirm">Phản hồi Khoa</option>
                <option value="discipline_name">Tình trạng</option>
                <option value="di_note">Ghi chú</option>
                <option value="di_last_result">Kết quả trước</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code">MSSV</option>
                <option value="student_fname">Họ</option>
<option value="student_lname">Tên</option>
                <option value="student_birth">Ngày sinh</option>
                <option value="student_level_edu">Bậc đào tạo</option>
                <option value="student_type_edu">Loại hình đào tạo</option>
                <option value="class_code">Mã lớp SV</option>
                <option value="major_name">Ngành học</option>
                <option value="di_TBC">Điểm TBC</option>
                <option value="di_TCTL">Số TCTL</option>
                <option value="di_TC_debt">Số TC còn nợ</option>
                <option value="di_TBCTL">Điểm TBCTL</option>
                <option value="di_DTB10">ĐTB10</option>
                <option value="di_student_year" selected>SV năm thứ</option>
                <option value="di_falcuty_confirm">Phản hồi Khoa</option>
                <option value="discipline_name">Tình trạng</option>
                <option value="di_note">Ghi chú</option>
                <option value="di_last_result">Kết quả trước</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code">MSSV</option>
                <option value="student_fname">Họ</option>
<option value="student_lname">Tên</option>
                <option value="student_birth">Ngày sinh</option>
                <option value="student_level_edu">Bậc đào tạo</option>
                <option value="student_type_edu">Loại hình đào tạo</option>
                <option value="class_code">Mã lớp SV</option>
                <option value="major_name">Ngành học</option>
                <option value="di_TBC">Điểm TBC</option>
                <option value="di_TCTL">Số TCTL</option>
                <option value="di_TC_debt">Số TC còn nợ</option>
                <option value="di_TBCTL">Điểm TBCTL</option>
                <option value="di_DTB10">ĐTB10</option>
                <option value="di_student_year">SV năm thứ</option>
                <option value="di_falcuty_confirm" selected>Phản hồi Khoa</option>
                <option value="discipline_name">Tình trạng</option>
                <option value="di_note">Ghi chú</option>
                <option value="di_last_result">Kết quả trước</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code">MSSV</option>
                <option value="student_fname">Họ</option>
<option value="student_lname">Tên</option>
                <option value="student_birth">Ngày sinh</option>
                <option value="student_level_edu">Bậc đào tạo</option>
                <option value="student_type_edu">Loại hình đào tạo</option>
                <option value="class_code">Mã lớp SV</option>
                <option value="major_name">Ngành học</option>
                <option value="di_TBC">Điểm TBC</option>
                <option value="di_TCTL">Số TCTL</option>
                <option value="di_TC_debt">Số TC còn nợ</option>
                <option value="di_TBCTL">Điểm TBCTL</option>
                <option value="di_DTB10">ĐTB10</option>
                <option value="di_student_year">SV năm thứ</option>
                <option value="di_falcuty_confirm">Phản hồi Khoa</option>
                <option value="discipline_name" selected>Tình trạng</option>
                <option value="di_note">Ghi chú</option>
                <option value="di_last_result">Kết quả trước</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code">MSSV</option>
                <option value="student_fname">Họ</option>
<option value="student_lname">Tên</option>
                <option value="student_birth">Ngày sinh</option>
                <option value="student_level_edu">Bậc đào tạo</option>
                <option value="student_type_edu">Loại hình đào tạo</option>
                <option value="class_code">Mã lớp SV</option>
                <option value="major_name">Ngành học</option>
                <option value="di_TBC">Điểm TBC</option>
                <option value="di_TCTL">Số TCTL</option>
                <option value="di_TC_debt">Số TC còn nợ</option>
                <option value="di_TBCTL">Điểm TBCTL</option>
                <option value="di_DTB10">ĐTB10</option>
                <option value="di_student_year">SV năm thứ</option>
                <option value="di_falcuty_confirm">Phản hồi Khoa</option>
                <option value="discipline_name">Tình trạng</option>
                <option value="di_note" selected>Ghi chú</option>
                <option value="di_last_result">Kết quả trước</option>
              </select>
            </div>
            <div class="form-group col-md-2">
              <select class="form-control" name="localti[]">
                <option value="student_code">MSSV</option>
                <option value="student_fname">Họ</option>
<option value="student_lname">Tên</option>
                <option value="student_birth">Ngày sinh</option>
                <option value="student_level_edu">Bậc đào tạo</option>
                <option value="student_type_edu">Loại hình đào tạo</option>
                <option value="class_code">Mã lớp SV</option>
                <option value="major_name">Ngành học</option>
                <option value="di_TBC">Điểm TBC</option>
                <option value="di_TCTL">Số TCTL</option>
                <option value="di_TC_debt">Số TC còn nợ</option>
                <option value="di_TBCTL">Điểm TBCTL</option>
                <option value="di_DTB10">ĐTB10</option>
                <option value="di_student_year">SV năm thứ</option>
                <option value="di_falcuty_confirm">Phản hồi Khoa</option>
                <option value="discipline_name">Tình trạng</option>
                <option value="di_note">Ghi chú</option>
                <option value="di_last_result" selected>Kết quả trước</option>
              </select>
            </div>

          </div>


        </div>`;
        return a;
  }
</script>
@stop
@stop