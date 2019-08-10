@extends('ceshi.real.commect')

@section('title', '门卫添加')
<div clign="certen">
    @section('body')
        <form action="{{url('real/add_doorkeeper_do')}}" method="post">
            @csrf
    用户名：<input type="text" name="name" style="width:500px;height: 50px;"><br>
        密码：<input type="password" name="pwd" style="width:500px;height: 50px;"><br>
        <input type="submit" value="门卫添加">
        </form>
    @endsection
</div>
