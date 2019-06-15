@extends('admin.layout.master')
@section('title')
Chỉnh sửa hình thức kỷ luật
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
.container-fluid {
    height: 73%;
}
    #text-warning {
        display: block;
        text-align: center;
        color: red;
        font-weight: bold;
        background: yellow;
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
                <a href="{{url('/admin/discipline/list')}}">HT Kỷ luật</a>
            </li>
            <li class="breadcrumb-item active">Sửa</li>
        </ol>
        <div class="card mb-3">
            <!-- DataTables Example -->
            <div class="card-header" onclick="$('.add-form').submit()" style="cursor:pointer">
                <i class="fa fa-plus" aria-hidden="true"></i>
                Sửa
            </div>
            <span id="text-warning">Chú ý: Chỉnh sửa dữ liệu ở bảng này sẽ dẫn tới dữ liệu tình trạng kỉ luật của các sinh viên ở bảng thông tin kỷ luật thay đổi theo</span>
            <div class="form-add">
                <div class="container">
                    <form class="col-xs-12 add-form" action="{{Route('postEditDiscipline')}}" method="post">
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
                        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
                        <input type="hidden" name="discipline_id" value="{{$discipline['discipline_id']}}">
                        <div class="form-group row">
                            <label class="col-sm-4 col-form-label">Tên HT kỷ luật<span id="required-value">*</span></label>
                            <div class="col-sm-4 mr-md-auto">
                                <input type="text" class="form-control" name="discipline_name" placeholder="Hình thức kỷ luật" value="{{$discipline['discipline_name']}}" required>
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