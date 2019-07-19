@extends('index.layout.conmmen')
@section('title', '详情')

@section('body')


<!-- shop single -->
<div class="pages section">
    <div class="container">
        <div class="shop-single">
            <img src="{{asset('storage'.'/'.$data->goods_pic)}}" alt="">
            <h5>{{$data->goods_name}}</h5>
            <div class="price">￥{{$data->goods_price}} <span>$28</span></div>
            <p>{{$data->goods_centent}}</p>
            @if($car>=1)
                {{'已加入购物车'}}
            @else
            <a href="{{url('index/cart')}}?id={{$data->id}}"> <button type="button" class="btn button-default"> 加入购物车</button></a>
       @endif
        </div>
        <div class="review">
            <h5>1 reviews</h5>
            <div class="review-details">
                <div class="row">
                    <div class="col s3">
                        <img src="/mstore/img/user-comment.jpg" alt="" class="responsive-img">
                    </div>
                    <div class="col s9">
                        <div class="review-title">
                            <span><strong>John Doe</strong> | Juni 5, 2016 at 9:24 am | <a href="">Reply</a></span>
                        </div>
                        <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Perferendis accusantium corrupti asperiores et praesentium dolore.</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="review-form">
            <div class="review-head">
                <h5>Post Review in Below</h5>
                <p>Lorem ipsum dolor sit amet consectetur*</p>
            </div>
            <div class="row">
                <form class="col s12 form-details">
                    <div class="input-field">
                        <input type="text" required class="validate" placeholder="NAME">
                    </div>
                    <div class="input-field">
                        <input type="email" class="validate" placeholder="EMAIL" required>
                    </div>
                    <div class="input-field">
                        <input type="text" class="validate" placeholder="SUBJECT" required>
                    </div>
                    <div class="input-field">
                        <textarea name="textarea-message" id="textarea1" cols="30" rows="10" class="materialize-textarea" class="validate" placeholder="YOUR REVIEW"></textarea>
                    </div>
                    <div class="form-button">
                        <div class="btn button-default">POST REVIEW</div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
<!-- end shop single -->

<!-- loader -->
<div id="fakeLoader"></div>
<!-- end loader -->
@endsection
