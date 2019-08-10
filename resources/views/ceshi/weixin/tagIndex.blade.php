@extends('admin.layout.conmmen')
@section('body')
    <div align="center">
        <h3>标签列表</h3>
        <h5>
            <a href="{{url('weixin/add_tag')}}">添加标签</a>
            <a href="{{url('weixin/index')}}">粉丝列表</a>
        </h5>
       <table width="600" border="1">
           <tr>
               <th>编号</th>
               <th>标签名</th>
               <th>粉丝数量</th>
               <th>操作</th>
           </tr>
        @foreach($data as $k=>$v)
           <tr>
               <td>{{$v['id']}}</td>
               <td>{{$v['name']}}</td>
               <td>{{$v['count']}}</td>
               <td>
                   <a href="{{url('weixin/tagDelete')}}?id={{$v['id']}}">删除</a>&nbsp|&nbsp
                   <a href="{{url('weixin/tagUpdate')}}?id={{$v['id']}}">修改</a>&nbsp|&nbsp
                   <a href="{{url('weixin/tagList')}}?id={{$v['id']}}">粉丝列表</a>&nbsp|&nbsp
                   <a href="{{url('weixin/addFansTag')}}?id={{$v['id']}}">添加粉丝到该标签</a>&nbsp|&nbsp
                   <a href="{{url('weixin/tag_push')}}?id={{$v['id']}}">根据标签推送消息</a>
               </td>
           </tr>
            @endforeach
       </table>
    </div>

@endsection

