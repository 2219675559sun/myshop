@extends('index.layout.conmmen')
@section('title', '注册')
<body>
	@section('body')
	

	<!-- register -->
	<div class="pages section">
		<div class="container">
			<div class="pages-head">
				<h3>注册</h3>
			</div>
			<div class="register">
				<div class="row">
					<form class="col s12" action="{{url('index/logadd_do')}}">
					

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif
@csrf
						<div class="input-field">
							<input type="text" name="name" class="validate" placeholder="用户名" required>
						</div>
						<div class="input-field">
							<input type="email" name="email" placeholder="邮箱" class="validate" required>
						</div>
						<div class="input-field">
							<input type="password" name="password" placeholder="密码" class="validate" required>
						</div>
						<div>
						<input type="submit" value="注册" class="btn button-default">
						</div>
					</form>
				</div>
			</div>
		</div>
	</div>
	<!-- end register -->
	

	<!-- loader -->
	<div id="fakeLoader"></div>
	<!-- end loader -->
	
@endsection
