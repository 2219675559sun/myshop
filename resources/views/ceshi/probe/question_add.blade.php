<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/jquery.js"></script>
    <title>添加问题</title>
</head>
<body>
<div align="center">
    <h3>问题添加</h3>
    <h5><a href="{{url('probe/index')}}">调研项目列表</a></h5>
<form action="{{url('probe/question_add_do')}}" method="post">
    @csrf
    <table>
        调研问题：<input type="text" name="question" style="width:500px;height:50px;"><br>
        问题选项： <span class="div">
        <input type="radio" id="radio" name="type" value="1">单选 <input type="checkbox" name="type" id="checkbox" value="2">多选 <br>
        </span>
      <span class="radio">
            <input type="radio" name="correct" value="1">  <input type="text" name="descA" style="width:500px;height:50px;"> <br>
            <input type="radio" name="correct" value="2">  <input type="text" name="descB" style="width:500px;height:50px;"> <br>
            <input type="radio" name="correct" value="3">  <input type="text" name="descC" style="width:500px;height:50px;"> <br>
            <input type="radio" name="correct" value="4">  <input type="text" name="descD" style="width:500px;height:50px;"> <br>
     </span>
        <span class="checkbox">
            <input type="checkbox" name="correct[]" value="1">  <input type="text" name="ddescA" style="width:500px;height:50px;"> <br>
            <input type="checkbox" name="correct[]" value="2">  <input type="text" name="ddescB" style="width:500px;height:50px;"> <br>
            <input type="checkbox" name="correct[]" value="3">  <input type="text" name="ddescC" style="width:500px;height:50px;"> <br>
            <input type="checkbox" name="correct[]" value="4">  <input type="text" name="ddescD" style="width:500px;height:50px;"> <br>

        </span>
             <input type="submit" value="添加问题">
    </table>
</form>
</div>
</body>
</html>
<script>
    $('.radio').hide();
    $('.checkbox').hide();
    $(function(){
        $('#radio').click(function(){
            $('.radio').show();
            $('.div').hide();
        });
        $('#checkbox').click(function(){
            $('.checkbox').show();
            $('.div').hide();
        });
    });
</script>
