@extends('login.master')
@section('title', 'Đổi mật khẩu')
@section('css')
  <style>
    #captcha {
      letter-spacing: 5px;
      margin-left: 20px;
      font-weight: bold;
    }
    #warning {
      font-size: 12px;
      color: red;
      font-weight: bold;
    }
  </style>
@stop
@section('content')
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Đổi mật khẩu</div>
      <div class="card-body">
        <form action="{{route('postChangePassword')}}" method="post">
         @if(Session::has('message'))
         <div class="alert alert-danger">{{Session::get('message')}}
         </div>
         @endif
         @if(Session::has('success'))
         <div class="alert alert-success">{{Session::get('success')}}
         </div>
         @endif
                  @if (count($errors) > 0)
             <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
        <input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
        
        <input type="hidden" name="token" value="{{$token}}">
          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="inputEmail" class="form-control" name="password" required="required" autofocus="autofocus">
              <label for="inputEmail">Mật khẩu mới</label>
            </div>
            <span id="warning">Tối thiểu 6 kí tự và tối đa 32 kí tự</span>
          </div>

          <div class="form-group">
            <div class="form-label-group">
              <input type="password" id="inputPassword" class="form-control" name="repassword" required="required">
              <label for="inputPassword">Nhập lại mật khẩu</label>
            </div>
          </div>
          <button class="btn btn-primary btn-block">Đổi mật khẩu</button>
        </form>
      </div>
    </div>
  </div>


<script type="text/javascript">
  var exits = "{{Session::get('message')}}";
  if(exits)
  {
    alert("Sai tài khoản hoặc mật khẩu");
  }
</script>
@stop
