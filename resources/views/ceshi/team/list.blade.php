<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>竞赛结果</title>
</head>
<body>
<div align="center">
    <h3>比赛结果</h3><p>前台详情</p>
        <table>
       对阵结果：
            @if($data->result==0)
                正在开奖，请耐心等待
                @else
                @if($data->result==1)
                {{$data->one}}胜{{$data->two}}
                @endif
            @if($data->result==2)
                {{$data->one}}平{{$data->two}}
            @endif
            @if($data->result==3)
                {{$data->one}}负{{$data->two}}
            @endif
            <br>
            您的竞猜：
            @if($join==null)
                您没有参加竞猜
            @else
            @if($join->j_result==1)
                {{$data->one}}胜{{$data->two}}
            @endif
            @if($join->j_result==2)
                {{$data->one}}平{{$data->two}}
            @endif
            @if($join->j_result==3)
                {{$data->one}}负{{$data->two}}
            @endif
            <br>
            结果： @if($join->j_result==$data->result)
                恭喜你猜对了
                    @else
                    很遗憾，您没有猜中
            @endif
                @endif
            @endif
        </table>
    </form>
</div>
</body>
</html>
