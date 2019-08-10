@extends('admin.layout.conmmen')
@section('body')
    <div align="center">
        <h3>添加粉丝到标签</h3>
        <form action="{{url('weixin/addFansTag_do')}}" method="post">
            <input type="hidden" name="id" value="{{$id}}">
            @csrf
            <table width="500" border="1">
                <tr>
                    <th><input type="checkbox" checked></th>
                    <th>OPENID</th>
                    <th>昵称</th>
                </tr>
                @foreach($list as $k=>$v)
                <tr>
                        <td><input type="checkbox" name="openid[]" value="{{$v['openid']}}"></td>
                        <td>{{$v['openid']}}</td>
                        <td>{{$v['nickname']}}</td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="5" align="center">
                        <input type="submit" value="添加粉丝">
                    </td>
                </tr>
            </table>
        </form>
    </div>

@endsection

