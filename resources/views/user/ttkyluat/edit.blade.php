@extends('user.layout.master')
@section('title')
Thay đổi phản hồi
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
table {
  width: 100%;
  border-spacing: 0;
  border-collapse: collapse;
}
table thead tr {
  background: #58ade5;
}
.table {
  font-size: 10px;
}
.margin-bt {
  margin-bottom: 120px;
}

</style>
<link rel="stylesheet" type="text/css" href="{{asset('/css/ttkl-tables.css')}}">
@endsection
@section('content')

    <div id="content-wrapper">

      <div class="container-fluid margin-bt">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{url('user/index')}}">Dashboard</a>
          </li>
          <li class="breadcrumb-item"><a href="{{url('/user/discipline/list')}}">Thông Tin Kỷ Luật</a></li>
          <li class="breadcrumb-item active">Thay đổi phản hồi</li>
        </ol>
<div class="card mb-3">
        <!-- DataTables Example -->
          <div class="card-header">
            <i class="fas fa-edit"></i>
            Thay đổi phản hồi</div>
                  <div class="card-body">
        <div class="table-responsive">
          <!--Search-->

          <!--end - search -->
          <table class="table table-bordered table-striped">
            <thead>
              <tr>
                <th>Mã Sinh Viên</th>
                <th>Họ & Tên</th>
                <th>Ngày Sinh</th>
                <th>Bậc Đào Tạo</th>
                <th>Loại hình đào tạo</th>
                <th>Mã Lớp</th>
                <th>Ngành Học</th>
                <th>Điểm TBC</th>
                <th>Số TBTL</th>
                <th>Số TC Còn Nợ</th>
                <th>Điểm TBCTL</th>
                <th>ĐTB10</th>
                <th>SV năm thứ</th>
                <th>Phản hồi từ CVHT</th>
                <th>Phản hồi từ Khoa</th>
                <th>Tình Trạng</th>
                <th>Ghi chú</th>
                <th>Kết quả trước</th>
              </tr>
            </thead>
            <tbody>
      <tr>
      <td>{{$item['student_code']}}</td>
      <td>{{$item['student_fullname']}}</td>
      <td>{{date('d/m/Y', $item['student_birth'])}}</td>
      <td>{{$item['student_level_edu']}}</td>
      <td>{{$item['student_type_edu']}}</td>
      <td>{{$item['class_code']}}</td>
      <td>{{$item['major_name']}}</td>
      <td>{{$item['di_TBC']}}</td>
      <td>{{$item['di_TCTL']}}</td>
      <td>{{$item['di_TC_debt']}}</td>
      <td>{{$item['di_TBCTL']}}</td>
      <td>{{$item['di_DTB10']}}</td>
      <td>{{$item['di_student_year']}}</td>
      <td>{{$item['di_teacher_confirm']}}</td>
      <td>{{$item['di_falcuty_confirm']}}</td>
      <td>{{$item['discipline_name']}}</td>
      <td>{{$item['di_note']}}</td>
      <td>
        {{$item['di_last_result']}}
      </td>
    </tr>
            </tbody>
          </table>
        </div>
      </div>
            <div class="form-add">
              <div class="container">
               <form class="col-xs-12" action="{{route('postUserUpdate')}}" method="post">
                @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}
                    </div>
                @endif
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <input type="hidden" name="student_id" value="{{$item['student_id']}}">
                <input type="hidden" name="di_id" value="{{$item['di_id']}}">
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Phản hồi từ CVHT</label>
                  <div class="col-sm-4 mr-md-auto">
                    <textarea class="form-control" name="di_teacher_confirm" required>{{$item['di_teacher_confirm']}}</textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Thông tin liên lạc sinh viên</label>
                  <div class="col-sm-4 mr-md-auto">
                    <textarea class="form-control" name="student_contact" placeholder="(Nếu có)">{{$item['student_contact']}}</textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-6 ml-md-auto">
                    <button type="submit" class="btn btn-primary">Thay đổi</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
            </div>
          </div>
         
</div>

      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
    <!-- /.content-wrapper -->

  @stop