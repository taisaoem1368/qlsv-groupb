@extends('admin.layout.master')
@section('title')
Thêm giáo viên mới
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
.container-fluid {
  height: 73%;
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
          <li class="breadcrumb-item"><a href="{{url('/admin/teacher/list')}}">Giáo Viên/CVHT</a></li>
          <li class="breadcrumb-item active">Thêm mới</li>
        </ol>
<div class="card mb-3">
        <!-- DataTables Example -->
          <div class="card-header">
            <i class="fa fa-plus" aria-hidden="true"></i>
            Thêm mới</div>
            <div class="form-add">
              <div class="container">
               <form class="col-xs-12" action="{{route('postAddTeacher')}}" method="post">
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
                  <label class="col-sm-4 col-form-label">Họ và tên<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="teacher_fullname" placeholder="Nguyễn V...">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Mã giáo viên<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="teacher_code" placeholder="79000...">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Số điện thoại</label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="teacher_phone" placeholder="0123...">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Email</label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="teacher_email" placeholder="email@tdc.edu.vn">
                  </div>
                </div>
                @if(Auth::user()->user_role_id == 1)
               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Quyền<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <select class="form-control" name="teacher_role_id">
                      <option disabled="disabled" selected>Chọn quyền</option>
                      @foreach($role as $value)
                      @if($value['role_name'] != "supperadmin")
                      <option value="{{$value['role_id']}}">{{$value['role_name']}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>
                @endif
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