@extends('index.layout.conmmen')
@section('title', '订单详情')

@section('body')

    <!-- cart -->
<div class="cart section">
    <div class="container">
        <div class="pages-head">
            <h3>订单详情</h3>
        </div>

        @foreach($order as $k=>$v)
        <div class="content">
            <div class="cart-1">

                <div class="row">
                    <div class="col s5">
                        <h5>订单编号</h5>
                    </div>
                    <div class="col s7">
                        <h5><a href="">{{$v['oid']}}</a></h5>
                    </div>
                </div>
                <div class="row">
                    <div class="col s5">
                        <h5>订单状态</h5>
                    </div>
                    <div class="col s7">
                        <h5><a href="">{{$v['state']}}</a></h5>
                    </div>
                </div>

                <div class="row">
                    <div class="col s5">
                        <h5>订单金额</h5>
                    </div>
                    <div class="col s7">
                        <h5>￥{{$v['pay_money']}}</h5>
                    </div>
                </div>
                @if($v['state']==1)
                <div class="row">
                    <div class="col s5">
                        <h5>请在时间有效期内支付订单</h5>
                    </div>

                    <div class="col s7">
                        <h5>  @if(strtotime($v['end_time'])<=time()){{'该订单已过期'}}@endif</h5>
                    </div>
                </div>
                @endif
                @if(strtotime($v['end_time'])>=time())
                @if($v['state']==1)
                    <div class="row">
                        <div class="col s5">
                            <a href="{{url('pay_order')}}?oid={{$v['oid']}}"><h5>去支付</h5></a>
                        </div>

                    </div>
                    @endif
                @endif

                <div class="row">
                    <div class="col s5">
                        <h5>操作</h5>
                    </div>
                    <div class="col s7">
                        <h5><i class="fa fa-trash"></i></h5>
                    </div>
                </div>
            </div>

        </div>
    @endforeach
    </div>
</div>
<!-- end cart -->

@endsection
