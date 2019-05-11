@extends('admin.layout.master')
@section('title')
Danh sách sinh viên vi phạm quá số tiết vắng
@stop
@section('css-header')
<style>
  .form-search {
    margin: 20px 0px 20px 50px;
  }
  .result-search {
    margin: 0 0 0 50px;
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
 #label-form-search {
    margin-right: 10px;
  }
  .message-errors {
    margin-right: 50px;
  }
</style>
@stop
@section('content')

    <div id="content-wrapper" style="padding-bottom: 0">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item">Chuyên Cần
</li>
<li class="breadcrumb-item active">Xem Danh Sách
</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <a href="{{url('/admin/absent/add')}}" class="add-table"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <i class="fas fa-table"></i>
            Sinh Viên Kỷ Luật Vắng Quá Số Tiếc</div>
        <div class="form-search">
  <div class="message-errors">
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
  </div>
<form class="form-inline" action="{{Route('getSearchAbsent')}}" method="get">
             
  <div class="form-group mx-sm-1 mb-2">
    <input type="text" class="form-control" name="key" placeholder="Từ khóa....">
  </div>
    <div class="form-group mx-sm-3 mb-2">
    <label id="label-form-search">Học kỳ</label>
    <select class="form-control" name="hocky">
        @if(!isset($hocky))<option selected disabled="disabled">Học kỳ</option>@endif
        <option value="1" <?php if(isset($hocky_s)){ if($hocky_s == 1){echo "selected";}} else {if($hocky == 1){echo "selected";}} ?>>I</option>
        <option value="2" <?php if(isset($hocky_s)){ if($hocky_s == 2){echo "selected";}} else {if($hocky == 2){echo "selected";}} ?>>II</option>
    </select>
  </div>
    <div class="form-group mx-sm-3 mb-2">
      <label id="label-form-search">Năm học</label>
      <select class="form-control" name="nam">
        @if(!isset($nam))<option selected disabled="disabled">Năm học</option>@endif
        <?php 
        $year = date('Y');
        for($k = $year; $k > $year-6; $k--)
        {
         ?>
         <option value="{{$k}}" <?php if(isset($nam_s)){ if($nam_s == $k) {echo "selected";}} else {if($nam == $k){echo "selected";}} ?>>{{$k." - ".($k+1)}}</option>
       <?php } ?>
    </select>
  </div>
    <div class="form-group mx-sm-3 mb-2">
    <label id="label-form-search">Tiêu chí</label>
    <select class="form-control" name="types">

      <option value="md" <?php if(isset($types)){if($types == "md"){echo "selected";}} ?>>Mặc định</option>
      <option value="class_code" <?php if(isset($types)){if($types == "class_code"){echo "selected";}} ?>>Mã lớp</option>
      <option value="student_code" <?php if(isset($types)){if($types == "student_code"){echo "selected";}} ?>>Mã sinh viên</option>
      <option value="student_fullname" <?php if(isset($types)){if($types == "student_fullname"){echo "selected";}} ?>>Tên sinh viên</option>
    </select>
  </div>
  <div class="form-group mx-sm-3">
    <button type="submit" class="btn btn-primary mb-2">Tìm kiếm</button>
  </div>
</form>
        </div>
        @if(isset($_GET['key']))
          <div class="result-search">Kết quả tìm kiếm: "<span>{{$_GET['key']}}</span>" có <span>{{$data->total()}}</span> kết quả</div>
        @endif
          <div class="card-body">
            <div class="table-responsive">
              <!--Search-->

<!--end - search -->
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                        <th>Thao tác</th>
                        <th>STT</th>
                        <th>Mã Sinh Viên</th>
                        <th>Họ & Tên</th>
                        <th>Ngày Sinh</th>
                        <th>Mã Lớp</th>
                        <th>Ngành Học</th>
                        <th>Số tiếc vắng</th>
                        <th>Tình trạng</th>
                        <th>Cập nhật lần cuối</th>
                  </tr>
                </thead>
                <tbody>
    <?php $i = 0; ?>
   @foreach($data as $value)
                 <tr>
      <td><a class="btn btn-primary btn-edit" href="{{Route('getEditAbsent', $value['ai_id'])}}"><i class="far fa-edit"></i></a>
                <form id="form-delete" action="{{Route('postDeleteAbsent')}}" method="post">
          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
          <input type="hidden" name="ai_id" value="{{$value['ai_id']}}">
          <button class="btn btn-primary btn-delete"  onclick="return confirm('Xóa sinh viên vi phạm?');"><i class="far fa-trash-alt"></i></button>
        </form></td>
      <td>{{++$i}}</td>
      <td>{{$value['student_code']}}</td>
      <td>{{$value['student_fullname']}}</td>
      <td>{{date('d/m/Y', $value['student_birth'])}}</td>
      <td>{{$value['class_code']}}</td>
      <td>{{$value['major_name']}}</td>
      <td>{{$value['ai_absences']}}</td>
      <td>{{$value['discipline_name']}}</td>
      <td>({{$value['ai_teacher_code_edit']}}) {{$value['ai_time_edit']}}
      </td>
    </tr>
    @endforeach
                </tbody>
              </table>
           @if(isset($_GET['key']))
          <div class="page-table"><?php echo str_replace('/search?','/search?key='.$_GET['key'].'&hocky='.$_GET['hocky'].'&nam='.$_GET['nam'].'&types='.$_GET['types'].'&',$data->render("pagination::bootstrap-4")) ; ?></div>
          @else
          <div class="page-table"><?php echo str_replace('/?','?',$data->render("pagination::bootstrap-4")) ; ?></div>
          @endif
            </div>
          </div>
         
        </div>
      <!-- /.container-fluid -->

    </div>
    <!-- /.content-wrapper -->



  @stop