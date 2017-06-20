<!DOCTYPE html>
<html lang="es">
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
        <link rel="shortcut icon" href="{{ asset('favicon.ico') }}" />
        
        <link 
		rel="stylesheet" 
		type="text/css" 
		href = @if(isset(User::find(Sentry::getUser()->id)->Entidad->tema))
				@if(User::find(Sentry::getUser()->id)->Entidad->tema=='metro-blue')
					"{{ asset('jeasyui/themes/metro-blue/easyui.css') }}"
				@elseif(User::find(Sentry::getUser()->id)->Entidad->tema=='metro-green')
					"{{ asset('jeasyui/themes/metro-green/easyui.css') }}"
				@elseif(User::find(Sentry::getUser()->id)->Entidad->tema=='metro-orange')
					"{{ asset('jeasyui/themes/metro-orange/easyui.css') }}"
				@elseif(User::find(Sentry::getUser()->id)->Entidad->tema=='metro-red')
					"{{ asset('jeasyui/themes/metro-red/easyui.css') }}"
				@elseif(User::find(Sentry::getUser()->id)->Entidad->tema=='metro-gray')
					"{{ asset('jeasyui/themes/metro-gray/easyui.css') }}"
				@else
					"{{ asset('jeasyui/themes/bootstrap/easyui.css') }}"
				@endif
			 @endif
		/>
		 
        <link rel="stylesheet" type="text/css" href="{{ asset('jeasyui/themes/icon.css') }}" />
		<link rel="stylesheet" type="text/css" href="{{ asset('css/form.css')}}" />
        
        <title>@yield('titulo')</title>
    </head>
	<body class="easyui-layout" style="font-family:sans-serif">
			<div data-options="region:'west',split:true, title:'{{strtoupper(Sentry::getUser()->username)}} - {{strtoupper(User::find(Sentry::getUser()->id)->Entidad->abreviatura)}}'" style="width:250px;">
			 <div class="easyui-accordion" data-options="fit:true,border:true">
				<div title="CATÁLOGOS" style="overflow:auto;padding:10px;">
					<ul class="easyui-tree">  
						{{ cargaMenu(3) }}
					</ul> 
				</div>
				<div title="OPERACIÓN" style="overflow:auto;padding:10px;">
					<ul class="easyui-tree">  
						{{ cargaMenu(9) }}	
					</ul> 
				</div>
				<div title="CONSULTAS" style="overflow:auto;padding:10px;">
					<ul class="easyui-tree">  
						{{ cargaMenu(110) }}	
					</ul> 
				</div>
				<div title="ADMINISTRACIÓN" style="overflow:auto;padding:10px;">
					<ul class="easyui-tree">  
						{{ cargaMenu(1) }}
						<li> {{ link_to('user/getPerfil', 'Perfil', $attributes = array('class'=>'linktree'), $secure = null)}}</li>
					</ul> 
				</div>
				<div title="SALIR" style="padding:10px;">
					<ul class="easyui-tree">
						<a title="Salir" class="easyui-linkbutton" data-options="iconCls:'icon-exit'" href="{{ URL::route('logout2') }}"> <span class="text">Salir</span></a>
					</ul>
				</div>
			</div>
		</div>
		<div data-options="region:'center'">
			<div id="tt" class="easyui-tabs" fit="true" border="false" plain="true">
				<div title="Bienvenido">
					@yield('contenido1')
					
				</div>
			</div>
		</div
		<!--jquery easyui--> 
        <script type="text/javascript" src="{{ asset('jeasyui/jquery.min.js') }}"></script>
        <script type="text/javascript" src="{{ asset('jeasyui/jquery.easyui.min.js')}}"></script>
        <script type="text/javascript" src="{{ asset('jeasyui/locale/easyui-lang-es.js')}}" /></script>


		<script type="text/javascript">
            function addTab(title, url){
                if ($('#tt').tabs('exists', title)){
                    $('#tt').tabs('select', title);
                } else {
                    var content = '<iframe scrolling="auto" frameborder="0" src="'+url+'" style="width:100%;height:100%;"></iframe>';
                    $('#tt').tabs('add',{
                    title:title,
                    content:content,
                    closable:true
                });
                }
            } 

		</script>

		@yield('js_local')
	</body>
</html>
