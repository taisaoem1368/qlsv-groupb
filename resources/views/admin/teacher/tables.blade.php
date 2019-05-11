@extends('admin.layout.master')
@section('title')
Bảng danh sách giáo viên
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
  table tbody tr td:nth-child(1)
  {
    width: 15%;
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
  #form-delete{
    display: inline;
  }
</style>
@stop
@section('content')

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item">Thông Tin Kỷ Luật
</li>
<li class="breadcrumb-item active">Xem Danh Sách
</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <a href="{{url('/admin/teacher/add')}}" class="add-table"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <i class="fas fa-table"></i>
            Sinh Viên Bị Kỷ Luật</div>
        <div class="form-search">
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
          <form class="form-inline" action="{{route('getSearchTeacher')}}" method="get">

              <div class="form-group">
                <label for="inputSearch">Tìm Kiếm </label>
                <input type="text" class="form-control space" id="inputSearch" name="key" placeholder="Từ khóa...">
              </div>
              <div class="form-group">
                <label for="select-search" id="label-space">Tiêu chí </label>
                <select class="form-control space" id="select-search" name="types">
                  <option value="md">Mặc định</option>
                  <option value="ht">Họ & tên</option>
                  <option value="mgv">Mã giáo viên</option>
                  <option value="phone">Số điện thoại</option>
                  <option value="email">Email</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary space">Tìm kiếm</button>
          </form>
        </div>
        @if(isset($_GET['key']))
        <div class="result-search">Kết quả tìm kiếm: "<span>{{$_GET['key']}}</span>" có <span>{{$teacher_count}}</span> kết quả</div>
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
                        <th>Họ & Tên</th>
                        <th>Mã Giáo Viên</th>
                        <th>Số điện thoại</th>
                        <th>Email</th>
                        <th>Quyền</th>
                  </tr>
                </thead>
                <tbody>
                  <?php $i = 0; ?>
                  @foreach($teacher as $value)
                 <tr>
      <td><a class="btn btn-primary btn-edit" href="{{route('getEditTeacher', $value['teacher_id'])}}"><i class="far fa-edit"></i></a>
        <form id="form-delete" action="{{Route('postDeleteTeacher')}}" method="post">
          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
          <input type="hidden" name="teacher_id" value="{{$value['teacher_id']}}">
          <button class="btn btn-primary btn-delete" onclick="return confirm('Xóa giáo viên?');"><i class="far fa-trash-alt"></i></button>
        </form>
      </td>
      <td>{{++$i}}</td>
      <td>{{$value['teacher_fullname']}}</td>
      <td>{{$value['teacher_code']}}</td>
      <td>{{$value['teacher_phone']}}</td>
      <td>{{$value['teacher_email']}}</td>
      <td>{{$value['role_name']}}</td>
    </tr>
    @endforeach

                </tbody>
              </table>
              @if(isset($_GET['key']))
              <div class="page-table"><?php echo str_replace('/search?','/search?key='.$_GET['key'].'&types='.$_GET['types'].'&',$teacher->render("pagination::bootstrap-4")) ; ?></div>
              @else
              <div class="page-table"><?php echo str_replace('/?','?',$teacher->render("pagination::bootstrap-4")) ; ?></div>
              @endif
            </div>
          </div>
         
        </div>

      </div>
      <!-- /.container-fluid -->

  @stop
    @section('js-footer')
<script src="{{asset('jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript">
  var exits = "{{Session::get('delete-success')}}";
  if(exits)
  {
    alert("Xóa Thành Công !");
  }
</script>
  @stop