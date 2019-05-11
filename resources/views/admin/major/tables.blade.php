@extends('admin.layout.master')
@section('title')
Danh sách ngành học
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
.page-table {
  font-size: 12px;

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
        <a href="{{url('admin/index')}}">Dashboard</a>
      </li>
      <li class="breadcrumb-item">Ngành
      </li>
      <li class="breadcrumb-item active">Xem Danh Sách
      </li>
    </ol>

    <!-- DataTables Example -->
    <div class="card mb-3">
      <div class="card-header">
        <a href="{{url('/admin/major/add')}}" class="add-table"><i class="fa fa-plus" aria-hidden="true"></i></a>
        <i class="fas fa-table"></i>
      Ngành</div>
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
        <form class="form-inline" action="{{Route('getSearch')}}" method="get">
          <div class="form-group">
            <label for="inputSearch">Tìm kiếm </label>
            <input type="text" class="form-control space" name="key" id="inputSearch" placeholder="Từ khóa...">
          </div>
          <div class="form-group">
            <label for="select-search" id="label-space">Tiêu chí </label>
            <select class="form-control space" id="select-search" name="types">
              <option value="md">Mặc định</option>
              <option value="major_code">Mã Ngành</option>
              <option value="major_name">Tên Ngành</option>
            </select>
          </div>
          <button type="submit" class="btn btn-primary space">Tìm kiếm</button>
        </form>
      </div>
      @if(isset($_GET['key']))
      <div class="result-search">Kết quả tìm kiếm: "<span>{{$_GET['key']}}</span>" có <span>{{$count_major}}</span> kết quả</div>
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
                <th>Tên Ngành</th>
                <th>Mã Ngành</th>
                <th>Kí hiệu trên mã sinh viên</th>
              </tr>
            </thead>
            <tbody>
              <?php $i = 0; ?>
              @foreach($major as $value)
             <tr>
              <td><a class="btn btn-primary btn-edit" href="{{Route('getEditMajor', $value['major_id'])}}"><i class="far fa-edit"></i></a>
                <form id="form-delete" action="{{Route('postDeleteMajor')}}" method="post">
                  <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                  <input type="hidden" name="major_id" value="{{$value['major_id']}}">
                  <button class="btn btn-primary btn-delete" onclick="return confirm('Xóa ngành?');"><i class="far fa-trash-alt"></i></button>
                </form>
                
              </td>
                <td>{{++$i}}</td>
                <td>{{$value['major_name']}}</td>
                <td>{{$value['major_code']}}</td>
                <td>{{$value['major_symbol']}}</td>
              </tr>
              @endforeach
            </tbody>
          </table>
          @if(isset($_GET['key']))
          <div class="page-table"><?php echo str_replace('/search?','/search?key='.$_GET['key'].'&types='.$_GET['types'].'&',$major->render("pagination::bootstrap-4")) ; ?></div>
          @else
          <div class="page-table"><?php echo str_replace('/?','?',$major->render("pagination::bootstrap-4")) ; ?></div>
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