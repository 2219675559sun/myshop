<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<link rel="stylesheet" href="/page.css">
</head>
<body>	
	<form action="{{url('student/index')}}">
		姓名：<input type="text" name="name" value="{{$name}}">
		<input type="submit" value="搜索">
	</form>

	<table width="500" border="1">
	<tr>
		<td>id</td>
		<td>姓名 </td>
		<td>年龄</td>
		<td>性别</td>
		<td>头像</td>
		<td>操作</td>
	</tr>
	@foreach($data as $v)

	<tr>
		<td>{{$v->id}}</td>
		<td>{{$v->name}}</td>
		<td>{{$v->age}}</td>
		<td>{{$v->sex==1?'男':'女'}}</td>
		<td><img src="{{$v->image}}" width="50" height="50" alt=""></td>
		<td><a href="delete?id={{$v->id}}">删除</a>||
			<a href="{{url('student/update')}}?id={{$v->id}}">修改</a>
		</td>
	</tr>
		@endforeach
	
	<tr>
		<td colspan="5" align="center">
		{{$data->appends(['name' => $name])->links()}}
		</td>
	</tr>
</table>

	<div style="background-color: pink-;">当前共访问{{$num}}次</div>


</body>
</html>