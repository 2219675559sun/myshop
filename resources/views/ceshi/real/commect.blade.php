<html>
<head>
    <title>App Name - @yield('title')</title>
</head>
<body>
@section('sidebar')
   <h1>物业管理</h1>
    <h3><a href="{{url('real/add_carport')}}">添加车位信息</a></h3>
   <h3><a href="{{url('real/count')}}">数据统计</a></h3>
   <h3><a href="{{url('real/add_doorkeeper')}}">添加门卫</a></h3>
@show
<div align="center">
@section('body')

@show
</div>
<div class="container">
    @yield('content')
</div>
</body>
</html>
