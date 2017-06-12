@extends('layouts.master_login2')
@section('contenido1')

<div id="main-container">
</div>
<div class="form-box" id="login-box" style="padding:5px;margin:0 auto 0 auto; width:450px;border-radius:5px;border: groove 5px #2E64FE;">
	<div class="header" style="background-color:#0040FF;color:white;padding:3px;text-align: center;">INTRODUCIR DATOS</div>
	<br/>
	{{ Form::open(array('method' => 'post', 'id'=>'login-form')) }}
		<div class="body bg-gray" style="width:400px;margin:0 auto 0 auto;">
			<div class="form-group account-username">
				<input type="text" id="username" name="username" class="form-control" style="width:100%" placeholder="Username"/>
				
			</div>
			<div class="form-group account-username account-password">
				<input type="password" id="pass" name="pass" class="form-control" style="width:100%" placeholder="Password"/>
				
			</div>  
			<br/>
			<div class="form-group">
				<input type="checkbox" id="remember" name="remember"/> Recordarme
			</div>
			<br/>
		</div>
		<div class="footer">       
			<button class="easyui-linkbutton">Iniciar Sesión</button>  
		</div>
	{{ Form::close() }}
</div>
@stop
@section('js_local')
<script type="text/javascript" src="{{ asset('/js/login.js') }}"></script>
<script type="text/javascript" src="{{ asset('/js/base.js') }}"></script>
@stop