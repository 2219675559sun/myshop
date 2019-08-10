@extends('admin.layout.conmmen')
@section('body')
    <div align="center">
        <h3>修改标签</h3>
        <form action="{{url('weixin/tagUpdate_do')}}" method="post" enctype="multipart/form-data">
            <input type="hidden" name="id" value="{{$id}}">
            @csrf
            标签名：<input type="text" name="tag"> <br> <br>
            <input type="submit" value="提交">
        </form>
    </div>

@endsection

