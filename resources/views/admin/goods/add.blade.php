@extends('admin.layout.conmmen')
@section('body')
<form class="layui-form" action="{{url('goods/add_do')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="layui-form-item">
        <label class="layui-form-label" style="width:100px;">商品名称</label>
        <div class="layui-input-block">
            <input type="text" name="name" style="width:500px;" required  lay-verify="required" placeholder="请输入商品名称" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" style="width:100px;">商品图片</label>
        <div class="layui-input-inline">
            <input type="file" name="image" style="width:500px;" required lay-verify="required" placeholder="请输入商品图片" autocomplete="off" class="layui-input">
        </div>
    </div>
    <div class="layui-form-item">
        <label class="layui-form-label" style="width:100px;">商品数量</label>
        <div class="layui-input-block">
            <input type="number" name="number" style="width:500px;" required  lay-verify="required" placeholder="请输入商品数量" autocomplete="off" class="layui-input">
        </div>
    </div>

    <div class="layui-form-item">
        <div class="layui-input-block">
            <button class="layui-btn" lay-submit lay-filter="formDemo">立即提交</button>
            <button type="reset" class="layui-btn layui-btn-primary">重置</button>
        </div>
    </div>
</form>
@endsection
@section('script')
<script>
    //Demo
    layui.use('form', function(){
        var form = layui.form;

        //监听提交
    //     form.on('submit(formDemo)', function(data){
    //         layer.msg(JSON.stringify(data.field));
    //         return false;
    //     });
    // });
</script>
@endsection

