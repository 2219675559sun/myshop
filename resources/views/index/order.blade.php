@extends('index.layout.conmmen')
@section('title', '确认订单')

@section('body')


    <!-- register -->
<div class="pages section">
    <div class="container">
        <div class="pages-head">
            <h3>确认订单</h3>
        </div>
        <div class="register">
            <div class="row">
                <form>
                    @foreach($cart as $k=>$v)
                    <div style="width:800px;height:100px;border:1px solid black;">
                        <img src="{{asset('storage'.'/'.$v->goods_pic)}}" width="80" alt="">
                       名称： {{$v->goods_name}}&nbsp&nbsp&nbsp&nbsp&nbsp价格：{{$v->goods_price}}
                    </div>
            @endforeach
                    <div style="width:800px;height:40px;border:1px solid #b2ff59 ;">总价：￥{{$total}}</div>
                        <a href="{{url('do_pay')}}"><div class="btn button-default">立即支付</div></a>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end register -->


@endsection
