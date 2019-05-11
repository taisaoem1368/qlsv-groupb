@extends('admin.layout.master')
@section('title')
Thêm mới thông tin kỷ luật
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
          <li class="breadcrumb-item"><a href="{{url('/admin/disciplinary-information/list')}}">Thông Tin Kỷ Luật</a></li>
          <li class="breadcrumb-item active">Thêm mới</li>
        </ol>
<div class="card mb-3">
        <!-- DataTables Example -->
          <div class="card-header">
            <i class="fa fa-plus" aria-hidden="true"></i>
            Thêm mới</div>
            <div class="form-add">
              <div class="container">
               <form class="col-xs-12" action="{{Route('postAddDI')}}" method="post">
                <span id="required-value">(Trường có * là trường bắt buộc)</span>
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
                  <label class="col-sm-4 col-form-label">Mã khóa<span id="required-value">*</span>  </label>
                  <div class="col-sm-4 mr-md-auto">
                    <select class="form-control" name="course_id" id="course_id">
                      <option selected disabled="disabled" id="course_id">Chọn mã khóa</option>
                      @foreach($course as $value)
                      <option value="{{$value['course_id']}}">{{$value['course_code']}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Mã lớp<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <select class="form-control" name="selectclass" id="class_id">
                      <option selected disabled="disabled">Chọn mã lớp</option>
                      @foreach($class as $value)
                      <option value="{{$value['class_id']}}">{{$value['class_name']}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Mã sinh viên<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <select class="form-control" name="di_student_id" id="student_id">
                      <option selected disabled="disabled">Chọn sinh viên</option>
                      
                    </select>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Điểm TBC<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="di_TBC">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Số TCTL<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="di_TCTL">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Điểm TBCTL<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="di_TBCTL">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">ĐTB10<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="di_DTB10">
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Số tín chỉ nợ<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="di_TC_debt">
                  </div>
                </div>
            
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Sinh viên năm</label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="di_student_year">
                  </div>
                </div>
          
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Tình trạng<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <select class="form-control" name="di_discipline_id">
                      <option selected disabled="disabled">Chọn tình trạng</option>
                      @foreach($discipline as $value)
                      <option value="{{$value['discipline_id']}}">{{$value['discipline_name']}}</option>
                      @endforeach
                    </select>
                  </div>
                </div>

                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Số quyết định<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="text" class="form-control" name="di_dicision">
                  </div>
                </div>

               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Học kỳ<span id="required-value">*</span></label>
                  <div class="col-sm-4 mr-md-auto">
                    <select class="form-control" name="di_semester">
                      <option value="1">HKI</option>
                      <option value="2">HKII</option>
                    </select>
                  </div>
                </div>

               <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Năm học<span id="required-value">*</span></label>
                  <div class="col-sm-4">
                    <select class="form-control" name="di_year">

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
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Phản hồi của GV/CVHT</label>
                  <div class="col-sm-4 mr-md-auto">
                    <textarea class="form-control" name="di_teacher_confirm"></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Phản hồi của Khoa</label>
                  <div class="col-sm-4 mr-md-auto">
                    <textarea class="form-control" name="di_falcuty_confirm"></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Ghi chú</label>
                  <div class="col-sm-4 mr-md-auto">
                    <textarea class="form-control" name="di_note"></textarea>
                  </div>
                </div>
                <div class="form-group row">
                  <label class="col-sm-4 col-form-label">Kết quả trước</label>
                  <div class="col-sm-4 mr-md-auto">
                    <textarea class="form-control" name="di_last_result"></textarea>
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
         


      <!-- Sticky Footer -->
    <!-- /.content-wrapper -->

  @stop
  @section('js-footer')
  <script type="text/javascript">
    $(document).ready(function(){
      $('#class_id').change(function(){
        var id = $('#class_id').val();
        $('#student_id').load('change-class-add/' + id);
      });
      $('#course_id').change(function(){
        var id = $('#course_id').val();
        $('#class_id').load('change-course-add/' + id);
      });
      });
  </script>           
  @stop
