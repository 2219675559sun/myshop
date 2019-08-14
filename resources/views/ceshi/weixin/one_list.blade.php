@extends('admin.layout.conmmen')
@section('body')
    <div align="center">
        <h3>个人信息</h3>
        <form action="{{url('weixin/out_fans_tag')}}" method="post">
            <input type="hidden" name="id" value="">
            @csrf
            <table width="800" border="1">
                <tr>
                    <th>UID</th>
                    <th>昵称</th>
                    <th>权限</th>
                    <th>二维码</th>
                    <th>登录时间</th>
                    <th>操作</th>
                </tr>
                @foreach($arr as $k=>$v)
                    <tr>
                        <td>{{$v['id']}}</td>
                        <td>{{$v['name']}}</td>
                        <td>{{$v['state']==1?'普通用户':'管理员'}}</td>
                        <td>@if($v['agent_code']!='0')<img src="{{$v['agent_code']}}" width="100" alt="">@else 请先下载 @endif</td>
                        <td>{{date('Y-m-d H:i:s',$v['reg_time'])}}</td>
                        <td>
                            <a href="{{url('weixin/qrCode')}}?id={{$v['id']}}">生成二维码</a>&nbsp
                            <a href="{{url('weixin/download')}}?id={{$v['id']}}">二维码下载</a>
                        </td>
                    </tr>
                @endforeach
                </tr>
            </table>
        </form>
    </div>

@endsection

