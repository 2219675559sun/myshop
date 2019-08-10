<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <script src="/jquery.js"></script>
   <script src="{{asset('layui/layui.all.js')}}"></script>
    <script src="{{asset('layui/layui.js')}}"></script>
    <title>添加过车票</title>
</head>
<body>
<form action="{{url('12306/add_do')}}" method="post" id="myform">
    @csrf
    <table>
    <tr>
        <th>车次：</th>
       <td><input type="text" name="carnum"></td>
    </tr>
        <tr>
            <th>出发地：</th>
            <td><input type="text" name="start"></td>
        </tr>
        <tr>
            <th>到达地：</th>
            <td><input type="text" name="place"></td>
        </tr>
        <tr>
            <th>座次：</th>
            <td>
                <input type="checkbox" name="degree" value="1" checked>一等座 <input type="number" name="number">票数 <input type="number" name="price">单价 <br>
                <input type="checkbox"  name="2degree" value="2">二等座 <input type="number" name="2number">票数 <input type="number" name="2price">单价 <br>
                <input type="checkbox"  name="3degree" value="3">硬座 <input type="number" name="3number">票数 <input type="number"  name="3price">单价 <br>
                <input type="checkbox"  name="4degree" value="4">无座 <input type="number" name="4number">票数 <input type="number"  name="4price">单价 <br>
            </td>
        </tr>
        <tr>
            <th>出发时间：</th>
            <td><input type="text" name="add_time"></td>
        </tr>
        <tr>
            <th>到达时间：</th>
            <td><input type="text" name="over_time"></td>
        </tr>
        <tr>
            <th colspan="2"><input type="submit" value="添加" class="submit"></th>

        </tr>
        
    </table>
</form>
</body>
</html>
<script>
    //Demo
    layui.use('form', function(){
        var form = layui.form;

        //监听提交
        form.on('submit(formDemo)', function(data){
            layer.msg(JSON.stringify(data.field));
            return false;
        });
    });
    $(function(){
       $('#myform').submit(function(){
           var data=$('#myform').serialize();
           console.log(data);
       });
       return false;
    });
</script>
