@extends('admin.layout.master')
@section('title')
Sửa sinh viên
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
            <li class="breadcrumb-item">
                <a href="{{url('/admin/student/list')}}">Sinh viên</a>
            </li>
            <li class="breadcrumb-item active">Sửa</li>
        </ol>
        <div class="card mb-3">
            <!-- DataTables Example -->
            <div class="card-header" onclick="$('.add-form').submit()" style="cursor:pointer">
                <i class="fa fa-plus" aria-hidden="true"></i>
                Sửa
            </div>

            <div class="form-add">
                <div class="container">
                    <form class="col-xs-12 add-form" action="{{route('postEditStudent')}}" method="post">
                        <span id="required-value">(Trường có * là trường bắt buộc)</span>
                        @if(Session::has('success'))
                        <div class="alert alert-success">{{Session::get('success')}}
                        </div>
                        @elseif (Session::has('fail'))
                        <div class="alert alert-danger">{{Session::get('fail')}}
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
                        <input type="hidden" name="_token" value="{{csrf_token()}}">
                        
                        <input type="hidden" name="student_id" value="{{$student['student_id']}}">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Ngành<span id="required-value">*</span></label>
                            <div class="col-sm-4 mr-md-auto">
                                <select class="form-control majorselect" name="student_major_id" value="{{$student['student_major_id']}}">
                                    <?php if (@$major) : ?>
                                        <?php foreach ($major as $value) : ?>
                                    <option value="{{$value['major_id']}}" <?php if ($value['major_id'] == $student['student_major_id']) {echo 'selected';} ?>>{{$value['major_code']}}</option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Lớp<span id="required-value">*</span></label>
                            <div class="col-sm-4 mr-md-auto">
                                <select class="form-control classselect" name="student_class_id" value="{{$student['student_class_id']}}">
                                    <?php if (@$class) : ?>
                                        <?php foreach ($class as $value) : ?>
                                            <option value="{{$value['class_id']}}" <?php if ($value['class_id'] == $student['student_class_id']) {echo 'selected';} ?>>{{$value['class_code']}}</option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Mã Sinh Viên<span id="required-value">*</span></label>
                            <div class="col-sm-4 mr-md-auto">
                                <input type="text" name="student_code" class="form-control" placeholder="Mã Sinh Viên" value="{{$student['student_code']}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Họ Tên<span id="required-value">*</span></label>
                            <div class="col-sm-4 mr-md-auto">
                                <input type="text" name="student_fullname" class="form-control" placeholder="Họ Tên" value="{{$student['student_fullname']}}" required>
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Ngày sinh</label>
                            <div class="col-sm-4 mr-md-auto">
                                <input type="date" format="dd/mm/YYYY" name="student_birth" class="form-control" placeholder="Ngày sinh" value="{{date('Y-m-d',$student['student_birth'])}}">
                            </div>
                        </div>
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Loại hình đào tạo</label>
                            <div class="col-sm-4 mr-md-auto">
                                <input type="text" name="student_type_edu" class="form-control" placeholder="Loại hình đào tạo" value="{{$student['student_type_edu']}}">
                            </div>
                        </div>

                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Bậc đào tạo</label>
                            <div class="col-sm-4 mr-md-auto">
                                <input type="text" name="student_level_edu" class="form-control" placeholder="Bậc đào tạo" value="{{$student['student_level_edu']}}">
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Thông tin liên hệ</label>
                            <div class="col-sm-4 mr-md-auto">
                                <textarea name="student_contact" class="form-control" placeholder="Thông tin liên hệ">{{$student['student_contact']}}</textarea>
                            </div>
                        </div>
                        
                        <div class="form-group row">
                            <div class="col-sm-5 ml-md-auto">
                                <button type="submit" class="btn btn-primary">Sửa</button>
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
<script type="text/javascript">
    $(document).ready(function () {
        $('.majorselect').change(function () {
            var id = $('.majorselect').val();
//            $('.abc').load('add/'+id);
            //$('#cities').load('country-city/'+id);
            $('.classselect').empty();
            $.get('../major/' + id, function (id) {
//                console.log(id['class']);
                var classes = id['class'];
                for (item of classes) {
                    var content = '<option value="' + item['class_id'] + '">' + item['class_code'] + '</option>';
                    $('.classselect').append(content);
                }

            });

        });

    });
</script>
@stop