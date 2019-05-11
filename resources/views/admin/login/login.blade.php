<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">

  <title>Login</title>

  <!-- Custom fonts for this template-->
  <link href="{{asset('start/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">

  <!-- Custom styles for this template-->
  <link href="{{asset('start/css/sb-admin.css')}}" rel="stylesheet">
  <style type="text/css">
    .action {

      border-bottom: 1px solid #d8d8d8;
    }
  </style>
</head>

<body class="bg-dark">

  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form action="{{url('/auth/post-login')}}" method="post">
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="inputEmail" class="form-control" name="user_teacher_code" required="required" autofocus="autofocus">
              <label for="inputEmail">Tên đăng nhập</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="inputPassword" class="form-control" name="password" required="required">
              <label for="inputPassword">Mật mã</label>
            </div>
          </div>
          <div class="form-group">
            <div class="checkbox">
              <label>
                <input type="checkbox" value="remember-me" disabled="disabled">
                Ghi nhớ lần đăng nhập sau
              </label>
            </div>
          </div>
          <button class="btn btn-primary btn-block"> Đăng nhập</button>
        </form>
      </div>
    </div>
  </div>

  <!-- Bootstrap core JavaScript-->
  <script src="{{asset('start/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('start/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>

  <!-- Core plugin JavaScript-->
  <script src="{{asset('start/vendor/jquery-easing/jquery.easing.min.js')}}"></script>

</body>

</html>
<script type="text/javascript">
  var exits = "{{Session::get('message')}}";
  if(exits)
  {
    alert("Sai tài khoản hoặc mật khẩu");
  }
</script>
