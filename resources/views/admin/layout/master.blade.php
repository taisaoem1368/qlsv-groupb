<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>@yield('title')</title>

  <!-- Custom fonts for this template-->
  <link href="{{asset('start/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

  <!-- Page level plugin CSS-->
  <link href="{{asset('start/vendor/datatables/dataTables.bootstrap4.css')}}" rel="stylesheet">

  <!-- Custom styles for this template-->
  <link href="{{asset('start/css/sb-admin.css')}}" rel="stylesheet">

 <link rel="stylesheet" type="text/css" href="{{asset('bootstrap-4.3/css/bootstrap.min.css')}}">
  @yield('css-header')
</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="{{url('index')}}">QUẢN LÍ KỶ LUẬT</a>

    <button class="btn btn-link btn-sm text-white order-1 order-sm-0" id="sidebarToggle">
      <i class="fas fa-bars"></i>
    </button>

    <!-- Navbar Search -->
    <form class="d-none d-md-inline-block form-inline ml-auto mr-0 mr-md-3 my-2 my-md-0">

    </form>

    <!-- Navbar -->
    <ul class="navbar-nav ml-auto ml-md-0">

 
      <li class="nav-item dropdown no-arrow">
        <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-user-circle fa-fw"></i>
        </a>
        <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
          <a class="dropdown-item" href="{{route('getProfileAdmin')}}">{{Auth::user()->user_teacher_code}}</a>

          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{url('/logout')}}">Logout</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="{{url('/index')}}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Dashboard</span>
        </a>
      </li>
 <!--

     <li class="nav-item">
        <a class="nav-link" href="charts.html">
          <i class="fas fa-fw fa-chart-area"></i>
          <span>Charts</span></a>
      </li>
 -->

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Thông Tin Kỷ Luật</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Quản lí thông tin kỷ luật:</h6>
          <a class="dropdown-item" href="{{url('/admin/disciplinary-information/list')}}">Xem Danh Sách</a>
          <a class="dropdown-item" href="{{url('/admin/disciplinary-information/add')}}">Thêm</a>
          <a class="dropdown-item" href="{{url('/admin/disciplinary-information/add-from-file')}}">Thêm từ file</a>
          <a class="dropdown-item" href="{{url('/admin/disciplinary-information/export-thong-tin-ky-luat')}}">Xuất file</a>
          <a href="{{route('UpdateSQD')}}" class="dropdown-item">Cập nhật Số quyết định</a>
          <a href="{{route('getMailNotificationPage')}}" class="dropdown-item">Gửi email thông báo</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Chuyên Cần</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Quản lí sinh viên vắng:</h6>
          <a class="dropdown-item" href="{{url('/admin/absent/list')}}">Xem Danh Sách</a>
          <a class="dropdown-item" href="{{url('/admin/absent/add')}}">Thêm</a>
          <a class="dropdown-item" href="{{url('/admin/absent/add-from-file')}}">Thêm từ file</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Lớp</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Quản lí lớp:</h6>
          <a class="dropdown-item" href="{{url('/admin/class/list')}}">Xem Danh Sách</a>
          <a class="dropdown-item" href="{{url('/admin/class/add')}}">Thêm</a>
          <a class="dropdown-item" href="{{url('/admin/class/add-from-file')}}">Thêm từ file</a>
        </div>
      </li>



      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Giáo Viên/CVHT</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Quản lí GV/CVHT:</h6>
          <a class="dropdown-item" href="{{url('/admin/teacher/list')}}">Xem Danh Sách</a>
          <a class="dropdown-item" href="{{url('/admin/teacher/add')}}">Thêm</a>
        </div>
      </li>
            <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Ngành</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Quản lí ngành học:</h6>
          <a class="dropdown-item" href="{{url('/admin/major/list')}}">Xem Danh Sách</a>
          <a class="dropdown-item" href="{{url('/admin/major/add')}}">Thêm</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Khóa Học</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Quản lí khóa học:</h6>
          <a class="dropdown-item" href="{{url('/admin/course/list')}}">Xem Danh Sách</a>
          <a class="dropdown-item" href="{{url('/admin/course/add')}}">Thêm</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Sinh Viên</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Quản lí Sinh Viên:</h6>
          <a class="dropdown-item" href="{{url('/admin/student/list')}}">Xem Danh Sách</a>
          <a class="dropdown-item" href="{{url('/admin/student/add')}}">Thêm</a>
        </div>
      </li>
      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Hệ thống kỷ luật</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Quản lí hệ thống kỷ luật:</h6>
          <a class="dropdown-item" href="{{url('/admin/discipline/list')}}">Xem Danh Sách</a>
          <a class="dropdown-item" href="{{url('/admin/discipline/add')}}">Thêm</a>
        </div>
      </li>
    </ul>

@yield('content')

      <!-- Sticky Footer -->
          <footer class="container-fluid fluid-footer" style="display: flex;right: 0; bottom: 0; height: 80px; background-color: #e9ecef; margin-top: 80px;">
            <div class="container my-auto">
              <div class="copyright text-center my-auto">
                <span>Copyright © TDC Website 2019</span>
              </div>
            </div>
          </footer>
    </div>
    
    <!-- /.content-wrapper -->

  <!-- /#wrapper -->

  <!-- Scroll to Top Button-->
  <a class="scroll-to-top rounded" href="#page-top" style="left: 1250px">
    <i class="fas fa-angle-up"></i>
  </a>

 <!--  Bootstrap core JS 4.3 -->
 <script src="{{asset('bootstrap-4.3/js/bootstrap.min.js')}}"></script>

  <!-- Bootstrap core JavaScript-->
  <script src="{{asset('start/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('start/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('start/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

  <!-- Page level plugin JavaScript-->
  <script src="{{asset('start/vendor/datatables/jquery.dataTables.js')}}"></script>
  <script src="{{asset('start/vendor/datatables/dataTables.bootstrap4.js')}}"></script>

  <!-- Custom scripts for all pages-->
  <script src="{{asset('start/js/sb-admin.min.js')}}"></script>

  <!-- Demo scripts for this page-->
  <script src="{{asset('start/js/demo/datatables-demo.js')}}"></script>
   @yield('js-footer')
</body>

</html>
