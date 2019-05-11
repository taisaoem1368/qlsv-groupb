@extends('admin.layout.master')
@section('title')
Dashboard
@stop
@section('css-header')
<style type="text/css">
  .container-fluid {
    height: 72%;
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
          <li class="breadcrumb-item active">Index</li>
        </ol>

        <!-- Icon Cards-->
        <div class="row">
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-primary o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-comments"></i>
                </div>
                <div class="mr-5">Sinh Viên Bị Kỷ Luật! Học kỳ <?php if(isset($hocky)){echo $hocky;} ?> ( <?php if(isset($nam)){echo $nam.'-'.($nam+1);} ?>)</div>
              </div>
              <span class="card-footer text-white clearfix small z-1">
                <span class="float-left"><?php echo $sinhvienbikyluatall; ?></span>

              </span>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-warning o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-list"></i>
                </div>
                <div class="mr-5">CVHT Chưa phản hồi! Học kỳ <?php if(isset($hocky)){echo $hocky;} ?> ( <?php if(isset($nam)){echo $nam.'-'.($nam+1);} ?>)</div>
              </div>
              <span class="card-footer text-white clearfix small z-1">
                <span class="float-left"><?php echo $sinhvienbikyluatchuacomfirmall; ?></span>

              </span>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-success o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-shopping-cart"></i>
                </div>
                <div class="mr-5">CVHT đã phản hồi! Học kỳ <?php if(isset($hocky)){echo $hocky;} ?> ( <?php if(isset($nam)){echo $nam.'-'.($nam+1);} ?>)</div>
              </div>
              <span class="card-footer text-white clearfix small z-1">
                <span class="float-left"><?php echo $sinhvienbikyluatdacomfirmall; ?></span>

              </span>
            </div>
          </div>
          <div class="col-xl-3 col-sm-6 mb-3">
            <div class="card text-white bg-danger o-hidden h-100">
              <div class="card-body">
                <div class="card-body-icon">
                  <i class="fas fa-fw fa-life-ring"></i>
                </div>
                <div class="mr-5">Tất cả lớp đang quản lý!</div>
              </div>
              <span class="card-footer text-white clearfix small z-1">
                <span class="float-left"><?php echo $classdangquanliall; ?></span>

              </span>
            </div>
          </div>
        </div>
      </div>

@stop
@section('js-footer')
  <script src="js/demo/chart-area-demo.js"></script>
@stop