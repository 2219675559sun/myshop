<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>添加页面</title>
</head>
<body>
	<form action="{{url('student/do_add')}}" method="post" enctype="multipart/form-data">
	@if ($errors->any())
    <div class="">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
	@endif
	@csrf
	姓名：<input type="text" name="name"><br>
	年龄：<input type="text" name="age"><br>
	性别：<input type="radio" name="sex" value="1" checked>男
		<input type="radio" name="sex" value="2">女<br>
	头像：<input type="file" name="image"><br>
	<input type="submit" value="添加">

	</form>
</body>
</html>