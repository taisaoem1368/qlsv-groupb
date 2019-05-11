@extends('user.layout.master')
@section('title')
Danh sách sinh viên kỷ luật do CVHT: {{Auth::user()->user_teacher_code}} quản lí
@stop
@section('css-header')
<?php date_default_timezone_set('Asia/Ho_Chi_Minh'); ?>
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
#label-form-search {
    margin-right: 10px;
  }
.message-errors {
    margin-right: 50px;
}
.margin-bt {
  margin-bottom: 100px;
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
</style>
@stop
@section('content')

<div id="content-wrapper">

  <div class="container-fluid margin-bt">

    <!-- Breadcrumbs-->
    <ol class="breadcrumb">
      <li class="breadcrumb-item">
        <a href="{{url('/user/index')}}">Tổng quan</a>
      </li>
      <li class="breadcrumb-item">Thông Tin Kỷ Luật
      </li>
      <li class="breadcrumb-item active">Xem Danh Sách
      </li>
    </ol>

    <!-- DataTables Example -->
    <div class="card mb-3">
      <div class="card-header">
<a href="#" id="info" class="add-table"><i class="fas fa-info"></i></a>
        <i class="fas fa-table"></i>
      Sinh Viên Bị Kỷ Luật</div>
      <div class="form-search">
<form class="form-inline" action="{{Route('getSearchUser')}}" method="get">
             
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
      <option value="cph" <?php if(isset($types)){if($types == "cph"){echo "selected";}} ?>>Chưa phản hồi</option>
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
                <th>Controll</th>
                <th>STT</th>
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
                <th>Ghi chú phản hồi của CVHT</th>
                <th>Thông tin liên lạc</th>
              </tr>
            </thead>
            <tbody>
    <?php $i = 0; ?>
         @foreach($data as $value)
            <tr>
            <td><a class="btn btn-primary btn-edit" href="{{route('getUserUpdate', $value['di_id'])}}"><i class="far fa-edit"></i></a>
            </td>
            <td>{{++$i}}</td>
            <td>{{$value['student_code']}}</td>
            <td>{{$value['student_fullname']}}</td>
            <td>{{date('d/m/Y', $value['student_birth'])}}</td>
            <td>{{$value['student_level_edu']}}</td>
            <td>{{$value['student_type_edu']}}</td>
            <td>{{$value['class_code']}}</td>
            <td>{{$value['major_name']}}</td>
            <td>{{$value['di_TBC']}}</td>
            <td>{{$value['di_TCTL']}}</td>
            <td>{{$value['di_TC_debt']}}</td>
            <td>{{$value['di_TBCTL']}}</td>
            <td>{{$value['di_DTB10']}}</td>
            <td>{{$value['di_student_year']}}</td>
            <td>{{$value['di_teacher_confirm']}}</td>
            <td>{{$value['di_falcuty_confirm']}}</td>
            <td>{{$value['discipline_name']}}</td>
            <td>{{$value['di_note']}}</td>
            <td>
              {{$value['di_last_result']}}
            </td>
            <td>
              @if($value['di_teacher_confirm'] != "")
              Đã phản hồi
              @endif
            </td>
            <td>
              {{$value['student_contact']}}
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

  </div>
  <!-- /.container-fluid -->
  @section('js-footer')
<script type="text/javascript">
  $(document).ready(function(){
    $('#info').click(function(){
      alert('GV/CVHT Thêm phản hồi của giáo viên cho sinh viên bị kỷ luật');
      return false;
    });
  });
</script>
@stop

@stop