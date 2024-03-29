@extends('layouts.tabs')

@section('contenido_tab')

	<table id="dg" class="easyui-datagrid" style="width:700px;height:200px"
			toolbar="#toolbar" data-options="pageList:[50,100, 150,200], singleSelect:true,
			url:'{{route('m_mantenimiento.contentListIndex', null)}}',autoRowHeight:false,pageSize:50, 
			pagination:true"
			fit="true" fitColumns="true" >
		<thead>
			<tr>
				<th field="id" sortable="true">No. Orden</th>
				<th field="objetivo" sortable="true">Equipo</th>
				<th field="subequipo" sortable="true">Subequipo</th>
				<th field="descripcion" sortable="true">Descripcion</th>
				<th field="estatus" sortable="true">Estatus</th>
				<th field="deleted_at" sortable="true">Eliminado</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<div>
		@if (Sentry::getUser()->hasAccess('m_mantenimiento-create')) 
		{{ link_to_route('m_mantenimiento.create', 'Crear', null, array('class' => 'easyui-linkbutton', 'iconCls'=>'icon-add')) }}
		@endif
		@if (Sentry::getUser()->hasAccess('m_mantenimiento-edit')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-modify" plain="true" onclick="editReg()">Editar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('m_mantenimiento-show')) 
		<!--<a href="#" class="easyui-linkbutton" iconCls="icon-show" plain="true" onclick="showReg()">Mostrar</a>-->
		@endif
		@if (Sentry::getUser()->hasAccess('m_mantenimiento-destroy')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-removes" plain="true" onclick="removeReg()">Eliminar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('m_mantenimiento-recover')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-recover" plain="true" onclick="recoverReg()">Recuperar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('m_mantenimiento-formato')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-pdf" plain="true" onclick="showImp()">Formato</a>
		@endif
		</div>
		<div>
			id: <input id="idbox" class="easyui-textbox" style="width:80px">
			Equipo: {{ Form::select('equipobox', $objetivos_ls, null, array('id'=>'equipobox'))  }}
			Subequipo: {{ Form::select('subequipobox', $subequipos_ls, null, array('id'=>'subequipobox'))  }}
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">Buscar</a>
		</div>
	</div>
@stop
@section('js_local')

<script type="text/javascript" src="{{ asset('jeasyui/datagrid-scrollview.js')}}"></script>

<script type="text/javascript">
	function showImp(){
		var row = $('#dg').datagrid('getSelected');
		if (row){
			url="rptFormato/"+row.id;
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
				alert("Seleccionar registro");
			}
		}

	function editReg(){
			var row = $('#dg').datagrid('getSelected');
			if (row && row.deleted_at==null){
				url="edit/"+row.id;
				$(location).attr('href',url);
			}else{
				alert("Seleccionar registro");
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
				alert("Seleccionar registro");
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
				alert("Seleccionar registro");
			}
		}

	function doSearch(){
	    $('#dg').datagrid('load',{
		    id: $('#idbox').val(),
			equipo: $('#equipobox').val(),
			subequipo: $('#subequipobox').val(),
	    });
    }

    function doLimpiar(){
	    $('#dg').datagrid('load',{
		    id: 0,
	    });
    }

</script>

@stop
