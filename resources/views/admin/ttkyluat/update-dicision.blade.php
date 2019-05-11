@extends('admin.layout.master')
@section('title')
Cập nhật số quyết định
@stop
@section('css-header')
<style>
  .fluid-footer {
    margin-top: 250px !important;
  }
</style>
@stop
@section('content')
<div id="content-wrapper">

	<div class="container-fluid">

		<!-- Breadcrumbs-->
		<ol class="breadcrumb">
			<li class="breadcrumb-item">
				<a href="{{url('/admin/index')}}">Dashboard</a>
			</li>
			<li class="breadcrumb-item"><a href="{{url('/admin/disciplinary-information/list')}}">Thông Tin Kỷ Luật</a></li>
			<li class="breadcrumb-item active">Cập nhật số quyết định</li>
		</ol>
		<div class="card mb-3">
			<!-- DataTables Example -->
			<div class="card-header">
				<i class="fas fa-edit"></i>
			Cập nhật số quyết định</div>
<form action="{{Route('postUpdateSQD')}}" method="post">
  <input type="hidden" name="_token" value="{{csrf_token()}}">
<div class="container">
                 @if(Session::has('success'))
             <strong>Thông báo:</strong><br>
             <div class="alert alert-success">{{Session::get('success')}}
             </div>
             @endif
             @if(Session::has('message'))
             <strong>Thông báo:</strong><br>
  
             <div class="alert alert-danger">{{Session::get('message')}}
             </div>
             @endif
             @if (count($errors) > 0)
             <strong>Thông báo:</strong><br>
             <div class="alert alert-danger">
              <ul>
                @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
            @endif
</div>
  <div class="form-row">
    <div class="form-group col-md-2 offset-md-3">
      <label>Số quyết định</label>
      <input type="text" class="form-control" name="di_dicision" placeholder="Nhập số quyết định">
    </div>
    <div class="form-group col-md-2">
      <label>Học Kì</label>
      <select name="di_semester" class="form-control">
        <option value="1" selected>Học kỳ I</option>
        <option value="2">Học kỳ II</option>
      </select>
    </div>
    <div class="form-group col-md-2">
      <label>Năm học</label>
      <select name="di_year" class="form-control">
        <?php 
                        $year = date('Y');
                        for($k = $year; $k > $year-6; $k--)
                        {
                       ?>
                       <option value="{{$k}}">{{$k." - ".($k+1)}}</option>
                       <?php } ?>
      </select>
    </div>
  </div>
  <div class="form-group col-md-2 offset-md-5">
  	<button type="submit" class="btn btn-primary btn-update">Cập nhật</button>
  </div>
</form>
</div>
</div>
@stop