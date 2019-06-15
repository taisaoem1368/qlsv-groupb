<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <!-- Bootstrap CSS -->

    <title>Hello, world!</title>
    <style>
    	table, th, td{
    		border: 1px solid;
    		padding: 10px;
    	}
    	table {
		  border-collapse: collapse;
		}

    </style>
  </head>
  <body>
  	<?php $link = $_SERVER['HTTP_HOST']; ?>
	<h3>Chào thầy/cô <?php if(isset($data)) echo $data['teacher_fullname'].','; ?></h3>
	<p>Thông báo về việc GV/CVHT phản hồi cho khoa, thông tin sinh viên bị vi phạm kỷ luật học kỳ @if(isset($data)) {{$data['hocky']}} @endif năm học @if(isset($data)) {{$data['namhoc'].'-'.($data['namhoc']+1)}} @endif. Vui lòng liên lạc với sinh viên vi phạm và phản hồi tại website: <a href="{{'http://'.$link}}">{{$link}}</a></p>
	<p>Hạn chót ngày @if(isset($data)) {{date('d/m/Y', strtotime($data['dealtime']))}} @endif</p>
	<h5>DANH SÁCH SINH VIÊN BỊ VI PHẠM CHƯA PHẢN HỒI</h4>
	<p></p>
<table>
  <thead>
    <tr>
      <th scope="col">STT</th>
      <th scope="col">Họ và Tên</th>
      <th scope="col">Mã sinh viên</th>
      <th scope="col">Lớp</th>
    </tr>
  </thead>
  <tbody>
  @if(isset($data)) 
  <?php $i = 0; ?>
  @foreach($data['student'] as $v)
    <tr>
      <th scope="row">{{++$i}}</th>
      <td>{{$v->student_fullname}}</td>
      <td>{{$v->student_code}}</td>
      <td>{{$v->class_code}}</td>
    </tr>
  @endforeach
  @endif
  </tbody>
</table>

  </body>
</html>