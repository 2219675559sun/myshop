@extends('admin.layout.conmmen')
@section('body')
    <div align="center">
        <h3>标签下所有粉丝</h3>
        <form action="{{url('weixin/out_fans_tag')}}" method="post">
            <input type="hidden" name="id" value="{{$id}}">
            @csrf
            <table width="500" border="1">
                <tr>
                    <th><input type="checkbox" checked></th>
                    <th>OPENID</th>
                    <th>昵称</th>
                    <th>操作</th>
                </tr>
                @foreach($list as $k=>$v)
                    <tr>
                        <td><input type="checkbox" name="openid[]" value="{{$v['openid']}}"></td>
                        <td>{{$v['openid']}}</td>
                        <td>{{$v['nickname']}}</td>
                        <td>
                            <a href="{{url('weixin/get_tag')}}?openid={{$v['openid']}}">查看用户标签</a>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" align="center">
                        <input type="submit" value="取消粉丝">
                    </td>
                </tr>
            </table>
        </form>
    </div>

@endsection

