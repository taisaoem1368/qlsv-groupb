@extends('admin.layout.master')
@section('title')
Bảng danh sách khóa học
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
        margin-bottom: 10px;
    }

    .btn-delete {
        font-size: 15px;
        color: white!important;
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
                <a href="{{url('/admin/index')}}">Dashboard</a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{url('/admin/course/list')}}">Khóa học</a>
            </li>
            <li class="breadcrumb-item active">Xem Danh Sách
            </li>
        </ol>
        <!-- /Breadcrumbs-->

        <!-- Body page -->
        <div class="card mb-3">
            <!-- Title -->
            <div class="card-header">
                <a href="{{url('/admin/course/add')}}" class="add-table"><i class="fa fa-plus" aria-hidden="true"></i></a>
                <i class="fas fa-table"></i>
                Khóa học
            </div>
            <!-- /Title -->
            <div class="container">
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
            </div>
            <!-- Search -->
            <div class="form-search">
                <form class="form-inline" action="{{Route('getSearchCourse')}}" method="get">
                    <div class="form-group">
                        <label for="inputSearch">Tìm kiếm </label>
                        <input type="text" class="form-control space" name="key" id="inputSearch" placeholder="Từ khóa...">
                    </div>
                    <div class="form-group">
                        <label for="select-search" id="label-space">Tiêu chí </label>
                        <select class="form-control space" id="select-search" name="types">
                            <option value="md">Mặc định</option>
                            <option value="course_code">Mã Khóa học</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary space">Tìm kiếm</button>
                </form>
            </div>
            <!-- /Search -->
            
            <!-- Result report -->
            @if(isset($_GET['key']))
            <div class="result-search">Kết quả tìm kiếm: "<span>{{$_GET['key']}}</span>" có <span>{{$count_course}}</span> kết quả</div>
            @endif
            <!-- /Result report -->
            
            <!-- Result Table -->
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-bordered table-striped">
                        <thead>
                            <tr>
                                <th>Thao Tác</th>
                                <th>STT</th>
                                <th>Tên Khóa học</th>
                                <th>Mã Khóa học</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>
                            @foreach($course as $value)
                            <tr id="{{$value['course_id']}}">
                                <td>
                                    <a class="btn btn-primary btn-edit" href="{{Route('getEditCourse', $value['course_id'])}}"><i class="far fa-edit"></i></a>
                                    <form action="{{route('postDeleteCourse')}}" method="post"> 
                                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                                        <input type="hidden" name="course_id" value="{{$value['course_id']}}">
                                        <button class="btn btn-primary btn-delete" onclick="return confirm('Xóa khóa học?');"><i class="far fa-trash-alt"></i></button>
                                    </form>
                                </td>
                                <?php if (isset($_GET['page'])) : ?>
                                    <?php $page = (int) $_GET['page']; ?>
                                    <td>{{++$i + (@($page-1) * 10)}}</td>
                                <?php else: ?>
                                    <td>{{++$i}}</td>
                                <?php endif; ?>
                                <td>{{$value['course_name']}}</td>
                                <td>{{$value['course_code']}}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(isset($_GET['key']))
                    <div class="page-table"><?php echo str_replace('/search?', '/search?key=' . $_GET['key'] . '&types=' . $_GET['types'] . '&', $course->render("pagination::bootstrap-4")); ?></div>
                    @else
                    <div class="page-table"><?php echo str_replace('/?', '?', $course->render("pagination::bootstrap-4")); ?></div>
                    @endif
                </div>
            </div>
            <!-- /Result Table -->

        </div>
        <!-- /Body page -->

    </div>
    <!-- /.container-fluid -->
    <!-- comment -->

<!-- /.content-wrapper -->

@stop
