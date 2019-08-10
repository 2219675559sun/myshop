@extends('admin.layout.conmmen')
@section('body')
    <div align="center">
        <h3>标签推送消息</h3>
        <form action="{{url('weixin/tag_push_do')}}" method="post">
            <input type="hidden" name="tagid" value="{{$tagid}}">
            @csrf
            类型选择:
            <select name="select" id="">
                <option value="1">文本</option>
                <option value="2">图片</option>
            </select><br><br>
            <textarea name="text" id="" cols="30" rows="10"></textarea><br>
            <input type="submit" value="发送" style="width:100px;">
        </form>
    </div>

@endsection

