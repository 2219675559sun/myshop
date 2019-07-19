@extends('index.layout.conmmen')
@section('title', '展示')

@section('body')

	<!-- slider -->
	<div class="slider">
		
		<ul class="slides">
			<li>
				<img src="/mtore/img/slide1.jpg" alt="">
				<div class="caption slider-content  center-align">
					<h2>欢迎来到青青商城</h2>
					<h4>Lorem ipsum dolor sit amet.</h4>
					<a href="" class="btn button-default">SHOP NOW</a>
				</div>
			</li>
			<li>
				<img src="/mtore/img/slide2.jpg" alt="">
				<div class="caption slider-content center-align">
					<h2>JACKETS BUSINESS</h2>
					<h4>Lorem ipsum dolor sit amet.</h4>
					<a href="" class="btn button-default">SHOP NOW</a>
				</div>
			</li>
			<li>
				<img src="/mtore/img/slide3.jpg" alt="">
				<div class="caption slider-content center-align">
					<h2>FASHION SHOP</h2>
					<h4>Lorem ipsum dolor sit amet.</h4>
					<a href="" class="btn button-default">SHOP NOW</a>
				</div>
			</li>
		</ul>

	</div>
	<!-- end slider -->

	<!-- features -->
	<div class="features section">
		<div class="container">
			<div class="row">
				<div class="col s6">
					<div class="content">
						<div class="icon">
							<i class="fa fa-car"></i>
						</div>
						<h6>Free Shipping</h6>
						<p>Lorem ipsum dolor sit amet consectetur</p>
					</div>
				</div>
				<div class="col s6">
					<div class="content">
						<div class="icon">
							<i class="fa fa-dollar"></i>
						</div>
						<h6>Money Back</h6>
						<p>Lorem ipsum dolor sit amet consectetur</p>
					</div>
				</div>
			</div>
			<div class="row margin-bottom-0">
				<div class="col s6">
					<div class="content">
						<div class="icon">
							<i class="fa fa-lock"></i>
						</div>
						<h6>Secure Payment</h6>
						<p>Lorem ipsum dolor sit amet consectetur</p>
					</div>
				</div>
				<div class="col s6">
					<div class="content">
						<div class="icon">
							<i class="fa fa-support"></i>
						</div>
						<h6>24/7 Support</h6>
						<p>Lorem ipsum dolor sit amet consectetur</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<!-- end features -->
    <div hid="hide">
	<!-- quote -->
	<div class="section quote">
		<div class="container">
			<h4>FASHION UP TO 50% OFF</h4>
			<p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid ducimus illo hic iure eveniet</p>
		</div>
	</div>
	<!-- end quote -->

	<!-- product -->

{{--    111--}}
    <div class="section product">
        <div class="container">
            <div class="section-head">
                <h4>NEW PRODUCT</h4>
                <div class="divider-top"></div>
                <div class="divider-bottom"></div>
            </div>
            <div class="row">
            @foreach($new as $key=>$v)
                <div class="col s6">
                    <div class="content">
                        <a href="{{url('index/detail')}}?id={{$v->id}}"> <img src="{{asset('storage'.'/'.$v->goods_pic)}}" alt=""></a>
                        <h6><a href="">{{$v->goods_name}}</a></h6>
                        <div class="price">
                            ${{$v->goods_price}}
                        </div>
                        <a href="{{url('index/cart')}}?id={{$v->id}}"><button class="btn button-default">加入购物车</button></a>

                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
	<!-- end product -->

	<!-- promo -->
	<div class="promo section">
		<div class="container">
			<div class="content">
				<h4>PRODUCT BUNDLE</h4>
				<p>Lorem ipsum dolor sit amet consectetur adipisicing elit</p>
				<button class="btn button-default">SHOP NOW</button>
			</div>
		</div>
	</div>
	<!-- end promo -->

	<!-- product -->
	<div class="section product">
		<div class="container">
			<div class="section-head">
				<h4>TOP PRODUCT</h4>
				<div class="divider-top"></div>
				<div class="divider-bottom"></div>
			</div>
            <div class="row">
            @foreach($data as $key=>$v)

				<div class="col s6">
					<div class="content">
                        <a href="{{url('index/detail')}}?id={{$v->id}}"><img src="{{asset('storage'.'/'.$v->goods_pic)}}" alt=""></a>
						<h6><a href="">{{$v->goods_name}}</a></h6>
						<div class="price">
							￥{{$v->goods_price}}
						</div>
{{--                        {{$car}}--}}
                        @if($car>=1)
                            {{'已加入购物车'}}
                        @else
                        <a href="{{url('index/cart')}}?id={{$v->id}}"><button class="btn button-default">加入购物车</button></a>
					@endif
                    </div>
				</div>
            @endforeach

                </div>
			<div class="pagination-product">
				<ul>
					<li class="page">{{ $data->links() }}</li>

				</ul>
			</div>
		</div>
	</div>
	<!-- end product -->
	@endsection
@section('script')
<script>
   $(function(){
       $('.page').click(function(){
          // alert(2);
           $(this).parends('div').parend('div').attr('hid').hide();
           return false;
       });





   });

</script>
@endsection
