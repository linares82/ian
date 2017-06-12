@extends('layouts.tabs')

@section('contenido_tab')

	<table id="dg" class="easyui-datagrid" style="width:700px;height:200px"
			toolbar="#toolbar" data-options="pageList:[50,100, 150,200], singleSelect:true,
			url:'{{route('aspectos_ambientale.contentListIndex', null)}}',autoRowHeight:false,pageSize:50, 
			pagination:true"
			fit="true" fitColumns="true" >
		<thead>
			<tr>
				<th field="id" sortable="true">Id</th>
				<th field="proceso" sortable="true">Proceso</th>
				<th field="area" sortable="true">Area</th>
				<th field="actividad" sortable="true">Actividad</th>
				<th field="imp_potencial" sortable="true" styler="cellStyler1">I. Potencial</th>
				<th field="imp_real" sortable="true" styler="cellStyler2">I. Real</th>
				<th field="deleted_at" sortable="true">Eliminado</th>
			</tr>
		</thead>
	</table>
	<div id="toolbar">
		<div>
		@if (Sentry::getUser()->hasAccess('aspectos_ambientale-create')) 
		{{ link_to_route('aspectos_ambientale.create', 'Crear', null, array('class' => 'easyui-linkbutton', 'iconCls'=>'icon-add')) }}
		@endif
		@if (Sentry::getUser()->hasAccess('aspectos_ambientale-edit')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-modify" plain="true" onclick="editReg()">Editar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('aspectos_ambientale-show')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-show" plain="true" onclick="showReg()">Mostrar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('aspectos_ambientale-destroy')) 
		<a href="#" class="easyui-linkbutton" iconCls="icon-removes" plain="true" onclick="removeReg()">Eliminar</a>
		@endif
		@if (Sentry::getUser()->hasAccess('aspectos_ambientale-recover')) 
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
				alert("Seleccionar registro un valido");
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
		var potencial="";
		potencial=row.imp_potencial
        if(potencial=="-"){
        	return 'background-color:#FFFFFF;color:black;';
        }else if (potencial!="C" ){
            return 'background-color:#088A08;color:white;';
        }else if(potencial=="C" ){
        	return 'background-color:#ff0000;color:white;';
        }

    }
    function cellStyler2(value,row,index){
		var d = new Date();
		var f1=new Date(d.getFullYear()+ "/" + (d.getMonth() + 1 ) + "/" + d.getDate());
		var f2 = new Date(row.fec_fin_vigencia);
		var r=f1-f2;
		/*alert("-"+row.imp_real+"-");*/
		var real="";
		real=row.imp_real;
		r=((((r/1000)/60)/60)/24)*-1;
        if(real=="-" ){
        	return 'background-color:#FFFFFF;color:black;';
        }else if (real!="C" ){
            return 'background-color:#088A08;color:white;';
        }else if(real=='C' ){
        	return 'background-color:#FF0000;color:white;';
        }
    }

</script>

@stop
