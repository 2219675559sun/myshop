@extends('admin.layout.conmmen')
@section('body')
<div align="center">
    <h3>素材列表</h3>
    <form action="{{url('weixin/do_upload')}}" method="post" enctype="multipart/form-data">
        @csrf
       素材类型选择： <select name="source" id="">
            <option value="1">临时素材</option>
            <option value="2">永久素材</option>
        </select> <br> <br>
        <span>上传图片</span>
        文件：<input type="file" name="image" value=""><br/><br/>
        <span>上传语音</span>
        文件：<input type="file" name="voice" value=""><br/><br/>
        <span>上传视频</span>
        文件：<input type="file" name="video" value=""><br/><br/>
        <span>上传缩略图</span>
        文件：<input type="file" name="thumb" value=""><br/><br/>
        <input type="submit" value="提交">
    </form>
</div>

@endsection

