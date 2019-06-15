@extends('admin.layout.master')
@section('title')
Dashboard
@stop
@section('css-header')

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
                  <i class="fas fa-check"></i>
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
              <div class="card mb-3">
          <div class="card-header">
            <i class="fas fa-chart-area"></i>
            Biểu đồ thể hiện số lượng sinh viên bị vi phạm kỷ luật trong 5 năm gần nhất</div>
          <div class="card-body">
            <canvas id="myChart"></canvas>
          </div>
          <div class="card-footer small text-muted">Updated at @if(isset($chartsValues)){{$chartsValues[2]}}@endif <a href="{{route('loadChart')}}">Reload <i class="fas fa-circle-notch"></i></a></div>
        </div>

@stop
@section('js-footer')

<script src="{{asset('js/chart2.8.0.js')}}"></script>
<script>
var chartsValues = <?php echo json_encode($chartsValues); ?>;
if(chartsValues)
{
  var ctx = document.getElementById('myChart').getContext('2d');

  var labels_arr = chartsValues[0];
  var data = chartsValues[1];




  var myChart = new Chart(ctx, {
      type: 'line',
      data: {
          labels: labels_arr,
          datasets: [{
              label: 'SV Vi Phạm',
              data: data,
              backgroundColor: [
                  'rgba(255, 99, 132, 0.2)',
                  'rgba(54, 162, 235, 0.2)',
                  'rgba(255, 206, 86, 0.2)',
                  'rgba(75, 192, 192, 0.2)',
                  'rgba(153, 102, 255, 0.2)',
                  'rgba(255, 159, 64, 0.2)'
              ],
              borderColor: [
                  'rgba(255, 99, 132, 1)',
                  'rgba(54, 162, 235, 1)',
                  'rgba(255, 206, 86, 1)',
                  'rgba(75, 192, 192, 1)',
                  'rgba(153, 102, 255, 1)',
                  'rgba(255, 159, 64, 1)'
              ],
              borderWidth: 1
          }]
      },
      options: {
          scales: {
              yAxes: [{
                  ticks: {
                      beginAtZero: true
                  }
              }]
          }
      }
  });
}
</script>
@stop