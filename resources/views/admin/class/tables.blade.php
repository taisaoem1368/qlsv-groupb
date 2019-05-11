@extends('admin.layout.master')
@section('title')
Bảng danh sách lớp
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
    font-size: 12px;
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
  table tbody tr td:nth-child(1)
  {
    width: 15%;
  }
  #form-delete {
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
            <a href="{{url('/admin/index')}}">Dashboard</a>
          </li>
          <li class="breadcrumb-item">Lớp
</li>
<li class="breadcrumb-item active">Xem Danh Sách
</li>
        </ol>

        <!-- DataTables Example -->
        <div class="card mb-3">
          <div class="card-header">
            <a href="{{url('/admin/class/add')}}" class="add-table"><i class="fa fa-plus" aria-hidden="true"></i></a>
            <i class="fas fa-table"></i>
            Lớp</div>
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
          <form class="form-inline" action="{{route('getSearchClass')}}" method="get">
              <div class="form-group">
                <label for="inputSearch">Tìm kiếm </label>
                <input type="text" class="form-control space" name="key" id="inputSearch" placeholder="Từ khóa...">
              </div>
              <div class="form-group">
                <label for="select-search" id="label-space">Tiêu chí </label>
                <select class="form-control space" id="select-search" name="types">
                  <option value="md">Mặc định</option>
                  <option value="teacher_fullname">Tên GV/CVHT</option>
                  <option value="teacher_fullname">Mã GV/CVHT</option>
                  <option value="class_code">Mã Lớp</option>
                  <option value="major_name">Tên Ngành</option>
                  <option value="course_code">Mã Khóa</option>
                </select>
              </div>
              <button type="submit" class="btn btn-primary space">Tìm kiếm</button>
          </form>
        </div>
        @if(isset($_GET['key']))
        <div class="result-search">Kết quả tìm kiếm: "<span>{{$_GET['key']}}</span>" có <span>{{$class_count}}</span> kết quả</div>
          @endif
          <div class="card-body">
            <div class="table-responsive">
              <!--Search-->

<!--end - search -->
              <table class="table table-bordered table-striped">
                <thead>
                  <tr>
                        <th>Thao Tác</th>
                        <th>STT</th>
                        <th>Tên Lớp</th>
                        <th>Mã Lớp</th>
                        <th>GV/CVHT</th>
                        <th>Khóa Học</th>
                        <th>Ngành</th>
                        <th>GV/CVHT Cũ</th>
                  </tr>
                </thead>
                <tbody>
<?php $i = 0; ?>
                  @foreach($class as $value)
                 <tr>
      <td><a class="btn btn-primary btn-edit" href="{{route('getEditClass', $value['class_id'])}}"><i class="far fa-edit"></i></a>
        <form id="form-delete" action="{{Route('postDeleteClass')}}" method="post">
          <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
          <input type="hidden" name="class_id" value="{{$value['class_id']}}">
          <button class="btn btn-primary btn-delete" onclick="return confirm('Xóa lớp?');"><i class="far fa-trash-alt"></i></button>
        </form>
      </td>
      <td>{{++$i}}</td>
      <td>{{$value['class_name']}}</td>
      <td>{{$value['class_code']}}</td>
      <td>{{$value['teacher_fullname'].' ('.$value['teacher_code'].')'}}</td>
      <td>{{$value['course_code']}}</td>
      <td>{{$value['major_name']}}</td>
      <td>{{$value->getClass_teacher_old['teacher_fullname'].' ('.$value->getClass_teacher_old['teacher_code'].')'}}</td>
    </tr>
@endforeach
                </tbody>
              </table>
              @if(isset($_GET['key']))
              <div class="page-table"><?php echo str_replace('/search?','/search?key='.$_GET['key'].'&types='.$_GET['types'].'&',$class->render("pagination::bootstrap-4")) ; ?></div>
              @else
              <div class="page-table"><?php echo str_replace('/?','?',$class->render("pagination::bootstrap-4")) ; ?></div>
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