@extends('user.layout.master')
@section('title')
Tổng quan
@stop
@section('content')
    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item active">
            <a href="{{url('/user/index')}}">Tổng Quan</a>
          </li>

        </ol>

        <!-- Icon Cards-->
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-list"></i>
                </div>
                <div class="mr-5">Số sinh viên bị kỷ luật học kỳ <?php echo $hocky.' ('.($nam).'-'.($nam+1).')'; ?></div>
              </div>
              <span class="card-footer text-white clearfix small z-1">
                <span class="float-left"><?php echo $sinhvienbikyluat; ?></span>
              </span>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">Số Sinh viên bị kỷ luật chưa phản hồi học kì <?php echo $hocky.' ('.($nam).'-'.($nam+1).')'; ?></div>
              </div>
              <span class="card-footer text-white clearfix small z-1">
                <span class="float-left"><?php echo $sinhvienbikyluatchuacomfirm; ?></span>

              </span>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">Số Sinh viên bị kỷ luật đã phản hồi học kì <?php echo $hocky.' ('.($nam).'-'.($nam+1).')'; ?></div>
              </div>
              <span class="card-footer text-white clearfix small z-1">
                <span class="float-left"><?php echo $sinhvienbikyluatdacomfirm; ?></span>

              </span>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-life-ring"></i>
                </div>
                <div class="mr-5">Số lượng lớp đang quản lí</div>
              </div>
              <span class="card-footer text-white clearfix small z-1">
                <span class="float-left"><?php echo $classdangquanli; ?></span>

              </span>
            </div>
          </div>
        </div>
      </div>
</div>
@stop
@section('js-footer')
  <script src="js/demo/chart-area-demo.js"></script>

@stop