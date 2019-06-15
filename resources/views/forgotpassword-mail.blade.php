<!DOCTYPE html>
<html>
<head>
	<title>asdsad</title>
	<style>
		body {
			font-family: Helvetica Neue,Helvetica,Lucida Grande,tahoma,verdana,arial,sans-serif !important;
			font-size: 16px !important;
		}

		button {
			font-size: 20px !important;
			background: #4c649b !important;
			padding: 7px !important;
			font-weight: bold !important;
		}
		a {
			color: #fff !important;
			text-decoration: none !important;
		}
		#note {
			margin-top: 30px !important;
			font-size: 12px !important;
			color: red !important;
		}
	</style>
</head>
<body><!---->

	<h3>Xin chào @if(isset($data)) {{$data['teacher_name']}}@endif,</h3>
	<p>Chúng tôi đã nhận được yêu cầu đặt lại mật khẩu của bạn. <br> Bấm vào nút Reset password để đặt lại mật khẩu</p>
	<button><a href="@if(isset($data)) {{route('showResetForm', $data['token'])}} @endif">Reset password</a></button>

	<p id="note">chỉ có hiệu lực trong 5 phút</p>
</body>
</html>
