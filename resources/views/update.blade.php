<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>修改</title>
</head>
<body>
	<form action="{{url('student/do_update')}}" method="post">
	
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
	<input type="hidden" name="id" value="{{$res->id}}">
	姓名：<input type="text" name="name" value="{{$res->name}}"><br>
	年龄：<input type="text" name="age" value="{{$res->age}}"><br>
		@if($res->sex==1)
		性别：<input type="radio" name="sex" value="1" checked>男
		 	 <input type="radio" name="sex" value="2">女<br>
		@else
		性别：<input type="radio" name="sex" value="1">男
			  <input type="radio" name="sex" value="2" checked>女<br>
		  @endif
	
	<input type="submit" value="修改">

	</form>
</body>
</html>