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
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
  @yield('css-header')
</head>

<body id="page-top">

  <nav class="navbar navbar-expand navbar-dark bg-dark static-top">

    <a class="navbar-brand mr-1" href="{{url('/user/index')}}">QUẢN LÝ SINH VIÊN</a>

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
          <a class="dropdown-item" href="{{Route('getProfile')}}">{{Auth::user()->user_teacher_code}}</a>
          <div class="dropdown-divider"></div>
          <a class="dropdown-item" href="{{url('/logout')}}" >Đăng xuất</a>
        </div>
      </li>
    </ul>

  </nav>

  <div id="wrapper">

    <!-- Sidebar -->
    <ul class="sidebar navbar-nav">
      <li class="nav-item">
        <a class="nav-link" href="{{url('/user/index')}}">
          <i class="fas fa-fw fa-tachometer-alt"></i>
          <span>Tổng Quan</span>
        </a>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Thông Tin Kỷ Luật</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Quản lí thông tin kỷ luật:</h6>
          <a class="dropdown-item" href="{{url('/user/discipline/list')}}">Xem Danh Sách</a>
        </div>
      </li>

      <li class="nav-item dropdown">
        <a class="nav-link dropdown-toggle" href="#" id="pagesDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
          <i class="fas fa-fw fa-folder"></i>
          <span>Kỷ luật SV Vắng</span>
        </a>
        <div class="dropdown-menu" aria-labelledby="pagesDropdown">
          <h6 class="dropdown-header">Quản lí thông tin kỷ luật:</h6>
          <a class="dropdown-item" href="{{url('/user/absent/list')}}">Xem Danh Sách</a>
        </div>
      </li>
    </ul>

@yield('content')

      <!-- Sticky Footer -->
      <footer class="sticky-footer">
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
  <a class="scroll-to-top rounded" href="#page-top">
    <i class="fas fa-angle-up"></i>
  </a>


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
