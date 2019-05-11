@extends('admin.layout.master')
@section('title')
Class - Import dữ liệu từ file excel
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
  font-size: 15px;
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
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item"><a href="{{url('/admin/class/list')}}">Lớp</a></li>
          <li class="breadcrumb-item active">Thêm từ file</li>
        </ol>
      <div class="card mb-3">
        <!-- DataTables Example -->
          <div class="card-header">
            <a href="{{Route('downLoadClassTemp')}}">
          <i class="fas fa-download"></i>
      Tải bảng mẫu tại đây
        </a></div>
        <div class="form-add">
          <div class="container">
            <form id="form-upload" action="{{Route('postClassImportExcel')}}" method="post" enctype="multipart/form-data">
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
              <div class="form-group col-md-2 offset-md-3">
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
                          <div class="form-group col-md-4">
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
     
      <a href="{{route('postAddJsonToDataBase')}}" class="btn btn-primary" onclick="return confirm('Nhập dữ liệu lên Cơ sở dữ liệu?');">Nhập Dữ Liệu</a>
      <a href="{{route('deleteClassJson')}}" class="btn btn-primary" onclick="return confirm('Xóa tất cả dữ liệu tạm thời?');">Xóa Dữ Liệu</a>
    </div>

       <div class="card-body">
            <div class="table-responsive">
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                        <th>STT</th>
                        <th>Tên Lớp</th>
                        <th>Mã Lớp</th>
                        <th>GV/CVHT</th>
                        <th>Khóa Học</th>
                        <th>Ngành</th>
                  </tr>
                </thead>
                <tbody>
                  @if(count($data) > 0)
                  <?php $i = 0; ?>
                  @foreach($data as $value)
                    <tr>
                        <td>{{++$i}}</td>
                        <td>{{$value['class_name']}}</td>
                        <td>{{$value['class_code']}}</td>
                        <td>{{$value['teacher_fullname']}}</td>
                        <td>{{$value['course_code']}}</td>
                        <td>{{$value['major_name']}}</td>
                    </tr>
                  @endforeach
                  @endif
                </tbody>
              </table>
            </div>
          </div>
            </div>
          </div>


      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
    <!-- /.content-wrapper -->

  @stop