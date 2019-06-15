@extends('login.master')
@section('title', 'Quên mật khẩu')
@section('css')
  <style>
    #captcha {
      letter-spacing: 5px;
      margin-left: 20px;
      font-weight: bold;
      border: 1px solid #000;
      padding: 0px 5px;
      -webkit-user-select: none;  /* Chrome all / Safari all */
      -moz-user-select: none;     /* Firefox all */
      -ms-user-select: none;      /* IE 10+ */
      user-select: none; 
      /*background-image: linear-gradient(blue, yellow, red);*/
      background-image: linear-gradient(to right, red,orange,yellow,green,blue,indigo,violet);
      text-shadow: black 0.1em 0.1em 0.5em;
      font-size: 22px;
    }
  </style>
@stop
@section('content')
  <div class="container">
    <div class="card card-login mx-auto mt-5">
      <div class="card-header">Quên mật khẩu</div>
      <div class="card-body">
        <form action="{{route('postSendEmailForClient')}}" method="post">
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
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="inputEmail" class="form-control" name="email_reset" required="required" autofocus="autofocus">
              <label for="inputEmail">Email lấy lại mật khẩu</label>
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <?php $captcha_id = rand(10000, 20000); ?>
              <span>Mã kiểm tra:</span><span id="captcha">{{$captcha_id}}</span>
              <input type="hidden" name="captcha" value="{{$captcha_id}}">
            </div>
          </div>
          <div class="form-group">
            <div class="form-label-group">
              <input type="text" id="inputCaptcha" class="form-control" name="recaptcha" required="required">
              <label for="inputCaptcha">Nhập mã kiểm tra</label>
            </div>
          </div>
          <div class="form-group">
            <div class="checkbox">
              <label>
                <a href="{{route('getLogin')}}">Đăng nhập</a>
                
              </label>
            </div>
          </div>
          <button class="btn btn-primary btn-block">Reset</button>
        </form>
      </div>
    </div>
  </div>

@stop
