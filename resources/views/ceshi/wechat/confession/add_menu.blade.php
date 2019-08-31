@extends('admin.layout.conmmen')
@section('body')
    <div align="center">
    <h3>菜单添加</h3>
        <h5><a href="{{url('confession/menu')}}">菜单刷新</a></h5>
        <form action="{{url('confession/add_menu_do')}}" method="post">
            @csrf
            列表选择：<select name="men" style="width:200px;height:30px;">
                <option value="1" class="option">一级列表</option>
                <option value="2" class="option">二级列表</option>
            </select><br><br>

            <div id="select" hidden>
                一级菜单列表：<select name="menu" id="" style="width:200px;height:30px;">
                    @foreach($data as $k=>$v)
                        @if($v->one_name!='' && $v->type=='view')
                            <option value="{{$v->id}}">{{$v->one_name}}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            <br>
            <div id="one">
                菜单名称：<input type="text" name="name" style="width:500px;height:30px;"><br><br>
            </div>

            菜单标识（标识或url）：<input type="text" name="url" style="width:500px;height:30px;"><br><br>
            事件类型：<select name="type" id="" style="width:200px;height:30px;">
                <option value="view">view表示网页类型</option>
                <option value="click">click表示点击类型</option>
                <option value="miniprogram">miniprogram表示小程序类型</option>
            </select><br><br>
            <input type="submit" value="提交">
        </form>
    <h3>菜单展示</h3>
        <table width="800" border="1">
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
                    <a href="{{url('confession/delete_menu')}}?id={{$v->id}}">删除</a>
                </td>
            </tr>
                @endforeach
        </table>
    </div>
@endsection
@section('script')
    <script>
        $(function(){
            $('.option').click(function(){
               var value= $(this).val();
              if(value==2){
                  $('#select').show();
              }else{
                  $('#select').hide();
              }
            });
        })
    </script>
@endsection
