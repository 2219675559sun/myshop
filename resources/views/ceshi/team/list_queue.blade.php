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
    <h3>比赛结果</h3><p>前台参加竞赛</p>
    <form action="{{url('team/list_queue_do')}}" method="post">
        @csrf
        <table>

                <input type="hidden" name="id" value="{{$data->id}}">
                <tr>
                    <td>{{$data->one}} V S {{$data->two}}</td>
                </tr>

                <tr>
                    &nbsp
                    @if($join==null)
                    <td>
                        <input type="radio" name="result" value="1">胜
                        <input type="radio" name="result" value="2">平
                        <input type="radio" name="result" value="3">败
                    </td>
                        @else
                        @if($join->j_result==1)
                        <input type="radio" name="result" value="1" checked>胜
                            @else
                            <input type="radio" name="result" value="1">胜
                        @endif
                            @if($join->j_result==2)
                                <input type="radio" name="result" value="2" checked>平
                            @else
                                <input type="radio" name="result" value="2">平
                            @endif
                            @if($join->j_result==3)
                                <input type="radio" name="result" value="3" checked>败
                            @else
                                <input type="radio" name="result" value="3">败
                            @endif

                        @endif
                </tr>
                <tr>
                    <td>
                        @if($join==null)
                            <input type="submit" value="参加竞赛"></td>
                        @else
                    <button disabled>您已参加</button>
                            @endif
                </tr>


        </table>
    </form>
</div>
</body>
</html>
