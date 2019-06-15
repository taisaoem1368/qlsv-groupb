@extends('login.master')
@section('title', 'Đăng nhập')
@section('content')
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Login</div>
      <div class="card-body">
        <form action="{{url('/auth/post-login')}}" method="post">
         @if(Session::has('message'))
         <strong>Thông báo:</strong><br>

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
                <a href="{{route('getSendEmailForClient')}}">Quên mật khẩu?</a>
                
              </label>
            </div>
          </div>
          <button class="btn btn-primary btn-block"> Đăng nhập</button>
        </form>
      </div>
    </div>
  </div>


@stop
