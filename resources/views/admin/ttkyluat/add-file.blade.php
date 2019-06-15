@extends('admin.layout.master')
@section('title')
Thêm từ file | thông tin kỷ luật
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
.btn-question {
  font-size: 20px;
  color: #58ade5;
  text-align: center;
}
.form-add {
  border-bottom: 5px solid;
  border-image:   linear-gradient(to right, blue 50%, yellow 50%, yellow 50%,red 50%, red 50%, green 50%) 5;
  margin-bottom: 20px;
}

#label-form {
  font-weight: bold;
}

#btn-ghi-de {
  background: #dc3545;
}
.card-body .table-responsive h4 {
  text-align: center;
}
.row_question {
  color: red;
  font-size: 10px;
  cursor: pointer;
}
#required-value {
  color: red;
  font-weight: bold;
}
</style>
@endsection
@section('content')

<div id="content-wrapper">

  <div class="container-fluid">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{url('/admin/index')}}">Dashboard</a>
      </li>
      <li class="breadcrumb-item"><a href="{{url('/admin/disciplinary-information/list')}}">Thông Tin Kỷ Luật</a></li>
      <li class="breadcrumb-item active">Thêm từ file</li>
    </ol>
    <div class="card mb-3">
      <!-- DataTables Example -->
      <div class="card-header">
        <a href="{{Route('downLoadTTKLTemp')}}">
          <i class="fas fa-download"></i>
      Tải bảng mẫu tại đây
        </a></div>
        <div class="form-add">
          <div class="container">
            <form id="form-upload" action="{{Route('importExcelTTKL')}}" method="post" enctype="multipart/form-data">
            @if(Session::has('identicalArray'))
                <?php $identicalArray = Session::get('identicalArray'); 
                  Session::forget('identicalArray');
                ?>
            @endif

             @if(Session::has('success'))
             <strong>Thông báo:</strong><br>
             <div class="alert alert-success">{{Session::get('success')}}
             </div>
             @endif
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
            <input type="hidden" name="_token" value="{{csrf_token()}}">
            <div class="form-row">
              <div class="form-group col-md-2 offset-md-1">
                <label id="label-form">Đọc Sheet số <span class="row_question" id="select_index_question"><i class="fas fa-question"></i></span></label>
                <select name="select_index" id="select-index" class="form-control">
                  <?php 
                  for($i = 1; $i < 10; $i++)
                  {
                    echo '<option value="'.$i.'">'.$i.'</option>';
                  }
                  ?>
                </select>
              </div>
              <div class="form-group col-md-2">
                <label for="inputState" id="label-form">Đọc từ dòng <span class="row_question" id="read_row_question"><i class="fas fa-question"></i></span></label>
                <input type="text" class="form-control" name="read_row" id="read-row" value="0">
              </div>
              <div class="form-group col-md-2">
                <label for="inputZip" id="label-form">Số quyết định<span id="required-value">*</span></label>
                <input type="text" class="form-control" name="di_dicision" id="di_dicision">
              </div>
              <div class="form-group col-md-2">
                <label for="inputZip" id="label-form">Học kỳ<span id="required-value">*</span></label>
                <select id="inputState" name="di_semester" class="form-control">
                  <option value="1">HKI</option>
                  <option value="2">HKII</option>
                </select>
              </div>
              <div class="form-group col-md-2">
                <label for="inputZip" id="label-form">Năm Học<span id="required-value">*</span></label>
                <select id="inputState" name="di_year" class="form-control">
                  <?php 
                  $year = date('Y');
                  for($k = $year; $k > $year-6; $k--)
                  {
                   ?>
                   <option value="{{$k}}">{{$k." - ".($k+1)}}</option>
                 <?php } ?>
               </select>
             </div>
           </div>

           <div class="form-row">
            <div class="form-group col-md-4 offset-md-4">
              <label for="inputCity" id="label-form">Chọn tệp (*.xls, *.xlsx, *.csv)</label>
              <input type="file" name="file_excel" class="form-control-file" id="file_excel">
            </div>
          </div>
          <div class="form-row">
            <div class="form-group col-md-4 offset-md-5">
              <button type="submit" class="btn btn-primary">Upload</button>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="form-group btn-handling">
       @if(isset($identicalArray))
       <a href="{{route('updateDataToDataBase')}}" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn ghi đè dữ liệu này lên dữ liệu cũ?');" id="btn-ghi-de">Ghi đè Dữ Liệu</a>
        @endif
      
      <a href="{{route('updateDataToDataBaseQuestion')}}" class="btn btn-primary" onclick="return confirm('Nhập dữ liệu lên Cơ sở dữ liệu?');">Nhập Dữ Liệu Tạm Lên CSDL</a>
      <a href="{{route('deleteAllFromFile')}}" class="btn btn-primary" onclick="return confirm('Xóa tất cả dữ liệu tạm thời?');">Xóa Dữ Liệu Tạm</a>
    </div>
    <!-- /.container-fluid -->

    <div class="card-body">
      <div class="table-responsive">
        <!--Search-->
        <h4>BẢNG DỮ LIỆU TẠM THỜI</h4>
        <!--end - search -->
        <table class="table table-bordered table-striped">
          <thead>
            <tr>
              <th>Thao tác</th>
              <th>STT</th>
              <th>Mã Sinh Viên</th>
              <th>Họ & Tên</th>
              <th>Ngày Sinh</th>
              <th>Bậc Đào Tạo</th>
              <th>Loại hình đào tạo</th>
              <th>Mã Lớp</th>
              <th>Ngành Học</th>
              <th>Điểm TBC</th>
              <th>Số TCTL</th>
              <th>Số TC còn nợ</th>
              <th>Điểm TBCTL</th>
              <th>ĐTB10</th>
              <th>SV năm thứ</th>
              <th>Phản hồi từ Khoa</th>
              <th>Tình Trạng</th>
              <th>Ghi chú</th>
              <th>Kết quả trước</th>
            </tr>
          </thead>
          <tbody>
            @if(count($data) > 0)
            <?php $i = 0; ?>
            @foreach($data as $value)
            <tr>
              <td><span class="btn btn-primary btn-edit" onclick="editStudent(<?php echo $i; ?>);"><i class="far fa-edit"></i></span>
                <a class="btn btn-primary btn-delete" href="{{route('deleteStudentEx', $i)}}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="far fa-trash-alt"></i></a></td>

                <td>{{++$i}}</td>
                <td>{{$value['student_code']}}</td>
                <td>{{$value['student_name']}}</td>
                <td>{{$value['student_birth']}}</td>
                <td>{{$value['student_level_edu']}}</td>
                <td>{{$value['student_type_edu']}}</td>
                <td>{{$value['class_code']}}</td>
                <td>{{$value['major_name']}}</td>
                <td>{{$value['di_TBC']}}</td>
                <td>{{$value['di_TCTL']}}</td>
                <td>{{$value['di_TC_debt']}}</td>
                <td>{{$value['di_TBCTL']}}</td>
                <td>{{$value['di_DTB10']}}</td>
                <td>{{$value['di_student_year']}}</td>
                <td>{{$value['di_falcuty_confirm']}}</td>
                <td>{{$value['discipline_name']}}</td>
                <td>{{$value['di_note']}}</td>
                <td>{{$value['di_last_result']}}</td>
              </tr>
              @endforeach
              @endif
            </tbody>
          </table>
          <!-- Modal -->
          <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel">Tại sao lại báo lỗi màu đỏ?</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body modal-body-error-message">
                  ...
                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                </div>
              </div>
            </div>
          </div>

          <!--Model change student informaiton-->
          <div class="modal fade" id="modal-edit" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel2" aria-hidden="true">
            <div class="modal-dialog" role="document">
              <div class="modal-content">
                <div class="modal-header">
                  <h5 class="modal-title" id="exampleModalLabel2">Thay đổi thông tin</h5>
                  <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                  </button>
                </div>
                <div class="modal-body modal-body-edit-student">

                </div>
                <div class="modal-footer">
                  <button type="button" class="btn btn-secondary" data-dismiss="modal">Hủy</button>
                  <button type="button" class="btn btn-primary" onclick="save()">Thay đổi</button>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>


  @section('js-footer')
  <script type="text/javascript">
    $(document).ready(function(){
      checkError();
    });

    function checkError()
    {
      for(var i = 0; i < $('tbody tr').length; i++)
      {
        if(isNaN(getTd3(i, 9).text()))
          errorV(i, 9);

        if(isNaN(getTd3(i, 10).text()))
          errorV(i, 10);

        if(isNaN(getTd3(i, 11).text()))
          errorV(i, 11);

        if(isNaN(getTd3(i, 12).text()))
          errorV(i, 12);

        if(isNaN(getTd3(i, 13).text()))
          errorV(i, 13);

        if(!isValidDate(getTd3(i, 4).text()) && !isValidDate2(getTd3(i, 4).text()))
          errorV(i, 4);

        if(getTd3(i, 2).text().length <= 6)
          errorV(i, 2);

        if(getTd3(i, 3).text().length <= 1)
          errorV(i, 3);

        if(getTd3(i, 5).text().length <= 0 || getTd3(i, 5).text() == 'null')
          errorV(i, 5);

        if(getTd3(i, 6).text().length <= 0 || getTd3(i, 6).text() == 'null')
          errorV(i, 6);

        if(getTd3(i, 14).text().length <= 0 || getTd3(i, 14).text() == 'null')
          errorV(i, 14);

      }
      $('#form-upload').submit(function(e){
        var value = $('#read-row').val();
        if(!Number.isInteger(parseInt(value)) || !Number.isInteger(parseInt($('#select-index').val())))
        {
          alert('"Đọc dữ liệu từ dòng" phải là số nguyên!');
          return false;
        }
        if($('#di_dicision').val().length <= 0 || parseInt($('#di_dicision').val()) < 0)
        {
          alert('"Số quyết định" không được để trống!');
          return false;
        }
      });
      $('input[type="file"]').change(function(e){
            var fileName = e.target.files[0].name;
            extensions = fileName.split('.').pop();
            switch(extensions)
            {
              case 'xlsx':
                break;
              case 'xls':
                break;
              case 'csv':
                break;
              default:
                alert('Chỉ đọc được file có đuôi là *.xlsx, *.xls, *.csv');

            }
        });
      $('#read_row_question').click(function(){
        alert('Đọc dữ liệu từ dòng bao nhiêu? nếu đọc cả file hãy để yên số 0');
      });
      $('#select_index_question').click(function(){
        alert('Đọc dữ liệu từ worksheet thứ mấy trong file excel được chọn?');
      });
    }


    function errorV(i, j)
    {
      getTd3(i, j).css('background', '#e8766c');
      $('.modal-body-error-message').html(`
        1. Tại sao cột ngày sinh của sinh viên báo màu đỏ?<br>
        + Định dạng 1: dd/MM/YYYY (05/05/2019)<br>
        + Định dạng 2: dd-MM-YYYY (05-05-2019)<br><br>


        2. Tại sao cột điểm TBC hoặc Số TCTL hoặc Số TC còn nợ hoặc Điểm TBCTL hoặc ĐTB10 báo màu đỏ?<br>
        + Phải là số nguyên hoặc số thực.<br><br>

        3. Tại sao cột mã sinh viên báo đỏ?<br>
        + MSSV phải lớn hơn 6 kí tự<br><br>

        4. Các trường bắt buộc:<br>
        + Bậc Đào Tạo<br>
        + Loại hình đào tạo<br>
        + SV năm thứ 
        <br><br>
        `);
      getTd3(i, j).append(`<br><a href="#" data-toggle="modal" data-target="#exampleModal" class="btn-question"><i class="fas fa-question"></i></a>`);
    }

    function getTd3(i, j)
    {
      return $('tbody tr').eq(i).children().eq(j);
    }
    function isValidDate(sText) {
      var reDate = /^([0-2][0-9]|(3)[0-1])(\/)(((0)[0-9])|((1)[0-2]))(\/)\d{4}$/;
      return reDate.test(sText);
    }
    function isValidDate2(sText) {
      var reDate = /^([0-2][0-9]|(3)[0-1])(\-)(((0)[0-9])|((1)[0-2]))(\-)\d{4}$/;
      return reDate.test(sText);
    }

    function editStudent(id)
    {
      let url = "{{ route('editStudentInJson', ':id') }}";
      url = url.replace(':id', id);
      $.ajax({
        url: url,
        dataType: "JSON",
        success: function (response) {
          var edit_id = response.edit_id;
          // console.log(response);
              //----------------Major select-------------\\
              var major = <?php echo json_encode($major); ?>;
              var major_front = `<div class="form-group row">
              <label class="col-sm-4 col-form-label">Ngành học</label>
              <div class="col-sm-7 mr-md-auto">
              <select class="form-control" name="major_id" id="major-id">`;
              var back = `</select>
              </div>
              </div>`;

              var major_html = getOntion(major, 'major_id', 'major_name', major_front, back,response.major_id);
              //--------------Class select----------------\\
              var class_tb = <?php echo json_encode($class); ?>;
              var class_front = `<div class="form-group row">
              <label class="col-sm-4 col-form-label">Mã lớp</label>
              <div class="col-sm-7 mr-md-auto">
              <select class="form-control" name="class_id" id="class-id">`;
              var class_html = getOntion(class_tb, 'class_id', 'class_name', class_front, back,response.class_id);
              //---------------Discipline select------------\\
              var discipline = <?php echo json_encode($discipline); ?>;
              var discipline_font = `<div class="form-group row">
              <label class="col-sm-4 col-form-label">Tình Trạng</label>
              <div class="col-sm-7 mr-md-auto">
              <select class="form-control" name="discipline_id" id="discipline-id">`;
              var discipline_html = getOntion(discipline, 'discipline_id', 'discipline_name', discipline_font, back,response.discipline_id);
               //---------------Semester select------------\\
               var semester_html = `<div class="form-group row">
               <label class="col-sm-4 col-form-label">Học kỳ</label>
               <div class="col-sm-7 mr-md-auto">
               <select class="form-control" name="di_semester" id="di-semester">`;
               if(response.di_semester == 1)
               {
                semester_html +=`<option value="1" selected>I</option>`;
                semester_html += `<option value="2">II</option>`;
              } else {
                semester_html +=`<option value="1">I</option>`;
                semester_html += `<option value="2" selected>II</option>`;
              }
              semester_html += back;
              //---------------Year select------------\\
              var year_html = `<div class="form-group row">
              <label class="col-sm-4 col-form-label">Năm học</label>
              <div class="col-sm-7 mr-md-auto">
              <select class="form-control" name="di_year" id="di-year">`;
              var date = <?php echo date('Y'); ?>;
              var selected = "selected";
              for(var k = date; k > (date-6); k--)
              {
                if(response.di_year == k)
                  {year_html += `<option value="`+k+`" `+selected+`>`+ k + `-` + (k+1) +`</option>`;}
                else
                  {year_html += `<option value="`+k+`">`+ k + `-` + (k+1) +`</option>`;}
              }
              year_html += back;
              //--------------------------------------------------------------------------------\\
              
              var di_falcuty_confirm = (response.di_falcuty_confirm == null) ? "" : response.di_falcuty_confirm;
              $('.modal-body-edit-student').html(`
                <input type="hidden" id="edit-id" value="`+edit_id+`">
                <div class="form-group row">
                <label class="col-sm-4 col-form-label">Mã sinh viên</label>
                <div class="col-sm-7 mr-md-auto">
                <input type="text" class="form-control" name="student_code" id="student-code" value="`+response.student_code+`">
                </div>
                </div>

                <div class="form-group row">
                <label class="col-sm-4 col-form-label">Tên sinh viên</label>
                <div class="col-sm-7 mr-md-auto">
                <input type="text" class="form-control" name="student_name" id="student-name" value="`+response.student_name+`">
                </div>
                </div>

                <div class="form-group row">
                <label class="col-sm-4 col-form-label">Ngày sinh</label>
                <div class="col-sm-7 mr-md-auto">
                <input type="text" class="form-control" name="student_birth" id="student-birth" value="`+response.student_birth+`">
                </div>
                </div>

                <div class="form-group row">
                <label class="col-sm-4 col-form-label">Bậc đào tạo</label>
                <div class="col-sm-7 mr-md-auto">
                <input type="text" class="form-control" name="student_level_edu" id="student-level-edu" value="`+response.student_level_edu+`">
                </div>
                </div>

                <div class="form-group row">
                <label class="col-sm-4 col-form-label">Loại hình đào tạo</label>
                <div class="col-sm-7 mr-md-auto">
                <input type="text" class="form-control" name="student_type_edu" id="student-type-edu" value="`+response.student_type_edu+`">
                </div>
                </div>
                `+major_html+`
                `+
                class_html
                +`
                <div class="form-group row">
                <label class="col-sm-4 col-form-label">Điểm TBC</label>
                <div class="col-sm-7 mr-md-auto">
                <input type="text" class="form-control" name="di_TBC" id="di-TBC" value="`+response.di_TBC+`">
                </div>

                </div>
                <div class="form-group row">
                <label class="col-sm-4 col-form-label">Số TCTL</label>
                <div class="col-sm-7 mr-md-auto">
                <input type="text" class="form-control" name="di_TCTL" id="di-TCTL" value="`+response.di_TCTL+`">
                </div>
                </div>

                <div class="form-group row">
                <label class="col-sm-4 col-form-label">Số TC còn nợ</label>
                <div class="col-sm-7 mr-md-auto">
                <input type="text" class="form-control" name="di_TC_debt" id="di-TC-debt" value="`+response.di_TC_debt+`">
                </div>
                </div>

                <div class="form-group row">
                <label class="col-sm-4 col-form-label">Điểm TBCTL</label>
                <div class="col-sm-7 mr-md-auto">
                <input type="text" class="form-control" name="di_TBCTL" id="di-TBCTL" value="`+response.di_TBCTL+`">
                </div>
                </div>

                <div class="form-group row">
                <label class="col-sm-4 col-form-label">ĐTB10</label>
                <div class="col-sm-7 mr-md-auto">
                <input type="text" class="form-control" name="di_DTB10" id="di-DTB10" value="`+response.di_DTB10+`">
                </div>
                </div>

                <div class="form-group row">
                <label class="col-sm-4 col-form-label">SV năm thứ</label>
                <div class="col-sm-7 mr-md-auto">
                <input type="text" class="form-control" name="di_student_year" id="di-student-year" value="`+response.di_student_year+`">
                </div>
                </div>

                <div class="form-group row">
                <label class="col-sm-4 col-form-label">Phản hồi từ Khoa</label>
                <div class="col-sm-7 mr-md-auto">
                <textarea class="form-control" name="di_falcuty_confirm" id="di-falcuty-confirm">`+di_falcuty_confirm+`</textarea>
                </div>
                </div>

                
                `+discipline_html+`

                <div class="form-group row">
                <label class="col-sm-4 col-form-label">Ghi chú</label>
                <div class="col-sm-7 mr-md-auto">
                <input type="text" class="form-control" name="di_note" id="di-note" value="`+response.di_note+`">
                </div>
                </div>

                <div class="form-group row">
                <label class="col-sm-4 col-form-label">Kết quả trước</label>
                <div class="col-sm-7 mr-md-auto">
                <textarea class="form-control" name="di_last_result" id="di-last-result">`+response.di_last_result+`</textarea>
                </div>
                </div>

                <div class="form-group row">
                <label class="col-sm-4 col-form-label">Số quyết định</label>
                <div class="col-sm-7 mr-md-auto">
                <input type="text" class="form-control" name="di_dicision" id="di-dicision" value="`+response.di_dicision+`">
                </div>
                </div>
                `+semester_html+ year_html +`
                `);
$('#modal-edit').modal('toggle');
}
});

}
function getOntion(array, id, name, front, back,resp_id)
{
  for(var i = 0; i < array.length; i++)
  {
    if(array[i][id] == resp_id)
    {
      front += `<option value="`+array[i][id]+`" selected>`+array[i][name]+`</option>`;
    }
    else
    {
      front += `<option value="`+array[i][id]+`">`+array[i][name]+`</option>`;
    }
  }
  return front + back;
}

function save()
{
  var edit_id = $('#edit-id').val();
  var student_code = $('#student-code').val();
  var student_name = $('#student-name').val();
  var student_birth = $('#student-birth').val();
  var student_level_edu = $('#student-level-edu').val();
  var student_type_edu = $('#student-type-edu').val();
  var class_id = $('#class-id').val();
  var major_id = $('#major-id').val();
  var di_TBC = $('#di-TBC').val();
  var di_TCTL = $('#di-TCTL').val();
  var di_TC_debt = $('#di-TC-debt').val();
  var di_TBCTL = $('#di-TBCTL').val();
  var di_DTB10 = $('#di-DTB10').val();
  var di_student_year = $('#di-student-year').val();
  var di_falcuty_confirm = $('#di-falcuty-confirm').val();
  var discipline_id = $('#discipline-id').val();
  var di_note = $('#di-note').val();
  var di_last_result = $('#di-last-result').val();
  var di_dicision = $('#di-dicision').val();
  var di_semester = $('#di-semester').val();
  var di_year = $('#di-year').val();
  var array = {"edit_id":edit_id, "student_code":student_code, "student_name":student_name, "student_birth":student_birth, "student_level_edu":student_level_edu, "student_type_edu":student_type_edu, "class_id":class_id, "major_id": major_id, "di_TBC":di_TBC, "di_TCTL":di_TCTL, "di_TC_debt":di_TC_debt, "di_TBCTL":di_TBCTL, "di_DTB10":di_DTB10, "di_student_year":di_student_year, "di_falcuty_confirm":di_falcuty_confirm, "discipline_id":discipline_id, "di_note":di_note, "di_last_result":di_last_result, "di_dicision": di_dicision, "di_semester":di_semester, "di_year": di_year};
 
  let url = "{{route('posteditStudentInJson')}}";

  $.ajax({
    type: "GET",
    url: url,
    data: array,
    dataType: "JSON",
    success: function (value) {
      var i = 0;
      var a = '';

      for(var i; i < value.length; i++)
      {
        a += `<tr>
        <td><span class="btn btn-primary btn-edit" onclick="editStudent(`+i+`);"><i class="far fa-edit"></i></span>
        <a class="btn btn-primary btn-delete" href="{{route('deleteStudentEx', `+i+`)}}" onclick="return confirm('Are you sure you want to delete this item?');"><i class="far fa-trash-alt"></i></a></td>

        <td>`+(i+1)+`</td>
        <td>`+value[i].student_code+`</td>
        <td>`+value[i].student_name+`</td>
        <td>`+value[i].student_birth+`</td>
        <td>`+value[i].student_level_edu+`</td>
        <td>`+value[i].student_type_edu+`</td>
        <td>`+value[i].class_code+`</td>
        <td>`+value[i].major_name+`</td>
        <td>`+value[i].di_TBC+`</td>
        <td>`+value[i].di_TCTL+`</td>
        <td>`+value[i].di_TC_debt+`</td>
        <td>`+value[i].di_TBCTL+`</td>
        <td>`+value[i].di_DTB10+`</td>
        <td>`+value[i].di_student_year+`</td>
        <td>`+value[i].di_falcuty_confirm+`</td>
        <td>`+value[i].discipline_name+`</td>
        <td>`+value[i].di_note+`</td>
        <td>`+value[i].di_last_result+`</td>
        </tr>`;
      }
      $('tbody').html(a);
      checkError();
      alert('Thay đổi thành công');
    }
  });
  $('#modal-edit').modal('hide');
}


</script>
@stop
@stop