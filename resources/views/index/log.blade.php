@extends('index.layout.conmmen')

@section('title', '登录')

@section('body')

	

	

	 <!-- login -->
    <div class="pages section">
        <div class="container">
            <div class="pages-head">
                <h3>登录</h3>
            </div>
            <div class="login">
                <div class="row">
                    <form class="col s12" action="{{url('index/login_do')}}">
                    	@csrf
                        <div class="input-field">
                            <input type="text" class="validate" name="name" placeholder="用户名" required>
                        </div>
                        <div class="input-field">
                            <input type="password" class="validate" name="password" placeholder="密码" required>
                        </div>
                        <a href=""><h6>忘记密码？</h6></a>
                        <input type="submit" value="登录" class="btn button-default">
                       
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!-- end login -->
    
  
@endsection

@section('script')
<script>
	$(function(){
		$('$deng').click(function(){
			alert(1);

			return false;
		});
	});

</script>
@endsection