@extends('admin.layout.master')
@section('title')
Sửa ngành học
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
            <a href="{{url('admin/index')}}">Dashboard</a>
          </li>
          <li class="breadcrumb-item"><a href="{{url('/admin/major/list')}}">Ngành</a></li>
          <li class="breadcrumb-item active">Chỉnh sửa</li>
        </ol>
<div class="card mb-3">
        <!-- DataTables Example -->
          <div class="card-header">
            <i class="fa fa-plus" aria-hidden="true"></i>
            Chỉnh sửa</div>
            <div class="form-add">
              <div class="container">
               <form class="col-xs-12" action="{{Route('postEditMajor')}}" method="post">
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
                <input type="hidden" name="major_id" value="{{$major['major_id']}}">
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Tên Ngành<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="major_name" placeholder="Công Nghệ Thông Tin" value="{{$major['major_name']}}" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Mã Ngành<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="major_code" placeholder="CNTT" value="{{$major['major_code']}}" required>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Kí hiệu trên mã lớp(bắt buộc, dùng để đọc excel)<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="major_symbol" value="{{$major['major_symbol']}}" required>
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


      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
    <!-- /.content-wrapper -->

  @stop