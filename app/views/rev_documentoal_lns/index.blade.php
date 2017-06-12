@extends('layouts.tabs')

@section('contenido_tab')

	<table id="dg" class="easyui-datagrid" style="width:700px;height:200px"
			toolbar="#toolbar" data-options="pageList:[50,100, 150,200], singleSelect:true,
			url:'{{route('rev_documentoal_ln.contentListIndex', array('rev_documental'=>$rev_documental))}}',autoRowHeight:false,pageSize:50, 
			pagination:true"
			fit="true" fitColumns="true" >
		<thead>
			<tr>
				<th field="tpo_doc" sortable="true">T. Documento</th>
				<th field="r_documento" sortable="true">Documento</th>
				<th field="archivo" sortable="true">Archivo</th>
				<th field="estatus" sortable="true">Estatus</th>
				<th field="dias_avertencia1" sortable="true" hidden='true'>Advertencia 1</th>
				<th field="dias_avertencia2" sortable="true" hidden='true'>Advertencia 2</th>
				<th field="dias_avertencia3" sortable="true" hidden='true'>Advertencia 3</th>
				<th field="dias_restantes_cumplimiento" sortable="true" styler="cellStyler1">Dias Restantes</th>
				<th field="fec_cumplimiento" sortable="true">F. Cumplimiento</th>
				<th field="dias_restantes_vencimiento" sortable="true" styler="cellStyler2">Dias Restantes</th>
				<th field="fec_vencimiento" sortable="true">F. Vencimiento</th>
				<th field="importancia" sortable="true">Importancia</th>
				<th field="deleted_at" sortable="true">Eliminado</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<div>
		@if (Sentry::getUser()->hasAccess('rev_documentoal_ln-create')) 
		{{ link_to_route('rev_documentoal_ln.create', 'Crear', array('id'=>$rev_documental), array('class' => 'easyui-linkbutton', 'iconCls'=>'icon-add')) }}
		@endif
		@if (Sentry::getUser()->hasAccess('rev_documentoal_ln-edit')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-modify" plain="true" onclick="editReg()">Editar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('rev_documentoal_ln-show')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-show" plain="true" onclick="showReg()">Mostrar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('rev_documentoal_ln-destroy')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-removes" plain="true" onclick="removeReg()">Eliminar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('rev_documentoal_ln-recover')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-recover" plain="true" onclick="recoverReg()">Recuperar</a>
		@endif
		</div>
		<div>
			id: <input id="idbox" class="easyui-textbox" style="width:80px">
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
	    });
    }

    function doLimpiar(){
	    $('#dg').datagrid('load',{
		    id: 0,
	    });
    }

    function cellStyler1(value,row,index){
		var d = new Date();
		var f1=new Date(d.getFullYear()+ "/" + (d.getMonth() + 1 ) + "/" + d.getDate());
		var f2 = new Date(row.fec_fin_vigencia);
		var r=f1-f2;
		r=((((r/1000)/60)/60)/24)*-1;
        if (parseInt(row.dias_restantes_cumplimiento) > parseInt(row.dias_advertencia1)){
            return 'background-color:#088A08;color:white;';
        }else if(parseInt(row.dias_restantes_cumplimiento)<=parseInt(row.dias_advertencia1) &
        		parseInt(row.dias_restantes_cumplimiento)>parseInt(row.dias_advertencia2) ){
        	 return 'background-color:#F7FE2E;color:black;';
        }else if(parseInt(row.dias_restantes_cumplimiento)<=parseInt(row.dias_advertencia2) &
        		parseInt(row.dias_restantes_cumplimiento)>parseInt(row.dias_advertencia3)){
        	return 'background-color:#FE642E;color:white;';
        }else if(parseInt(row.dias_restantes_cumplimiento)<=parseInt(row.dias_advertencia3) &
        		parseInt(row.dias_restantes_cumplimiento)>0){
        	return 'background-color:#ff0000;color:white;';
        }
    }

    function cellStyler2(value,row,index){
		var d = new Date();
		var f1=new Date(d.getFullYear()+ "/" + (d.getMonth() + 1 ) + "/" + d.getDate());
		var f2 = new Date(row.fec_fin_vigencia);
		var r=f1-f2;
		r=((((r/1000)/60)/60)/24)*-1;
        if (parseInt(row.dias_restantes_vencimiento) > parseInt(row.dias_advertencia1)){
            return 'background-color:#088A08;color:white;';
        }else if(parseInt(row.dias_restantes_vencimiento)<=parseInt(row.dias_advertencia1) &
        		parseInt(row.dias_restantes_vencimiento)>parseInt(row.dias_advertencia2) ){
        	 return 'background-color:#F7FE2E;color:black;';
        }else if(parseInt(row.dias_restantes_vencimiento)<=parseInt(row.dias_advertencia2) &
        		parseInt(row.dias_restantes_vencimiento)>parseInt(row.dias_advertencia3)){
        	return 'background-color:#FE642E;color:white;';
        }else if(parseInt(row.dias_restantes_vencimiento)<=parseInt(row.dias_advertencia3) &
        		parseInt(row.dias_restantes_vencimiento)>0){
        	return 'background-color:#ff0000;color:white;';
        }
    }

</script>

@stop
