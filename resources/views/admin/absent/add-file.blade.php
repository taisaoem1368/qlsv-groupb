@extends('admin.layout.master')
@section('title')
Thêm từ file | chuyên cần sinh viên
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
  border-bottom: 1px solid #d8d8d8;
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
      <li class="breadcrumb-item"><a href="{{url('/admin/absent/list')}}">Chuyên Cần</a></li>
      <li class="breadcrumb-item active">Thêm từ file</li>
    </ol>
    <div class="card mb-3">
      <!-- DataTables Example -->
          <div class="card-header">
            <a href="{{Route('downloadAnsentTemp')}}">
          <i class="fas fa-download"></i>
      Tải bảng mẫu tại đây
        </a></div>
        <div class="form-add">
          <div class="container">
            <form id="form-upload" action="{{Route('importExcelAbsent')}}" method="post" enctype="multipart/form-data">
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
              <div class="form-group col-md-2 offset-md-2">
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
                <label id="label-form">Học kỳ</label>
                <select name="ai_semester" class="form-control">
                  <option value="1">HKI</option>
                  <option value="2">HKII</option>
                </select>
              </div>
              <div class="form-group col-md-2">
                <label id="label-form">Năm Học</label>
                <select name="ai_year" class="form-control">
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
      @if(Session::has('identicalArray'))
      <?php $identicalArray = Session::get('identicalArray'); 
      Session::forget('identicalArray');
      ?>
      @endif
       @if(isset($identicalArray))
       <a href="{{route('UpdateDataJsonFileToDataBase')}}" class="btn btn-primary" onclick="return confirm('Bạn có chắc chắn ghi đè dữ liệu này lên dữ liệu cũ?');" id="btn-ghi-de">Ghi đè Dữ Liệu</a>
        @endif
      
      <a href="{{route('UpdateDataJsonFileToDataBaseQuestion')}}" class="btn btn-primary" onclick="return confirm('Nhập dữ liệu tạm lên Cơ sở dữ liệu?');">Nhập Dữ Liệu Tạm Lên CSDL</a>
      <a href="{{route('getDeleteJsonAbsent')}}" class="btn btn-primary" onclick="return confirm('Xóa tất cả dữ liệu tạm thời?');">Xóa Dữ Liệu Tạm</a>
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
              <th>STT</th>
              <th>Mã Sinh Viên</th>
              <th>Họ & Tên</th>
              <th>Mã Lớp</th>
              <th>Số tiếc vắng</th>
              <th>Tình trạng</th>
            </tr>
          </thead>
          <tbody>
            @if(count($data) > 0)
            <?php $i = 0; ?>
            @foreach($data as $value)
            <tr>
                <td>{{++$i}}</td>
                <td>{{$value['student_code']}}</td>
                <td>{{$value['student_name']}}</td>
                <td>{{$value['class_code']}}</td>
                <td>{{$value['ai_absences']}}</td>
                <td>{{$value['discipline_name']}}</td>
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


  
@stop