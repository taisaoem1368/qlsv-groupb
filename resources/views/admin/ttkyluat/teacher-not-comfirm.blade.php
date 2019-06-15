@extends('admin.layout.master')
@section('title')
Danh sách giáo viên chưa gửi phản hồi
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
#warning {
  color: #f13232c9;
  font-weight: bold;
  font-size: 1.4em;
}
input[type=date]::-webkit-inner-spin-button {
    -webkit-appearance: none;
    display: none;
}

</style>
@stop
@section('content')

    <div id="content-wrapper" style="padding-bottom: 0">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{url('/admin/index')}}">Dashboard</a>
          </li>
          <li class="breadcrumb-item">Thông Tin Kỷ Luật
</li>
<li class="breadcrumb-item active">Danh sách giáo viên chưa phản hồi
</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-table"></i>
            Danh Sách Giáo Viên Chưa Phản Hồi</div>
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
             <strong>Thông báo:</strong><br>
             <div class="alert alert-danger">
              
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
  </div>
<form class="form-inline" action="{{Route('postSendNotificationForTeacher')}}" method="post">
             {{csrf_field()}}
  <div class="form-group mx-sm-1 mb-2 ml-md-5">
    <label id="label-form-search">Hạn chót</label>
    <input type="date" class="form-control" name="dealtime" min="<?php echo date('Y-m-d'); ?>" value="<?php echo date('Y-m-d'); ?>" placeholder="Từ khóa....">
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

  <div class="form-group mx-sm-3">
    <button type="submit" class="btn btn-primary mb-2">Gửi Email <i class="fas fa-paper-plane"></i></button>
  </div>
</form>
        </div>
          <div class="card-body">
            <div class="table-responsive">
              <!---->

<div id="warning">Học Kì: {{$hocky}} | Năm Học: {{$nam}} - {{$nam+1}} | Tổng: {{$data->total()}} giáo viên chưa phản hồi </div>

<!--end -  -->
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                      <th>STT</th>
                      <th>Mã giáo viên</th>
                      <th>Họ & Tên</th>
                      <th>Email</th>
                  </tr>
                </thead>
                <tbody>
    <?php $i = 0; if(isset($_GET['page'])){$i = ($_GET['page']*15-15);} ?>
   @foreach($data as $value)
    <tr>
      <td>{{++$i}}</td>
      <td>{{$value->teacher_code}}</td>
      <td>{{$value->teacher_fullname}}</td>
      <td>{{$value->teacher_email}}</td>
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
  @section('js-footer')
  <script>
    $(document).ready(function(){
      setHeightFt();
      checkEmailOnTable();
    });

    function setHeightFt() {
      var total = <?php echo $data->total(); ?>;
      if(total <= 0)
        $('footer').css('margin-top', '170px');
    }

    function checkEmailOnTable()
    {
      var total = $('tbody tr').length;
      var exist = 0;
      for(var i = 0; i < total; i++)
      {
          
          if($('tbody tr').eq(i).children().eq(3).text() == '')
          {
            $('tbody tr').eq(i).css('background', '#e8766c');
            exist++;
          }
      }
      if(exist > 0)
      {
        $('#warning').append(`
          <span id="email-exist">(${exist} giáo viên chưa có email)</span>
        `);
      }
    }
  </script>
  @stop

