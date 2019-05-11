@extends('admin.layout.master')
@section('title')
Bảng thông tin sinh viên
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
        color: white!important;
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
            <li class="breadcrumb-item">
                <a href="/admin/student/list">Sinh viên</a>
            </li>
            <li class="breadcrumb-item active">Xem Danh Sách
            </li>
        </ol>
        <!-- /Breadcrumbs -->

        <!-- Body page -->
        <div class="card mb-3">
            <!-- Title -->
            <div class="card-header">
                <a href="{{url('/admin/student/add')}}" class="add-table"><i class="fa fa-plus" aria-hidden="true"></i></a>
                <i class="fas fa-table"></i>
               Danh sách Sinh Viên
            </div>
            <!-- /Title -->
            
            <!-- Search -->
            <div class="form-search">
                <form class="form-inline" action="{{Route('getSearchStudent')}}" method="get">
                    <div class="form-group">
                        <label for="inputSearch">Từ Khóa </label>
                        <input name="key" type="text" class="form-control space" id="inputSearch" placeholder="Từ khóa...">
                    </div>
                    <div class="form-group">
                        <label for="select-search" id="label-space">Tiêu chí </label>
                        <select class="form-control space" id="select-search" name="types">
                            <option value="md">Mặc định</option>
                            <option value="student_code">Mã Sinh viên</option>
                            <option value="student_fullname">Tên Sinh viên</option>
                            <option value="class_code">Mã Lớp</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary space">Tìm kiếm</button>
                </form>
            </div>
            <!-- /Search -->
            
            <!-- Result report -->
            @if(isset($_GET['key']))
            <div class="result-search">Kết quả tìm kiếm: "<span>{{$_GET['key']}}</span>" có <span>{{$count_student}}</span> kết quả</div>
            @endif
            <!-- /Result report -->
            
            <!-- Body page -->
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
                                <th>Mã Lớp</th>
                                <th>Tên Ngành</th>
                                <th>Bậc Đào Tạo</th>
                                <th>Loại hình đào tạo</th>
                                <th>Thông tin liên hệ</th>
                                
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 0; ?>

                            @foreach($student as $value)
                            <tr id="{{$value['student_id']}}">
                                <td>
                                    <a class="btn btn-primary btn-edit" href="{{Route('getEditStudent', $value['student_id'])}}"><i class="far fa-edit"></i></a>
                                    <a class="btn btn-primary btn-delete" onclick="confirmDelete('{{Route('postDeleteStudent')}}',{{$value['student_id']}},'{{csrf_token()}}')"><i class="far fa-trash-alt"></i></a>
                                </td>
                                <?php if (isset($_GET['page'])) : ?>
                                    <?php $page = (int) $_GET['page']; ?>
                                    <td>{{++$i + (@($page-1) * 10)}}</td>
                                <?php else: ?>
                                    <td>{{++$i}}</td>
                                <?php endif; ?>
                                <td>{{$value['student_code']}}</td>
                                <td>{{$value['student_fullname']}}</td>
                                <td>{{$value['student_birth']}}</td>
                                <td>{{$value['class_code']}}</td>
                                <td>{{$value['major_name']}}</td>
                                <td>{{$value['student_level_edu']}}</td>
                                <td>{{$value['student_type_edu']}}</td>
                                <td>{{$value['student_contact']}}</td>

                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @if(isset($_GET['key']))
                    <div class="page-table"><?php echo str_replace('/search?', '/search?key=' . $_GET['key'] . '&types=' . $_GET['types'] . '&', $student->render("pagination::bootstrap-4")); ?></div>
                    @else
                    <div class="page-table"><?php echo str_replace('/?', '?', $student->render("pagination::bootstrap-4")); ?></div>
                    @endif

                </div>
            </div>
            <!-- /Body page -->

        </div>
        <!-- /Body page -->

    </div>
    <!-- /.container-fluid -->




@stop

@section('js-footer')
<script src="{{asset('jquery-3.3.1.min.js')}}"></script>
<script type="text/javascript">
    <!-- Delete --/>
    function confirmDelete(redirectDel,id,token){
        var mess = 'Bạn có chắc muốn xóa ?';
        var defaultcolor = $('#'+id).css('background-color');

        setTimeout(function(){
            if (confirm(mess))
            {
                $.post(redirectDel, {
                    student_id: id,
                    '_token': token
                }, function(obj_returned){
                    if (obj_returned['delete-success']){
                        $('#'+id).remove();
                        alert(obj_returned['delete-success']);
                    }
                    else{
                        alert(obj_returned['delete-fail']);
                    }
                })
            }
        },200);
    }
    <!-- /Delete --/>
</script>
@stop