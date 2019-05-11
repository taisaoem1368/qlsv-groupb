@extends('admin.layout.master')
@section('title')
Chỉnh sửa lớp
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
          <li class="breadcrumb-item active">Chỉnh sửa</li>
        </ol>
<div class="card mb-3">
        <!-- DataTables Example -->
          <div class="card-header">
            <a href="{{url('/admin/class/add')}}"><i class="fa fa-plus" aria-hidden="true"></i></a>
            Chỉnh sửa</div>
            <div class="form-add">
              <div class="container">
               <form class="col-xs-12" action="{{route('postEditClass')}}" method="post">
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
                <input type="hidden" name="class_id" value="{{$item['class_id']}}">
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Tên Lớp</label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="class_name" placeholder="CD18..." value="{{$item['class_name']}}">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Mã Lớp<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="class_code" placeholder="CD18..." value="{{$item['class_code']}}">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Giáo Viên/CVHT<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <select class="form-control" name="class_teacher_id">
                      @foreach($teacher as $value)
                      @if($item['class_teacher_id'] == $value['teacher_id'])
                      <option value="{{$value['teacher_id']}}" selected>{{$value['teacher_fullname']." - ".$value['teacher_code']}}</option>
                      @else
                      <option value="{{$value['teacher_id']}}">{{$value['teacher_fullname']." - ".$value['teacher_code']}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Khóa<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <select class="form-control" name="class_course_id">
                      @foreach($course as $value)
                      @if($value['course_id'] == $item['class_course_id'])
                      <option value="{{$value['course_id']}}" selected>{{$value['course_code']}}</option>
                      @else
                      <option value="{{$value['course_id']}}">{{$value['course_code']}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Ngành<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <select class="form-control" name="class_major_id">
                      @foreach($major as $value)
                      @if($item['class_major_id'] == $value['major_id'])
                      <option value="{{$value['major_id']}}" selected>{{$value['major_name']}}</option>
                      @else
                      <option value="{{$value['major_id']}}">{{$value['major_name']}}</option>
                      @endif
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Giáo Viên/CVHT cũ</label>
                  <div class="col-sm-4 mr-md-auto">
                    <select class="form-control" name="class_old_teacher_id">
                      @if($item['class_old_teacher_id'] == null)
                      <option disabled="disabled" value="-1" selected>Không tồn tại</option>
                      @endif
                      @foreach($teacher as $value)
                      @if($item['class_old_teacher_id'] == $value['teacher_id'])
                      <option value="{{$value['teacher_id']}}" selected>{{$value['teacher_fullname']." - ".$value['teacher_code']}}</option>
                      @elseif($item['class_teacher_id'] != $value['teacher_id'])
                      <option value="{{$value['teacher_id']}}">{{$value['teacher_fullname']." - ".$value['teacher_code']}}</option>
                      @endif
                      @endforeach

                    </select>
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