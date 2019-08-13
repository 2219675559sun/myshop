@extends('admin.layout.conmmen')
@section('body')
    <div align="center">
        <h3>个人信息</h3>
        <form action="{{url('weixin/out_fans_tag')}}" method="post">
            <input type="hidden" name="id" value="">
            @csrf
            <table width="800" border="1">
                <tr>
                    <th>编号</th>
                    <th>OPENID</th>
                    <th>昵称</th>
                    <th>UID</th>
                    <th>权限</th>
                    <th>登录时间</th>
                    <th>操作</th>
                </tr>
                @foreach($arr as $k=>$v)
                    <tr>
                        <td>{{$v['id']}}</td>
                        <td>{{$v['openid']}}</td>
                        <td>{{$v['name']}}</td>
                        <td>{{$v['uid']}}</td>
                        <td>{{$v['state']==1?'普通用户':'管理员'}}</td>
                        <td>{{date('Y-m-d H:i:s',$v['add_time'])}}</td>
                        <td>
                            <a href="{{url('weixin/qrCode')}}?id={{$v['id']}}">生成二维码</a>
                        </td>
                    </tr>
                @endforeach
                </tr>
            </table>
        </form>
    </div>

@endsection

