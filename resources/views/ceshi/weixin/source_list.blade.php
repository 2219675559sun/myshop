@extends('admin.layout.conmmen')
@section('body')
    <div align="center">

        <table width="800" border="1">
            <tr>
                <th>MEDIAID</th>
                <th>昵称</th>

                <th>操作</th>
            </tr>
            @foreach($arr as $k=>$v)
                <tr>
                    <td>{{$v['media_id']}}</td>
                    <td>{{$v['name']}}</td>
                    <td>
                        <a href="{{url('weixin/source_delete')}}?media_id={{$v['media_id']}}">删除</a>
                    </td>
                </tr>
            @endforeach
            <tr>
                <td colspan="3">语音总数量：{{$count['voice_count']}} &nbsp&nbsp 视频总数量:{{$count['video_count']}}
                    &nbsp&nbsp  图片总数量:{{$count['image_count']}} &nbsp&nbsp 图文总数量:{{$count['news_count']}}
                </td>
            </tr>
        </table>
    </div>
@endsection
