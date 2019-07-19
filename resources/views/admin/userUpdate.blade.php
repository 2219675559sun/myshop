@extends('admin.layout.conmmen')
@section('body')
<form class="layui-form" action="{{url('admin/userUpdate_do')}}" method="post">
    @csrf
    <input type="hidden" name="id" value="{{$data->id}}">
    <div class="layui-form-item">
        <label class="layui-form-label">用户名</label>
        <div class="layui-input-block">
            <input type="text" name="name" value="{{$data->name}}" style="width:300px;" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label">邮箱</label>
        <div class="layui-input-block">
            <input type="text" name="email" value="{{$data->email}}" style="width:300px;" required  lay-verify="required" placeholder="请输入标题" autocomplete="off" class="layui-input">
        </div>
    </div>

    @if($user->user=='超级管理员')
    <div class="layui-form-item">
        <label class="layui-form-label">管理员管理</label>
        <div class="layui-input-block">
            <input type="radio" name="user" value="2" title="管理员">
            <input type="radio" name="user" value="1" title="普通会员" checked>
        </div>
    </div>
    @endif
    <div class="layui-form-item">
        <label class="layui-form-label">会员状态</label>
        <div class="layui-input-block">
      @if($data->is_user=='正常')
            <input type="radio" name="is_user" value="1" title="正常" checked>
            <input type="radio" name="is_user" value="2" title="禁用">
      @else
                <input type="radio" name="is_user" value="1" title="正常">
                <input type="radio" name="is_user" value="2" title="禁用" checked>
     @endif
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>

<script>
    //Demo
    layui.use('form', function(){
        var form = layui.form;

        //监听提交
        // form.on('submit(formDemo)', function(data){
        //     layer.msg(JSON.stringify(data.field));
        //     return false;
        // });
    });
</script>
@endsection
