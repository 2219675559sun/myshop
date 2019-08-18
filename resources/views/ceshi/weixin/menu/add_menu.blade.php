@extends('admin.layout.conmmen')
@section('body')
    <div align="center">
        <h3>菜单添加</h3>
        <h5><a href="{{url('menu/menu')}}">刷新菜单列表</a></h5>
        <form action="{{url('menu/add_menu_do')}}" method="post">
            <input type="hidden" name="id" value="">
            @csrf
        菜单类型：<select name="men" id="" style="width:200px;height:30px;">
                <option value="0" class="menu">-- 全部类型 --</option>
                <option value="1" class="menu">一级菜单</option>
                <option value="2" class="menu">二级菜单</option>
            </select><br><br>
        <div id="menu" hidden>
            菜单子分类：<select name="menu" id="" style="width:200px;height:30px;">
            @foreach($data as $k=>$v)
                @if($v->one_name!=null && $v->type=='view')
                    <option value="{{$v->id}}">{{$v->one_name}}</option>
                    @endif
                @endforeach
            </select><br><br>
        </div>
            <div id="one">
            菜单名称：<input type="text" name="one_name" style="width:500px;height:30px;"><br><br>
            </div>
            <div id="two">
            二级菜单名称：<input type="text" name="two_name" style="width:500px;height:30px;"><br><br>
            </div>
            菜单标识（标识或url）：<input type="text" name="url" style="width:500px;height:30px;"><br><br>
            事件类型：<select name="type" id="" style="width:200px;height:30px;">
                <option value="view">view表示网页类型</option>
                <option value="click">click表示点击类型</option>
                <option value="miniprogram">miniprogram表示小程序类型</option>
            </select><br><br>
            <input type="submit" value="提交">
        </form>
        <br><br><br><br><br>
        <table width="800" border="1">
            <h3>菜单展示</h3>
            <tr>
                <th>ID</th>
                <th>一级菜单</th>
                <th>二级菜单</th>
                <th>类型</th>
                <th>url</th>
                <th>添加时间</th>
                <th>操作</th>
            </tr>
                @foreach($info as $k=>$v)
            <tr>
                <td>{{$v->id}}</td>
                <td>{{$v->one_name}}</td>
                <td>{{$v->two_name}}</td>
                <td>{{$v->type}}</td>
                <td>{{$v->url}}</td>
                <td>{{date('Y-m-d H:i:s',$v->add_time)}}</td>
                <td>
                    <a href="{{url('menu/delete_menu')}}?id={{$v->id}}">删除</a>
                </td>
            </tr>
                    @endforeach
        </table>
    </div>

@endsection
@section('script')
    <script>
        $(function(){
           $('.menu').click(function(){
             var value=$(this).val();
             if(value==1){
                $('#two').hide().siblings().show();
                 $('#menu').hide();
             }else if(value==2){
                 $('#one').hide().siblings().show();
             }else if(value==0){
                 $('#menu').siblings().show();
                 $('#menu').hide();
             }
           });
        });
    </script>
@endsection
