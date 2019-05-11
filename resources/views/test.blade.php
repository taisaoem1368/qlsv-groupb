
<!DOCTYPE html>
<html>
<head>
    <title>Books Excel</title>
</head>
<body>

<form action="{{url('major/list-phpexcel')}}" method="post" enctype="multipart/form-data">
	<input type="hidden" name="_token" value="<?php echo csrf_token(); ?>">
	<input type="text" name="row">
	<input type="file" name="file_excel">
	<button>Gửi</button>	
</form>

{!! Form::open(['route' => 'books.booksListPhpExcel', 'method' => 'get', 'role' => 'form']) !!}
    {!! Form::submit('Xuất file excel sử dụng PHP Excel') !!}
{!! Form::close() !!}
 @if(isset($data))
 <?php dd($data); ?>
 @endif
</body>
</html>