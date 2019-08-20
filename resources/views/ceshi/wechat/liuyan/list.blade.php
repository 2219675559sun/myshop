<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
        <div align="center">
            <table width="200" border="1">
                <tr>
                    <th>留言内容</th>
                </tr>
                @foreach($data as $k=>$v)
                    <tr>
                        <td>{{$v->content}}</td>
                    </tr>
                    @endforeach
            </table>
        </div>
</body>
</html>
