<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/jquery.js"></script>
    <title>竞猜队列添加</title>
</head>
<body>
<div align="center">
    <h3>添加竞猜球队</h3><p>后台添加</p>
    <h5><a href="{{url('team/queue')}}">竞猜结果判断</a></h5>
<form action="{{url('team/queueadd_do')}}" method="post" id="myform">
    @csrf

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <input type="text" class="one" name="one">&nbsp&nbsp V  S &nbsp&nbsp<input type="text" class="two" name="two"><br>
    结束竞猜时间：<input class="time" type="text" name="over_time"><br>
    <input class="submit" type="submit" value="添加">
</form>
</div>
</body>
</html>
<script>
    // $('#myform').submit(function(){
    //     // alert(1);
    //     var data=$('#myform').serialize();
    //     console.log(data);
        {{--$.post("{{url('team/queueadd_do')}}",data,function(res){--}}
            // console.log(res);
        // });
    //     return false;
    // });
    $(function(){
        $('.time').click(function(){
            var one=$('.one').val();
            var two=$('.two').val();
           if(one==two){
               alert('竞猜队列不可相同');
           }
        });
    })
</script>
