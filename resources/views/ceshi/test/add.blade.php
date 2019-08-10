<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/jquery.js"></script>
    <title>添加</title>

</head>
<body>
<div align="center">
    <h3>添加题库</h3>
    <h5><a href="{{url('test/index')}}">查看试题</a></h5>
<table>
    选择题型：<select name="" id="">
        <option value="0">请选择</option>
        <option value="1">单选</option>
        <option value="2">多选</option>
        <option value="3">判断</option>
    </select>

</table>
<form action="">
    @csrf
    <table>
        <span style="color:red;">请选择出题规则</span>
    </table>
    <table>

    </table>
</form>
{{--单选--}}
<form action="{{url('test/radio')}}" method="post">
    <input type="hidden" name="type_id" value="1">
    @csrf
        题目：<input type="text" name="problem" style="width:500px;height: 30px;"><br>&nbsp&nbsp&nbsp;
        选项：<input type="radio" name="is_answer" value="1">A :<input type="text" name="a_optionA" style="width:430px;height: 30px;"><br>&nbsp&nbsp&nbsp;
            <input type="radio" name="is_answer"  value="2">B:<input type="text" name="a_optionB" style="width:430px;height: 30px;"><br>
            <input type="radio" name="is_answer"  value="3">C :<input type="text" name="a_optionC" style="width:430px;height: 30px;"><br>
            <input type="radio" name="is_answer"  value="4">D :<input type="text" name="a_optionD" style="width:430px;height: 30px;"><br>
    <input type="submit" value="添加">
</form>
{{--    多选--}}
<form action="{{url('test/checkbox')}}" method="post">
    @csrf
    题目：<input type="text" name="c_test" style="width:500px;height: 30px;"><br>&nbsp&nbsp&nbsp;
    选项：<input type="checkbox" name="c_correct[]" value="1">A :<input type="text" name="c_optionA" style="width:430px;height: 30px;"><br>&nbsp&nbsp&nbsp;
    <input type="checkbox" name="c_correct[]" value="2">B:<input type="text" name="c_optionB" style="width:430px;height: 30px;"><br>
    <input type="checkbox" name="c_correct[]" value="3">C :<input type="text" name="c_optionC" style="width:430px;height: 30px;"><br>
    <input type="checkbox" name="c_correct[]" value="4">D :<input type="text" name="c_optionD" style="width:430px;height: 30px;"><br>
    <input type="submit" value="添加">
</form>
{{--    判断--}}
<form action="{{url('test/exists')}}" method="post">
    @csrf
    题目：<input type="text" name="e_test" style="width:500px;height: 30px;"><br>&nbsp&nbsp&nbsp;
    选项：<input type="radio" name="e_crooect" value="1">对
    <input type="radio" name="e_crooect" value="2">错 <br>
     <input type="submit" value="添加">
</form>
</div>
</body>
</html>
<script>
    $(function(){
        $('form').hide();
       $('option').click(function(){
         var value=$(this).val();
        // alert(value);
           $('form').eq(value).show().siblings('form').hide();
       });
    });
</script>
