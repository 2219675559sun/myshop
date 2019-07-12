<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>登录页面</title>
</head>
<body>
	<form action="{{url('student/login')}}" method="post">
		@csrf
	<table width="350" border="1">

		<tr>
			<td>用户名：</td>
			<td><input type="text" name="user"></td>
		</tr>
		<tr>
			<td>密码：</td>
			<td><input type="text" name="pwd"></td>
		</tr>
		<tr>
			<td colspan="2" align="center"><input type="submit" value="登录"></td>
		</tr>
	</table>

	</form>
</body>
</html>