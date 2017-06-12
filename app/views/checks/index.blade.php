@extends('layouts.tabs')

@section('contenido_tab')

	<table id="dg" class="easyui-datagrid" style="width:700px;height:200px"
			toolbar="#toolbar" data-options="pageList:[50,100, 150,200], singleSelect:true,
			url:'{{route('check.contentListIndex', null)}}',autoRowHeight:false,pageSize:50, 
			pagination:true"
			fit="true" fitColumns="true" >
		<thead>
			<tr>
				<th field="id" sortable="true">Id</th>
				<th field="cliente" sortable="true">Cliente</th>
				<th field="area" sortable="true">Area</th>
				<th field="solicitud" sortable="true">Solicitud</th>
				<th field="fec_apertura" sortable="true">F. Apertura</th>
				<th field="fec_cierre" sortable="true">F. Cierre</th>
				<th field="updated_at" sortable="true">Actualizado</th>
				<th field="deleted_at" sortable="true">Eliminado</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<div>
		@if (Sentry::getUser()->hasAccess('check-create')) 
		{{ link_to_route('check.create', 'Crear', null, array('class' => 'easyui-linkbutton', 'iconCls'=>'icon-add')) }}
		@endif
		@if (Sentry::getUser()->hasAccess('check-edit')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-modify" plain="true" onclick="editReg()">Editar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('check-show')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-show" plain="true" onclick="showReg()">Mostrar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('check-destroy')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-removes" plain="true" onclick="removeReg()">Eliminar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('check-recover')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-recover" plain="true" onclick="recoverReg()">Recuperar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('check-lineas')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-lineas" plain="true" onclick="lineas()">Lineas</a>
		@endif
		<a href="#" class="easyui-menubutton" data-options="menu:'#mm1',iconCls:'icon-pdf'">Reportes</a>
		<div id="mm1" style="width:150px;">
			<div data-options="iconCls:'icon-pdf'">
				@if (Sentry::getUser()->hasAccess('check-imprimir')) 
				<a href="#" class="easyui-linkbutton" iconCls="" plain="true" onclick="rptGeneral()">R. General</a>
				@endif
			</div>
			<div data-options="iconCls:'icon-pdf'">
				@if (Sentry::getUser()->hasAccess('check-imprimir')) 
				<a href="#" class="easyui-linkbutton" iconCls="" plain="true" onclick="dictamenGeneral()">Dictamen general</a>
				@endif
			</div>
			<div data-options="iconCls:'icon-pdf'">
				@if (Sentry::getUser()->hasAccess('check-imprimir')) 
				<a href="#" class="easyui-linkbutton" iconCls="" plain="true" onclick="Programa()">Programa</a>
				@endif
			</div>
			<div data-options="iconCls:'icon-pdf'">
				@if (Sentry::getUser()->hasAccess('check-imprimir')) 
				<a href="#" class="easyui-linkbutton" plain="true" onclick="Costos()">R. de Costos</a>
				@endif
			</div>
		</div>
		</div>
		<div>
			Id: <input id="idbox" class="easyui-textbox" style="width:80px">
			Cliente:{{ Form::select('cliente', $clientes_ls, Input::old('cliente'), array('id'=>'clientebox'))  }}
			Area:{{ Form::select('area', $areas_ls, Input::old('area'), array('id'=>'areabox'))  }}
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">Buscar</a>
		</div>
	</div>
@stop
@section('js_local')

<script type="text/javascript" src="{{ asset('jeasyui/datagrid-scrollview.js')}}"></script>

<script type="text/javascript">
	function Costos(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				url="costos/"+row.id;
				$(location).attr('href',url);
			}else{
				alert("Seleccionar registro valido");
			}
		}
	function Programa(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				url="programa/"+row.id;
				$(location).attr('href',url);
			}else{
				alert("Seleccionar registro valido");
			}
		}
	function dictamenGeneral(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				url="dictamenGeneral/"+row.id;
				$(location).attr('href',url);
			}else{
				alert("Seleccionar registro valido");
			}
		}
	function rptGeneral(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				url="rptGeneral/"+row.id;
				$(location).attr('href',url);
			}else{
				alert("Seleccionar registro valido");
			}
		}
	function showReg(){
			var row = $('#dg').datagrid('getSelected');
			if (row && row.deleted_at==null){
				url="show/"+row.id;
				$(location).attr('href',url);
			}else{
				alert("Seleccionar registro valido");
			}
		}

	function editReg(){
			var row = $('#dg').datagrid('getSelected');
			if (row && row.deleted_at==null){
				url="edit/"+row.id;
				//url={{ route('check.edit') }} + "/"+ row.id;
				$(location).attr('href',url);
			}else{
				alert("Seleccionar registro valido");
			}
		}

	function removeReg(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirmar','¿Estas seguro de eliminar este registro?',function(r){
					if (r){
						$.post('destroy/'+row.id,function(result){
							if (result.success){
								$('#dg').datagrid('reload');	// reload the user data
							} else {
								$.messager.show({	// show error message
									title: 'Error',
									msg: result.msg
								});
							}
						},'json');
					}
				});
			}else{
				alert("Seleccionar registro valido");
			}
		}
		
	function recoverReg(){
			var row = $('#dg').datagrid('getSelected');
			if (row){
				$.messager.confirm('Confirmar','¿Estas seguro de recuperar este registro?',function(r){
					if (r){
						$.post('recover/'+row.id,function(result){
							if (result.success){
								$('#dg').datagrid('reload');	// reload the user data
							} else {
								$.messager.show({	// show error message
									title: 'Error',
									msg: result.msg
								});
							}
						},'json');
					}
				});
			}else{
				alert("Seleccionar registro valido");
			}
		}

	function doSearch(){
	    $('#dg').datagrid('load',{
		    id: $('#idbox').val(),
		    cliente: $('#clientebox').val(),
		    area: $('#areabox').val(),
	    });
    }

    function doLimpiar(){
	    $('#dg').datagrid('load',{
		    id: 0,
	    });
    }

    function lineas(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			//url="check/lineas/"+row.id;
			url="{{route('check.lineas')}}"+row.id;
			/*$(location).attr('href',url);*/
			window.parent.addTab('Lineas: '+row.id, url);
		}else{
			alert("Seleccionar registro valido");
		}
	}

</script>

@stop
