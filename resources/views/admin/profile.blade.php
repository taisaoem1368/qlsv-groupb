@extends('admin.layout.master')
@section('title')
Quản Lí Sinh Viên Công Nghệ Thông Tin - Profile User
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
.btn-edit {
  margin-top: 15px;
}
.container-fluid {
  height: 72%;
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
          <li class="breadcrumb-item active">Sửa</li>
        </ol>
<div class="card mb-3">
        <!-- DataTables Example -->
          <div class="card-header">
            <i class="fas fa-edit"></i>
            Chỉnh sửa thông tin cá nhân</div>
            <div class="form-add">
              <div class="container">
               <form class="col-xs-12" action="{{route('postProfileAdmin')}}" method="post">
                @if(Session::has('success'))
                <div class="alert alert-success">{{Session::get('success')}}
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
                  <label class="col-sm-4 col-form-label">Số điện thoại</label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="teacher_phone" value="{{$item['teacher_phone']}}">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Email</label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="teacher_email" value="{{$item['teacher_email']}}">
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Password</label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="password" class="form-control" name="teacher_password" placeholder="Để trống password sẽ không thay đổi">
                  </div>
                </div>

                <div class="form-group row">
                  <div class="col-sm-6 ml-md-auto">
                    <button type="submit" class="btn btn-primary btn-edit">Thay đổi</button>
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