<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>结果</title>
</head>
<body>
<div align="center">
    <h3>比赛结果</h3><p>后台修改</p>
    <form action="{{url('team/update_resule_do')}}" method="post">
        @csrf
    <table>
        @foreach($data as $k=>$v)
            <input type="hidden" name="id" value="{{$v->id}}">
        <tr>
            <td>{{$v->one}} V S {{$v->two}}</td>
       </tr>

         <tr>
             &nbsp
        <td>
            @if($v->result==0)
                <input type="radio" name="result" value="1">胜
                <input type="radio" name="result" value="2" checked>平
                <input type="radio" name="result" value="3">败
                @else
                @if($v->result==1)
                    <input type="radio" name="result" value="1" checked>胜
                    @else
                    <input type="radio" name="result" value="1">胜
                    @endif
                    @if($v->result==2)
                        <input type="radio" name="result" value="2" checked>平
                    @else
                        <input type="radio" name="result" value="2">平
                    @endif
                    @if($v->result==3)
                        <input type="radio" name="result" value="3" checked>败
                    @else
                        <input type="radio" name="result" value="3">败
                    @endif
            @endif
            </td>
        </tr>
            <tr>
                <td>
                    @if($v->result==0)
                        <input type="submit" value="提交">
                        @else
                    <button disabled>已提交</button>
                        @endif
                </td>

            </tr>

            @endforeach
    </table>
    </form>
</div>
</body>
</html>
