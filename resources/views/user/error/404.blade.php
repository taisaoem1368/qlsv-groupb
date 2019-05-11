
@extends('user.layout.master')
@section('title')
404 Error
@stop
@section('content')

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="{{url('/user/index')}}">Dashboard</a>
          </li>
          <li class="breadcrumb-item active">404 Error</li>
        </ol>

        <!-- Page Content -->
        <h1 class="display-1">404</h1>
        <p class="lead">Không tìm thấy trang. Bạn có thể trở về
          <a href="{{url('/user/index')}}">trang home</a>.</p>

      </div>
      <!-- /.container-fluid -->

 @stop