@extends('admin.layout.master')
@section('title')
Thêm lớp mới
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
          <li class="breadcrumb-item"><a href="{{url('/admin/class/list')}}">Lớp</a></li>
          <li class="breadcrumb-item active">Thêm mới</li>
        </ol>
<div class="card mb-3">
        <!-- DataTables Example -->
          <div class="card-header">
            <i class="fa fa-plus" aria-hidden="true"></i>
            Thêm mới</div>
            <div class="form-add">
              <div class="container">
               <form class="col-xs-12" action="{{route('postAddClass')}}" method="post">
                <span id="required-value">(Trường có * là trường bắt buộc)</span>
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
                <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Tên Lớp</label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="class_name" placeholder="CD18...">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Mã Lớp<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="class_code" placeholder="CD18...">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Giáo Viên/CVHT<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <select class="form-control" name="class_teacher_id">
                      <option disabled="disabled" value="" selected>Chọn GV/CVHT</option>
                      @foreach($teacher as $value)
                      <option value="{{$value['teacher_id']}}">{{$value['teacher_fullname']." - ".$value['teacher_code']}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Khóa<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <select class="form-control" name="class_course_id">
                      <option disabled="disabled" value="" selected>Chọn khóa</option>
                      @foreach($course as $value)
                      <option value="{{$value['course_id']}}">{{$value['course_code']}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Ngành<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <select class="form-control" name="class_major_id">
                      <option disabled="disabled" value="" selected>Chọn ngành</option>
                      @foreach($major as $value)
                      <option value="{{$value['major_id']}}">{{$value['major_name']}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>



                <div class="form-group row">
                  <div class="col-sm-5 ml-md-auto">
                    <button type="submit" class="btn btn-primary">Thêm</button>
                  </div>
                </div>
              </form>
            </div>
          </div>
            </div>
          </div>

      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
    <!-- /.content-wrapper -->

  @stop