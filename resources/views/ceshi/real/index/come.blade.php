<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>出库</title>
</head>
<body>
<div align="center">
    <h2>车辆出库</h2>
    <form action="{{url('car/come_do')}}" method="post">
        @csrf
        <table>
            <b>车牌号: </b><input type="text" name="car" style="width:500px;height: 50px;"><br>
            <input type="submit" value="车辆出库" style="width:100px;height: 50px;">
        </table>
    </form>
</div>
</body>
</html>
