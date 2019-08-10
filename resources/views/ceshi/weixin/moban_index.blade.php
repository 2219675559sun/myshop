@extends('admin.layout.conmmen')
@section('body')
    <table class="layui-table">
        <colgroup>
            <col width="150">
            <col width="200">
            <col>
        </colgroup>
        <thead>
        <tr>

            <th>模板ID</th>
            <th>模板标题</th>
            <th>模板内容</th>
            <th>操作</th>
        </tr>
        </thead>
        <tbody>
        @foreach($data as $k=>$v)
            <tr>

                <td>{{$v['template_id']}}</td>
                <td>{{$v['title']}}</td>
                <td>{{$v['content']}}</td>
                <td>
                    <a href="">删除</a>
                </td>
            </tr>
        @endforeach
        </tbody>
    </table>
@endsection

