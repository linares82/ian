@extends('layouts.tabs')

@section('contenido_tab')

	<table id="dg" class="easyui-datagrid" style="width:700px;height:200px"
			toolbar="#toolbar" data-options="pageList:[50,100, 150,200], singleSelect:true,
			url:'{{route('entidad.contentListIndex', null)}}',autoRowHeight:false,pageSize:50, 
			pagination:true"
			fit="true" fitColumns="true" >
		<thead>
			<tr>
				<th field="id" sortable="true">Id</th>
				<th field="rzon_social" sortable="true">Razón Social</th>
				<th field="abreviatura" sortable="true">Abreviatura</th>
				<th field="responsable" sortable="true">responsable</th>
				<th field="rfc" sortable="true">rfc</th>
				<th field="dir1" sortable="true">Direccion 1</th>
				<th field="deleted_at" sortable="true">Eliminado</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<div>
		@if (Sentry::getUser()->hasAccess('entidades-create')) 
		{{ link_to_route('entidad.create', 'Crear', null, array('class' => 'easyui-linkbutton', 'iconCls'=>'icon-add')) }}
		@endif
		@if (Sentry::getUser()->hasAccess('entidades-edit')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-modify" plain="true" onclick="editReg()">Editar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('entidades-show')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-show" plain="true" onclick="showReg()">Mostrar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('entidades-destroy')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-removes" plain="true" onclick="removeReg()">Eliminar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('entidades-recover')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-recover" plain="true" onclick="recoverReg()">Recuperar</a>
		@endif
		</div>
		<div>
			id: <input id="idbox" class="easyui-textbox" style="width:50px">
			Razón: <input id="idrazon" class="easyui-textbox" style="width:200px">
			Responsable: <input id="idresponsable" class="easyui-textbox" style="width:150px">
			<a href="#" class="easyui-linkbutton" iconCls="icon-search" onclick="doSearch()">Buscar</a>
		</div>
	</div>
@stop
@section('js_local')

<script type="text/javascript" src="{{ asset('jeasyui/datagrid-scrollview.js')}}"></script>

<script type="text/javascript">
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
		    razon: $('#idrazon').val(),
		    responsable: $('#idresponsable').val(),
	    });
    }

    function doLimpiar(){
	    $('#dg').datagrid('load',{
		    id: 0,
	    });
    }

</script>

@stop
