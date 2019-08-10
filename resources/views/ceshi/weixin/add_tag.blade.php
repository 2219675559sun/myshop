@extends('admin.layout.conmmen')
@section('body')
    <div align="center">
        <h3>创建标签</h3>
        <form action="{{url('weixin/add_tag_do')}}" method="post" enctype="multipart/form-data">
            @csrf
            标签名：<input type="text" name="tag"> <br> <br>
            <input type="submit" value="提交">
        </form>
    </div>

@endsection

