<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1">

    <title>layout 后台大布局 - Layui</title>
    <link rel="stylesheet" href="{{asset('layui/css/layui.css')}}">
    <link rel="stylesheet" href="{{asset('page.css')}}">
    <script src="{{asset('layui/layui.js')}}"></script>
    <script src="{{asset('jquery.js')}}"></script>
</head>
<body class="layui-layout-body">
<div class="layui-layout layui-layout-admin">
    <div class="layui-header">
        <div class="layui-logo">layui 后台布局</div>
        <!-- 头部区域（可配合layui已有的水平导航） -->
        <ul class="layui-nav layui-layout-left">
            <li class="layui-nav-item"><a href="">控制台</a></li>
            <li class="layui-nav-item"><a href="">商品管理</a></li>
            <li class="layui-nav-item"><a href="">用户</a></li>
            <li class="layui-nav-item">
                <a href="javascript:;">其它系统</a>
                <dl class="layui-nav-child">
                    <dd><a href="">邮件管理</a></dd>
                    <dd><a href="">消息管理</a></dd>
                    <dd><a href="">授权管理</a></dd>
                </dl>
            </li>
        </ul>
        <ul class="layui-nav layui-layout-right">
            <li class="layui-nav-item">
                <a href="javascript:;">
                    <img src="http://t.cn/RCzsdCq" class="layui-nav-img">
                    {{Session::get('name')}}
                </a>
                <dl class="layui-nav-child">
                    <dd><a href="">基本资料</a></dd>
                    <dd><a href="">安全设置</a></dd>
                </dl>
            </li>
            @if(empty(Session::get('name')))
            <li class="layui-nav-item"><a href="{{url('admin/login')}}">登陆</a></li>
        @else
            <li class="layui-nav-item"><a href="{{url('admin/sessionout')}}">退出</a></li>
       @endif
        </ul>
    </div>

    <div class="layui-side layui-bg-black">
        <div class="layui-side-scroll">
            <!-- 左侧导航区域（可配合layui已有的垂直导航） -->
            <ul class="layui-nav layui-nav-tree"  lay-filter="test">
                <li class="layui-nav-item layui-nav-itemed">
                    <a class="" href="javascript:;">所有商品</a>
                    <dl class="layui-nav-child">
                        <dd><a href="{{url('admin/add')}}">商品添加</a></dd>
                        <dd><a href="{{url('admin/index')}}">商品列表</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;">用户管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="{{url('admin/userAdd')}}">用户添加</a></dd>
                        <dd><a href="{{url('admin/userList')}}">用户列表</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;">货物管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="{{url('goods/add')}}">货物添加</a></dd>
                        <dd><a href="{{url('goods/index')}}">货物列表</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item">
                    <a href="javascript:;">微信管理</a>
                    <dl class="layui-nav-child">
                        <dd><a href="{{url('weixin/moban')}}">模板列表</a></dd>
                        <dd><a href="{{url('weixin/index')}}">粉丝列表</a></dd>
                        <dd><a href="{{url('weixin/uploadSource')}}">添加素材</a></dd>
                        <dd><a href="{{url('weixin/source_list')}}">永久素材列表</a></dd>
                        <dd><a href="{{url('weixin/add_tag')}}">添加标签</a></dd>
                        <dd><a href="{{url('weixin/tag_index')}}">标签列表</a></dd>
                    </dl>
                </li>
                <li class="layui-nav-item"><a href="">云市场</a></li>
                <li class="layui-nav-item"><a href="">发布商品</a></li>
            </ul>
        </div>
    </div>

    <div class="layui-body">
        <!-- 内容主体区域 -->
        <div style="padding: 15px;">
            @section('body')
            @show

        </div>
    </div>

    <div class="layui-footer">
        <!-- 底部固定区域 -->
        © layui.com - 底部固定区域
    </div>
</div>
@section('script')
@show
<script>
    //JavaScript代码区域
    layui.use('element', function(){
        var element = layui.element;

    });
</script>
</body>
</html>
