@extends('layouts.auth')
@section('content')
<div class="login">
	<div class="logo">
		<a href="index.html">
			<!-- LOGO -->
		</a>
	</div>
	<div class='content'>
		<form class="login-form" action="" method="post">
			{{ csrf_field() }}
			<h3 class="form-title font-green">Login</h3>
			@if (session('message'))
			<div class="alert alert-danger">
				<button class="close" data-close="alert"></button>
				<span> {!! session('message') !!} </span>
			</div>
			@endif
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="glyphicon glyphicon-user"></i>
					</span>
					<label class="control-label visible-ie8 visible-ie9">Login</label>
					<input class="form-control form-control-solid placeholder-no-fix" type="text" autocomplete="off" placeholder="Login" name="login"
					 autofocus />
				</div>
			</div>
			<div class="form-group">
				<div class="input-group">
					<span class="input-group-addon">
						<i class="glyphicon glyphicon-lock"></i>
					</span>
					<label class="control-label visible-ie8 visible-ie9">Password</label>
					<input class="form-control form-control-solid placeholder-no-fix" type="password" autocomplete="off" placeholder="Hasło"
					 name="password" />
				</div>
			</div>
			<div class="form-group">
				<input name="remember" id="rememberMe" class="form-check-input" type="checkbox" value="true">
				<label class="form-check-label" for="rememberMe">Remember me</label>
			</div>
			<div class="form-group">
				<button type="submit" class="btn btn-lg btn-block green uppercase">Log In</button>
            </div>
            <div class="text-center">
                <span class="font-weight-bold"><strong>OR</strong></span>
            </div>
            <div class="form-group">
                <a href="{!!route('guest')!!}" class="btn btn-lg btn-block blue-dark uppercase">Entry as guest</a>
            </div>
		</form>
	</div>
	<div class="copyright">
	</div>
</div>
@endsection