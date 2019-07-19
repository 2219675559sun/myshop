@extends('admin.layout.conmmen')
@section('body')
    <form class="layui-form" action="{{url('admin/add_do')}}" method="post" id="myform" enctype="multipart/form-data">
        @csrf
        <div class="layui-form-item">
            <label class="layui-form-label" style="width:100px;">商品名称</label>
            <div class="layui-input-block">
                <input type="text" name="goods_name" required style="width:500px;" lay-verify="required" placeholder="请输入商品名称" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label" style="width:100px;">商品图片</label>
            <div class="layui-input-inline">
                <input type="file" name="goods_pic" style="width:500px;" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label" style="width:100px;">商品价格</label>
            <div class="layui-input-inline">
                <input type="text" name="goods_price" style="width:500px;" required lay-verify="required" placeholder="请输入商品价格" autocomplete="off" class="layui-input">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label" style="width:100px;">是否上架</label>
            <div class="layui-input-block">
                <input type="radio" name="is_up" value="1" title="是" checked>
                <input type="radio" name="is_up" value="2" title="否">
            </div>
        </div>
        <div class="layui-form-item">
            <label class="layui-form-label" style="width:100px;">是否新品</label>
            <div class="layui-input-block">
                <input type="radio" name="is_new" value="1" title="是" checked>
                <input type="radio" name="is_new" value="2" title="否">
            </div>
        </div>
        <div class="layui-form-item layui-form-text">
            <label class="layui-form-label" style="width:100px;">商品描述</label>
            <div class="layui-input-block">
                <textarea name="goods_centent" placeholder="请输入内容" class="layui-textarea"></textarea>
            </div>
        </div>
        <div class="layui-form-item">
            <div class="layui-input-block">
                <input type="submit" value="立即提交" class="layui-btn" id="submit">
                <button type="reset" class="layui-btn layui-btn-primary">重置</button>
            </div>
        </div>
    </form>

    <script>

        //Demo
        layui.use('form', function(){
            var form = layui.form;
            //监听提交
        });
        // $(function(){
        //   $('#myform').submit('#submit',function(){
        //       var data=$('#myform').serialize();
        //       console.log(data);
        //
        //       return false;
        //   });
        //
        // });
    </script>


@endsection
