<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
        
        <link rel="stylesheet" type="text/css" href="{{ asset('jeasyui/themes/metro-blue/easyui.css') }}" />
        <link rel="stylesheet" type="text/css" 
		href="{{ asset('jeasyui/themes/metro-blue/easyui.css') }}"/>
        <link rel="stylesheet" type="text/css" href="{{ asset('jeasyui/demo.css')}}" />
        <link rel="stylesheet" type="text/css" href="{{ asset('css/form.css')}}" />
        
        <title>@yield('titulo')</title>
    </head>
	<body style="font-family:sans-serif;">
		@yield('contenido1')
		
		<!--jquery easyui--> 
        <script type="text/javascript" src="{{ asset('jeasyui/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('jeasyui/jquery.easyui.min.js')}}"></script>
		
		@yield('js_local')
	</body>
</html>
