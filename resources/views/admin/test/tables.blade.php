@extends('admin.layout.master')
@section('title')
Table
@stop
@section('css-header')
<style>
.col-form-label {
  text-align: right;
}
form {
  font-size: 15px;
}
.form-add {
  margin-top: 20px;
}
.btn-upfile {
  padding-right: 50px;

}
</style>
@endsection
@section('content')

    <div id="content-wrapper">

      <div class="container-fluid">

        <!-- Breadcrumbs-->
        <ol class="breadcrumb">
          <li class="breadcrumb-item">
            <a href="#">Dashboard</a>
          </li>
          <li class="breadcrumb-item">Thông Tin Kỷ Luật</li>
          <li class="breadcrumb-item active">Thêm từ file</li>
        </ol>
      <div class="card mb-3">
        <!-- DataTables Example -->
          <div class="card-header">
            <i class="fa fa-plus" aria-hidden="true"></i>
            Thêm mới</div>
            <div class="form-add">
              <div class="container">
               <form class="col-xs-12">

                  <div class="form-group row">
                    <label class="col-sm-5 col-form-label">Chọn tệp (*.xls)</label>
                  <div class="col-sm-4 mr-md-auto">
                    <input type="file" class="form-control-file" id="exampleFormControlFile1">
                  </div>
                </div>
                <div class="form-group row">
                  <div class="col-sm-7 ml-md-auto">
                    <button type="submit" class="btn btn-primary">Upload</button>
                  </div>
                </div>
              </form>
              <div class="form-group row">
                  <div class="col-sm-7 ml-md-auto">
                    <a href="" class="btn btn-primary">Xem chi tiết danh sách</a>
                  </div>
                </div>
            </div>
          </div>
            </div>
          </div>
         
</div>

      <!-- /.container-fluid -->

      <!-- Sticky Footer -->
    <!-- /.content-wrapper -->

  @stop